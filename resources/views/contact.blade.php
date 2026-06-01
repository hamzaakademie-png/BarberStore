@extends('layouts.app')

@section('title', 'İletişim - BarberStore')

@push('styles')
<style>
    .contact-hero { background:linear-gradient(135deg, #1a1a1a, #2a2620); border:0.5px solid #3a3a38; border-radius:16px; padding:48px; text-align:center; margin-top:32px; }
    .contact-hero i { font-size:48px; color:#c8962b; }
    .contact-hero h2 { font-size:32px; font-weight:600; color:#f5f2ea; margin-top:12px; }
    .contact-hero p { font-size:15px; color:#a8a6a0; max-width:520px; margin:8px auto 0; }
    .gallery { position:relative; border-radius:16px; overflow:hidden; border:0.5px solid #3a3a38; margin-top:24px; height:380px; }
    .gallery .slide { position:absolute; inset:0; opacity:0; transition:opacity 1s ease; background-size:cover; background-position:center; }
    .gallery .slide.active { opacity:1; }
    .gallery .overlay { position:absolute; inset:0; background:linear-gradient(rgba(26,26,26,0.1), rgba(26,26,26,0.8)); display:flex; align-items:flex-end; padding:32px; }
    .gallery .overlay .label { color:#f5f2ea; }
    .gallery .overlay .label .s { font-size:13px; color:#c8962b; letter-spacing:2px; }
    .gallery .overlay .label .t { font-size:26px; font-weight:600; }
    .gallery .dots { position:absolute; bottom:20px; right:32px; display:flex; gap:8px; z-index:5; }
    .gallery .dots span { width:10px; height:10px; border-radius:50%; background:rgba(255,255,255,0.4); cursor:pointer; }
    .gallery .dots span.active { background:#c8962b; }
    .weather-box { background-color:#222220; border:0.5px solid #3a3a38; border-radius:14px; padding:28px; height:100%; text-align:center; }
    .weather-city { font-size:18px; color:#f5f2ea; font-weight:500; }
    .weather-temp { font-size:54px; font-weight:600; color:#c8962b; margin:8px 0; }
    .weather-desc { font-size:15px; color:#a8a6a0; text-transform:capitalize; }
    .weather-icon { font-size:48px; color:#c8962b; }
    .weather-detail { display:flex; justify-content:space-around; margin-top:24px; border-top:0.5px solid #3a3a38; padding-top:20px; }
    .weather-detail .wd-val { font-size:18px; font-weight:500; color:#f5f2ea; }
    .weather-detail .wd-lbl { font-size:12px; color:#888780; }
    .info-card { background-color:#222220; border:0.5px solid #3a3a38; border-radius:14px; padding:24px; height:100%; }
    .info-item { display:flex; align-items:center; gap:14px; padding:12px 0; }
    .info-item i { font-size:22px; color:#c8962b; width:30px; }
    .info-item .lbl { font-size:12px; color:#888780; }
    .info-item .val { font-size:15px; color:#f5f2ea; }
    .hours-card { background-color:#222220; border:0.5px solid #3a3a38; border-radius:14px; padding:24px; height:100%; }
    .hours-card h6 { color:#c8962b; font-size:14px; letter-spacing:1px; margin-bottom:16px; }
    .hours-row { display:flex; justify-content:space-between; padding:8px 0; border-bottom:0.5px solid #2a2a28; font-size:14px; }
    .hours-row .day { color:#a8a6a0; }
    .hours-row .time { color:#f5f2ea; }
    .hours-row.closed .time { color:#f09595; }
    .social-card { background-color:#222220; border:0.5px solid #3a3a38; border-radius:14px; padding:24px; text-align:center; margin-top:24px; }
    .social-card h6 { color:#c8962b; font-size:14px; letter-spacing:1px; margin-bottom:16px; }
    .social-links { display:flex; justify-content:center; gap:16px; }
    .social-links a { width:48px; height:48px; border-radius:50%; background-color:#1a1a1a; border:0.5px solid #3a3a38; display:flex; align-items:center; justify-content:center; color:#c8962b; font-size:20px; text-decoration:none; transition:all 0.2s; }
    .social-links a:hover { background-color:#c8962b; color:#1a1a1a; transform:translateY(-3px); }
    iframe { border:0; border-radius:14px; width:100%; height:280px; }
</style>
@endpush

@section('content')

    <div class="contact-hero">
        <i class="bi bi-scissors"></i>
        <h2>Bize Ulaşın</h2>
        <p>Premium berber deneyimi için mağazamızı ziyaret edin ya da bizimle iletişime geçin.</p>
    </div>

    {{-- KAYAN GALERİ --}}
    <div class="gallery" id="gallery">
        <div class="slide active" style="background-image:url('https://images.unsplash.com/photo-1585747860715-2ba37e788b70?w=1000');"></div>
        <div class="slide" style="background-image:url('https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=1000');"></div>
        <div class="slide" style="background-image:url('https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?w=1000');"></div>
        <div class="slide" style="background-image:url('https://images.unsplash.com/photo-1622286342621-4bd786c2447c?w=1000');"></div>
        <div class="overlay">
            <div class="label">
                <div class="s">EST. 2026</div>
                <div class="t">BarberStore Mağazamızdan</div>
            </div>
        </div>
        <div class="dots" id="dots">
            <span class="active" onclick="goSlide(0)"></span>
            <span onclick="goSlide(1)"></span>
            <span onclick="goSlide(2)"></span>
            <span onclick="goSlide(3)"></span>
        </div>
    </div>

    {{-- HAVA DURUMU + ÇALIŞMA SAATLERİ --}}
    <div class="row g-4 mt-1">
        <div class="col-md-4">
            <div class="weather-box">
                <div style="font-size:13px; letter-spacing:2px; color:#888780; margin-bottom:16px;">ANLIK HAVA DURUMU</div>
                @if ($weather && isset($weather['main']))
                    <i class="bi bi-cloud-sun weather-icon"></i>
                    <div class="weather-city">{{ $weather['name'] }}</div>
                    <div class="weather-temp">{{ round($weather['main']['temp']) }}°</div>
                    <div class="weather-desc">{{ $weather['weather'][0]['description'] }}</div>
                    <div class="weather-detail">
                        <div><div class="wd-val">{{ $weather['main']['humidity'] }}%</div><div class="wd-lbl">Nem</div></div>
                        <div><div class="wd-val">{{ round($weather['wind']['speed']) }} m/s</div><div class="wd-lbl">Rüzgar</div></div>
                        <div><div class="wd-val">{{ round($weather['main']['feels_like']) }}°</div><div class="wd-lbl">Hissedilen</div></div>
                    </div>
                @else
                    <i class="bi bi-cloud-slash weather-icon"></i>
                    <div style="color:#888780; font-size:14px; margin-top:16px;">Hava durumu yüklenemedi.<br><span style="font-size:12px;">(API anahtarı henüz aktif olmayabilir)</span></div>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card">
                <h6 style="color:#c8962b; font-size:14px; letter-spacing:1px; margin-bottom:8px;">İLETİŞİM</h6>
                <div class="info-item"><i class="bi bi-geo-alt"></i><div><div class="lbl">ADRES</div><div class="val">Kocaeli, Türkiye</div></div></div>
                <div class="info-item"><i class="bi bi-telephone"></i><div><div class="lbl">TELEFON</div><div class="val">0500 000 00 00</div></div></div>
                <div class="info-item"><i class="bi bi-envelope"></i><div><div class="lbl">E-POSTA</div><div class="val">info@barberstore.com</div></div></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="hours-card">
                <h6><i class="bi bi-clock"></i> ÇALIŞMA SAATLERİ</h6>
                <div class="hours-row"><span class="day">Pzt - Cuma</span><span class="time">09:00 - 20:00</span></div>
                <div class="hours-row"><span class="day">Cumartesi</span><span class="time">10:00 - 18:00</span></div>
                <div class="hours-row closed"><span class="day">Pazar</span><span class="time">Kapalı</span></div>
            </div>
        </div>
    </div>

    {{-- HARİTA --}}
    <div style="border:0.5px solid #3a3a38; border-radius:14px; overflow:hidden; margin-top:24px;">
        <iframe
            src="https://www.openstreetmap.org/export/embed.html?bbox=29.90%2C40.75%2C29.98%2C40.80&layer=mapnik&marker=40.7654%2C29.9408"
            allowfullscreen>
        </iframe>
    </div>

    {{-- SOSYAL MEDYA --}}
    <div class="social-card">
        <h6>BİZİ TAKİP EDİN</h6>
        <div class="social-links">
            <a href="https://www.instagram.com/explore/tags/barbershop/" target="_blank"><i class="bi bi-instagram"></i></a>
            <a href="https://www.facebook.com/" target="_blank"><i class="bi bi-facebook"></i></a>
            <a href="https://www.youtube.com/results?search_query=barber" target="_blank"><i class="bi bi-youtube"></i></a>
            <a href="https://wa.me/905000000000" target="_blank"><i class="bi bi-whatsapp"></i></a>
        </div>
    </div>

    <div style="height:48px;"></div>

    <script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('#gallery .slide');
    const dots = document.querySelectorAll('#dots span');

    function showSlide(n) {
        slides.forEach(s => s.classList.remove('active'));
        dots.forEach(d => d.classList.remove('active'));
        slides[n].classList.add('active');
        dots[n].classList.add('active');
        currentSlide = n;
    }

    function goSlide(n) { showSlide(n); }

    setInterval(function() {
        let next = (currentSlide + 1) % slides.length;
        showSlide(next);
    }, 3500);
    </script>

@endsection