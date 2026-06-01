<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    if (Auth::check() && Auth::user()->isAdmin()) {
        return redirect('/admin');
    }

    $products = App\Models\Product::with('category')->take(4)->get();
    $services = App\Models\Service::take(6)->get();

    return view('home', ['products' => $products, 'services' => $services]);
})->name('home');

Route::get('/register', function () {
    return view('register');
});

Route::post('/register', function (Illuminate\Http\Request $request) {
    $data = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    $user = App\Models\User::create([
        'name'     => $data['name'],
        'email'    => $data['email'],
        'password' => Hash::make($data['password']),
    ]);

    return 'Kayıt başarılı! Hoş geldin ' . $user->name;
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/')->with('success', 'Giriş başarılı!');
    }

    return back()->withErrors([
        'email' => 'E-posta veya şifre hatalı.',
    ]);
});

Route::get('/products', function () {
    $products = App\Models\Product::with('category')->get();
    return view('products', ['products' => $products]);
});

Route::get('/products/{id}', function ($id) {
    $product = App\Models\Product::with('category')->findOrFail($id);
    return view('product-detail', ['product' => $product]);
});

Route::get('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
});

// ============ SEPET ============

Route::post('/cart/add/{id}', function ($id) {
    if (!Auth::check()) {
        return response()->json(['error' => 'login'], 401);
    }

    $product = App\Models\Product::findOrFail($id);

    $cartItem = App\Models\CartItem::where('user_id', Auth::id())
        ->where('product_id', $id)
        ->first();

    if ($cartItem) {
        $cartItem->quantity = $cartItem->quantity + 1;
        $cartItem->save();
    } else {
        App\Models\CartItem::create([
            'user_id'    => Auth::id(),
            'product_id' => $id,
            'quantity'   => 1,
        ]);
    }

    $cartCount = App\Models\CartItem::where('user_id', Auth::id())->sum('quantity');

    return response()->json(['success' => true, 'cartCount' => $cartCount]);
})->name('cart.add');

Route::get('/cart', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }

    $cartItems = App\Models\CartItem::with('product')
        ->where('user_id', Auth::id())
        ->get();

    $total = 0;
    foreach ($cartItems as $item) {
        $total = $total + ($item->product->price * $item->quantity);
    }

    return view('cart', ['cartItems' => $cartItems, 'total' => $total]);
})->name('cart');

Route::post('/cart/remove/{id}', function ($id) {
    if (!Auth::check()) {
        return redirect('/login');
    }

    $cartItem = App\Models\CartItem::where('id', $id)
        ->where('user_id', Auth::id())
        ->first();

    if ($cartItem) {
        $cartItem->delete();
    }

    return redirect('/cart')->with('success', 'Ürün sepetten çıkarıldı.');
})->name('cart.remove');

// ============ SİPARİŞ ============

Route::post('/order/create', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }

    $user = Auth::user();

    $cartItems = App\Models\CartItem::with('product')
        ->where('user_id', $user->id)
        ->get();

    if ($cartItems->count() == 0) {
        return redirect('/cart')->with('error', 'Sepetiniz boş.');
    }

    $total = 0;
    foreach ($cartItems as $item) {
        $total = $total + ($item->product->price * $item->quantity);
    }

    $balance = $user->balance;
    if ($balance >= $total) {
        $balanceUsed = $total;
        $cardAmount = 0;
    } else {
        $balanceUsed = $balance;
        $cardAmount = $total - $balance;
    }

    $order = App\Models\Order::create([
        'user_id'      => $user->id,
        'total_amount' => $total,
        'balance_used' => $balanceUsed,
        'card_amount'  => $cardAmount,
        'status'       => 'pending',
    ]);

    foreach ($cartItems as $item) {
        App\Models\OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $item->product_id,
            'quantity'   => $item->quantity,
            'unit_price' => $item->product->price,
        ]);

        $product = $item->product;
        $product->stock = $product->stock - $item->quantity;
        $product->save();
    }

    $user->balance = $user->balance - $balanceUsed;
    $user->save();

    App\Models\CartItem::where('user_id', $user->id)->delete();

    return redirect('/orders')->with('success', 'Siparişiniz başarıyla oluşturuldu!');
})->name('order.create');

Route::get('/orders', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }

    $orders = App\Models\Order::with('items.product')
        ->where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

    return view('orders', ['orders' => $orders]);
})->name('orders');

// ============ RANDEVU ============

Route::get('/appointment', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }

    $barbers = App\Models\Barber::where('status', 'active')->get();
    $services = App\Models\Service::all();

    return view('appointment', ['barbers' => $barbers, 'services' => $services]);
})->name('appointment');

Route::post('/appointment/create', function (Illuminate\Http\Request $request) {
    if (!Auth::check()) {
        return redirect('/login');
    }

    $data = $request->validate([
        'barber_id'        => 'required|exists:barbers,id',
        'service_id'       => 'required|exists:services,id',
        'appointment_date' => 'required|date',
        'appointment_time' => 'required',
    ]);

    $exists = App\Models\Appointment::where('barber_id', $data['barber_id'])
        ->where('appointment_date', $data['appointment_date'])
        ->where('appointment_time', $data['appointment_time'])
        ->where('status', '!=', 'cancelled')
        ->first();

    if ($exists) {
        return back()->with('error', 'Bu berber seçtiğiniz tarih ve saatte dolu. Lütfen başka bir saat seçin.');
    }

    App\Models\Appointment::create([
        'user_id'          => Auth::id(),
        'barber_id'        => $data['barber_id'],
        'service_id'       => $data['service_id'],
        'appointment_date' => $data['appointment_date'],
        'appointment_time' => $data['appointment_time'],
        'status'           => 'pending',
    ]);

    return redirect('/my-appointments')->with('success', 'Randevunuz başarıyla oluşturuldu!');
})->name('appointment.create');

