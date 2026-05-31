<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->isAdmin()) {
            return redirect('/admin');
        }
        return 'Hoş geldin, ' . Auth::user()->name . '! 🎉 — <a href="/products">Ürünler</a> | <a href="/logout">Çıkış</a>';
    }
    return 'BarberStore. <a href="/login">Giriş</a> | <a href="/register">Kayıt ol</a> | <a href="/products">Ürünler</a>';
});

Route::get('/register', function () {
    return view('register');
});
Route::post('/register', function (Illuminate\Http\Request $request) {
    // 1. Gelen veriyi kontrol et (doğrulama)
    $data = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    // 2. Kullanıcıyı veritabanına kaydet
    $user = App\Models\User::create([
        'name'     => $data['name'],
        'email'    => $data['email'],
        'password' => Hash::make($data['password']),
    ]);

    // 3. Başarı mesajı
    return 'Kayıt başarılı! Hoş geldin ' . $user->name;
});
// Giriş sayfasını göster
Route::get('/login', function () {
    return view('login');
})->name('login');

// Giriş işlemini yap
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
Route::get('/admin', function () {
    // Giriş yapmış mı?
    if (!Auth::check()) {
        return redirect('/login');
    }
    // Admin mi?
    if (!Auth::user()->isAdmin()) {
        return 'Bu sayfaya sadece yöneticiler girebilir. <a href="/">Ana sayfa</a>';
    }

    $products = App\Models\Product::with('category')->get();
    $userCount = App\Models\User::count();
    $orderCount = App\Models\Order::count();

    return view('admin', [
        'products'   => $products,
        'userCount'  => $userCount,
        'orderCount' => $orderCount,
    ]);
});
Route::get('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
});