<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BarberStore')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background-color:#1a1a1a; font-family:'Poppins',sans-serif; color:#f5f2ea; }
        .navbar-custom { background-color:#222220; border-bottom:2px solid #c8962b; padding:16px 0; }
        .navbar-custom .brand { font-size:22px; font-weight:600; color:#f5f2ea; text-decoration:none; }
        .navbar-custom .brand i { color:#c8962b; }
        .navbar-custom a.nav-link-custom { color:#a8a6a0; text-decoration:none; margin-left:20px; font-size:14px; }
        .navbar-custom a.nav-link-custom:hover { color:#c8962b; }
        .page-title { font-size:28px; font-weight:600; margin:32px 0 8px; }
        .page-subtitle { color:#888780; font-size:14px; margin-bottom:32px; }
        .gold { color:#c8962b; }
        .btn-gold { background-color:#c8962b; color:#1a1a1a; border:none; border-radius:8px; padding:8px 16px; font-weight:500; }
        .btn-gold:hover { background-color:#b8862b; }
    </style>
    @stack('styles')
</head>
<body>

    <div class="navbar-custom">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="/" class="brand"><i class="bi bi-scissors"></i> BARBERSTORE</a>
            <div class="d-flex align-items-center">
                <a href="/products" class="nav-link-custom">Ürünler</a>
                <a href="/contact" class="nav-link-custom">İletişim</a>
                @auth
                    <a href="/appointment" class="nav-link-custom">Randevu Al</a>
                    <a href="/my-appointments" class="nav-link-custom">Randevularım</a>
                    <a href="/orders" class="nav-link-custom">Siparişlerim</a>
                    @php
                        $cartCount = \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity');
                    @endphp
                    <a href="/cart" class="nav-link-custom" style="position:relative;">
                        <i class="bi bi-cart3" style="font-size:20px;"></i>
                        <span id="cart-badge" style="position:absolute; top:-8px; right:-12px; background-color:#c8962b; color:#1a1a1a; font-size:11px; font-weight:600; border-radius:50%; padding:2px 7px; {{ $cartCount > 0 ? '' : 'display:none;' }}">{{ $cartCount }}</span>
                    </a>
                    <a href="/logout" class="nav-link-custom">Çıkış</a>
                @else
                    <a href="/login" class="nav-link-custom">Giriş</a>
                    <a href="/register" class="nav-link-custom">Kayıt Ol</a>
                @endauth
            </div>
        </div>
    </div>

    <div class="container" style="min-height:calc(100vh - 250px);">
        @yield('content')
    </div>

    <footer style="background-color:#222220; border-top:2px solid #c8962b; margin-top:48px; padding:36px 0 24px;">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div style="font-size:20px; font-weight:600; color:#f5f2ea;"><i class="bi bi-scissors" style="color:#c8962b;"></i> BARBERSTORE</div>
                    <div style="font-size:13px; color:#888780; margin-top:10px; line-height:1.7;">Premium berber ve bakım ürünleri, profesyonel randevu hizmeti. Tarzını bizimle yansıt.</div>
                </div>
                <div class="col-md-2">
                    <div style="font-size:13px; color:#c8962b; letter-spacing:1px; margin-bottom:14px;">MENÜ</div>
                    <a href="/" style="display:block; color:#a8a6a0; text-decoration:none; font-size:13px; margin-bottom:8px;">Ana Sayfa</a>
                    <a href="/products" style="display:block; color:#a8a6a0; text-decoration:none; font-size:13px; margin-bottom:8px;">Ürünler</a>
                    <a href="/appointment" style="display:block; color:#a8a6a0; text-decoration:none; font-size:13px; margin-bottom:8px;">Randevu</a>
                    <a href="/contact" style="display:block; color:#a8a6a0; text-decoration:none; font-size:13px;">İletişim</a>
                </div>
                <div class="col-md-3">
                    <div style="font-size:13px; color:#c8962b; letter-spacing:1px; margin-bottom:14px;">İLETİŞİM</div>
                    <div style="font-size:13px; color:#888780; margin-bottom:8px;"><i class="bi bi-geo-alt"></i> Kocaeli, Türkiye</div>
                    <div style="font-size:13px; color:#888780; margin-bottom:8px;"><i class="bi bi-telephone"></i> 0500 000 00 00</div>
                    <div style="font-size:13px; color:#888780;"><i class="bi bi-envelope"></i> info@barberstore.com</div>
                </div>
                <div class="col-md-3">
                    <div style="font-size:13px; color:#c8962b; letter-spacing:1px; margin-bottom:14px;">SOSYAL MEDYA</div>
                    <div style="display:flex; gap:12px;">
                        <a href="https://instagram.com" target="_blank" style="color:#c8962b; font-size:20px;"><i class="bi bi-instagram"></i></a>
                        <a href="https://facebook.com" target="_blank" style="color:#c8962b; font-size:20px;"><i class="bi bi-facebook"></i></a>
                        <a href="https://youtube.com" target="_blank" style="color:#c8962b; font-size:20px;"><i class="bi bi-youtube"></i></a>
                        <a href="https://wa.me/905000000000" target="_blank" style="color:#c8962b; font-size:20px;"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <div style="border-top:0.5px solid #3a3a38; margin-top:28px; padding-top:20px; text-align:center; font-size:12px; color:#5f5e5a;">
                © 2026 BarberStore · Hamza Akdemir · Kocaeli Üniversitesi TBL304 Web Programlama Projesi
            </div>
        </div>
    </footer>

</body>
</html>