Route::get('/my-appointments', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }

    $appointments = App\Models\Appointment::with(['barber', 'service'])
        ->where('user_id', Auth::id())
        ->orderBy('appointment_date', 'desc')
        ->get();

    return view('my-appointments', ['appointments' => $appointments]);
})->name('my-appointments');

Route::post('/appointment/cancel/{id}', function ($id) {
    if (!Auth::check()) {
        return redirect('/login');
    }

    $appointment = App\Models\Appointment::where('id', $id)
        ->where('user_id', Auth::id())
        ->first();

    if ($appointment) {
        $appointment->status = 'cancelled';
        $appointment->save();
    }

    return redirect('/my-appointments')->with('success', 'Randevunuz iptal edildi.');
})->name('appointment.cancel');

// ============ ADMIN ============

Route::get('/admin', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }
    if (!Auth::user()->isAdmin()) {
        return 'Bu sayfaya sadece yöneticiler girebilir. <a href="/">Ana sayfa</a>';
    }

   $products = App\Models\Product::with('category')->get();
    $categories = App\Models\Category::all();
    $userCount = App\Models\User::count();
    $orderCount = App\Models\Order::count();
    $appointmentCount = App\Models\Appointment::count();

    $orders = App\Models\Order::with('user')->orderBy('created_at', 'desc')->get();
    $appointments = App\Models\Appointment::with(['user', 'barber', 'service'])
        ->orderBy('created_at', 'desc')->get();

    return view('admin', [
       'products'         => $products,
        'categories'       => $categories,
        'userCount'        => $userCount,
        'orderCount'       => $orderCount,
        'appointmentCount' => $appointmentCount,
        'orders'           => $orders,
        'appointments'     => $appointments,
    ]);
});

Route::post('/admin/order/{id}/status', function (Illuminate\Http\Request $request, $id) {
    if (!Auth::check() || !Auth::user()->isAdmin()) {
        return redirect('/login');
    }

    $order = App\Models\Order::findOrFail($id);
    $order->status = $request->input('status');
    $order->save();

    return redirect('/admin')->with('success', 'Sipariş durumu güncellendi.');
})->name('admin.order.status');

Route::post('/admin/appointment/{id}/status', function (Illuminate\Http\Request $request, $id) {
    if (!Auth::check() || !Auth::user()->isAdmin()) {
        return redirect('/login');
    }

    $appointment = App\Models\Appointment::findOrFail($id);
    $appointment->status = $request->input('status');
    $appointment->save();

    return redirect('/admin')->with('success', 'Randevu durumu güncellendi.');
})->name('admin.appointment.status');
// İletişim sayfası (hava durumu + harita)
Route::get('/contact', function () {
    $weather = null;
    $apiKey = env('OPENWEATHER_API_KEY');

    try {
        $response = Illuminate\Support\Facades\Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q'     => 'Kocaeli,TR',
            'appid' => $apiKey,
            'units' => 'metric',
            'lang'  => 'tr',
        ]);

        if ($response->successful()) {
            $weather = $response->json();
        }
    } catch (\Exception $e) {
        $weather = null;
    }

    return view('contact', ['weather' => $weather]);
})->name('contact');
// ==================== ADMIN ÜRÜN CRUD ====================

// Ürün ekle
Route::post('/admin/product/create', function (Illuminate\Http\Request $request) {
    if (!Auth::check() || !Auth::user()->isAdmin()) {
        return redirect('/');
    }
    $data = $request->validate([
        'name'        => 'required',
        'category_id' => 'required|exists:categories,id',
        'price'       => 'required|numeric',
        'stock'       => 'required|integer',
        'description' => 'nullable',
    ]);
    App\Models\Product::create([
        'name'        => $data['name'],
        'category_id' => $data['category_id'],
        'price'       => $data['price'],
        'stock'       => $data['stock'],
        'description' => $data['description'] ?? '',
        'status'      => 'active',
    ]);
    return redirect('/admin')->with('success', 'Ürün eklendi.');
})->name('admin.product.create');

// Ürün düzenle
Route::post('/admin/product/{id}/update', function (Illuminate\Http\Request $request, $id) {
    if (!Auth::check() || !Auth::user()->isAdmin()) {
        return redirect('/');
    }
    $product = App\Models\Product::findOrFail($id);
    $data = $request->validate([
        'name'        => 'required',
        'category_id' => 'required|exists:categories,id',
        'price'       => 'required|numeric',
        'stock'       => 'required|integer',
        'description' => 'nullable',
    ]);
    $product->update([
        'name'        => $data['name'],
        'category_id' => $data['category_id'],
        'price'       => $data['price'],
        'stock'       => $data['stock'],
        'description' => $data['description'] ?? $product->description,
    ]);
    return redirect('/admin')->with('success', 'Ürün güncellendi.');
})->name('admin.product.update');

// Ürün sil
Route::post('/admin/product/{id}/delete', function ($id) {
    if (!Auth::check() || !Auth::user()->isAdmin()) {
        return redirect('/');
    }
    $product = App\Models\Product::find($id);
    if ($product) {
        $product->delete();
    }
    return redirect('/admin')->with('success', 'Ürün silindi.');
})->name('admin.product.delete');