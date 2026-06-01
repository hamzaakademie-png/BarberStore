@extends('layouts.app')

@section('title', 'BarberStore - Premium Berber & Bakım')

@push('styles')
<style>
    .hero { background:linear-gradient(rgba(26,26,26,0.85), rgba(26,26,26,0.95)), #1a1a1a; border:0.5px solid #3a3a38; border-radius:16px; padding:64px 48px; text-align:center; margin-top:32px; }
    .hero .tagline { font-size:13px; letter-spacing:3px; color:#c8962b; font-weight:500; }
    .hero h1 { font-size:44px; font-weight:600; color:#f5f2ea; margin:12px 0; }
    .hero p { font-size:16px; color:#a8a6a0; max-width:560px; margin:0 auto 28px; line-height:1.7; }
    .hero .btn-hero { background-color:#c8962b; color:#1a1a1a; padding:14px 32px; border-radius:8px; font-weight:600; text-decoration:none; font-size:15px; letter-spacing:1px; display:inline-block; }
    .hero .btn-hero:hover { background-color:#b8862b; }
    .section-title { font-size:26px; font-weight:600; color:#f5f2ea; margin:48px 0 8px; }
    .section-sub { font-size:14px; color:#888780; margin-bottom:24px; }
    .service-card { background-color:#222220; border:0.5px solid #3a3a38; border-radius:12px; padding:24px; height:100%; transition:border-color 0.2s; }
    .service-card:hover { border-color:#c8962b; }
    .service-icon { font-size:32px; color:#c8962b; margin-bottom:12px; }
    .service-name { font-size:17px; font-weight:500; color:#f5f2ea; }
    .service-meta { font-size:13px; color:#888780; margin-top:4px; }
    .service-price { font-size:20px; font-weight:600; color:#c8962b; margin-top:12px; }
    .mini-product { background-color:#222220; border:0.5px solid #3a3a38; border-radius:12px; overflow:hidden; height:100%; transition:transform 0.2s, border-color 0.2s; }
    .mini-product:hover { transform:translateY(-4px); border-color:#c8962b; }
    .mini-img { height:120px; background-color:#1a1a1a; display:flex; align-items:center; justify-content:center; }
    .mini-img i { font-size:40px; color:#3a3a38; }
    .mini-body { padding:14px; }
    .mini-cat { font-size:10px; letter-spacing:1px; color:#c8962b; text-transform:uppercase; }
    .mini-name { font-size:14px; font-weight:500; color:#f5f2ea; margin:4px 0; }
    .mini-price { font-size:16px; font-weight:600; color:#c8962b; }
    .feature-row { display:flex; gap:24px; margin-top:32px; flex-wrap:wrap; }
    .feature { flex:1; min-width:200px; background-color:#222220; border:0.5px solid #3a3a38; border-radius:12px; padding:24px; text-align:center; }
    .feature i { font-size:30px; color:#c8962b; }
    .feature .ft-title { font-size:15px; font-weight:500; color:#f5f2ea; margin-top:12px; }
    .feature .ft-desc { font-size:13px; color:#888780; margin-top:6px; }
</style>
@endpush

@section('content')

    <div class="hero">
        <div class="tagline">EST. 2026 · PREMIUM GROOMING</div>
        <h1>BarberStore'a Hoş Geldiniz</h1>
        <p>
            @auth
                Merhaba {{ Auth::user()->name }}! Premium berber ürünleri ve profesyonel randevu hizmetiyle tarzını yansıt.
            @else
                Premium berber ürünleri ve profesyonel randevu hizmeti bir arada. Tarzını bizimle yansıt.
            @endauth
        </p>
        <a href="/products" class="btn-hero"><i class="bi bi-bag"></i> Alışverişe Başla</a>
        <a href="/appointment" class="btn-hero" style="background-color:transparent; border:0.5px solid #c8962b; color:#c8962b; margin-left:12px;"><i class="bi bi-calendar-check"></i> Randevu Al</a>
    </div>

    <div class="feature-row">
        <div class="feature">
            <i class="bi bi-truck"></i>
            <div class="ft-title">Hızlı Teslimat</div>
            <div class="ft-desc">Siparişlerin kapına kadar</div>
        </div>
        <div class="feature">
            <i class="bi bi-shield-check"></i>
            <div class="ft-title">Güvenli Ödeme</div>
            <div class="ft-desc">Bakiye + kart desteği</div>
        </div>
        <div class="feature">
            <i class="bi bi-scissors"></i>
            <div class="ft-title">Uzman Berberler</div>
            <div class="ft-desc">Profesyonel hizmet</div>
        </div>
        <div class="feature">
            <i class="bi bi-star"></i>
            <div class="ft-title">Premium Ürünler</div>
            <div class="ft-desc">Kaliteli markalar</div>
        </div>
    </div>

    <div class="section-title">Hizmetlerimiz</div>
    <div class="section-sub">Profesyonel berberlerimizden randevu alın</div>
    <div class="row g-4">
        @foreach ($services as $service)
            <div class="col-md-4">
                <div class="service-card">
                    <div class="service-icon"><i class="bi bi-scissors"></i></div>
                    <div class="service-name">{{ $service->name }}</div>
                    <div class="service-meta"><i class="bi bi-clock"></i> {{ $service->duration_min }} dakika</div>
                    <div class="service-price">{{ $service->price }} ₺</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="section-title">Öne Çıkan Ürünler</div>
    <div class="section-sub">En çok tercih edilen bakım ürünleri</div>
    <div class="row g-4">
        @foreach ($products as $product)
            <div class="col-md-3">
                <a href="/products/{{ $product->id }}" style="text-decoration:none;">
                    <div class="mini-product">
                        <div class="mini-img"><i class="bi bi-box-seam"></i></div>
                        <div class="mini-body">
                            <div class="mini-cat">{{ $product->category->name }}</div>
                            <div class="mini-name">{{ $product->name }}</div>
                            <div class="mini-price">{{ $product->price }} ₺</div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div style="text-align:center; margin-top:32px;">
        <a href="/products" class="btn-gold" style="display:inline-block; padding:12px 28px;">Tüm Ürünleri Gör <i class="bi bi-arrow-right"></i></a>
    </div>

    <div style="height:64px;"></div>

@endsection