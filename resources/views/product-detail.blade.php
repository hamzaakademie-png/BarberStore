@extends('layouts.app')

@section('title', $product->name . ' - BarberStore')

@push('styles')
<style>
    .detail-wrap { background-color:#222220; border:0.5px solid #3a3a38; border-radius:14px; overflow:hidden; margin-top:32px; }
    .detail-img { background-color:#1a1a1a; height:360px; background-size:cover; background-position:center; }
    .detail-body { padding:36px; }
    .detail-category { font-size:12px; letter-spacing:2px; color:#c8962b; text-transform:uppercase; }
    .detail-name { font-size:30px; font-weight:600; margin:8px 0 16px; color:#f5f2ea; }
    .detail-price { font-size:34px; font-weight:600; color:#c8962b; margin-bottom:8px; }
    .detail-stock { font-size:14px; color:#888780; margin-bottom:20px; }
    .detail-desc { font-size:15px; color:#a8a6a0; line-height:1.7; margin-bottom:28px; }
    .btn-buy { background-color:#c8962b; color:#1a1a1a; border:none; border-radius:8px; padding:14px 28px; font-weight:600; font-size:15px; }
    .btn-buy:hover { background-color:#b8862b; }
    .btn-buy-added { background-color:#a32d2d; color:#f5f2ea; border:none; border-radius:8px; padding:14px 28px; font-weight:600; font-size:15px; cursor:default; }
    .back-link { color:#888780; text-decoration:none; font-size:14px; }
    .back-link:hover { color:#c8962b; }
</style>
@endpush

@section('content')

    <div style="margin-top:24px;">
        <a href="/products" class="back-link"><i class="bi bi-arrow-left"></i> Ürünlere dön</a>
    </div>

    <div class="detail-wrap">
        <div class="row g-0">
            <div class="col-md-5">
                <div class="detail-img" style="background-image:url('{{ $product->image_url }}');"></div>
            </div>
            <div class="col-md-7">
                <div class="detail-body">
                    <div class="detail-category">{{ $product->category->name }}</div>
                    <div class="detail-name">{{ $product->name }}</div>
                    <div class="detail-price">{{ $product->price }} ₺</div>
                    <div class="detail-stock">
                        @if ($product->stock > 0)
                            <i class="bi bi-check-circle gold"></i> Stokta {{ $product->stock }} adet var
                        @else
                            <i class="bi bi-x-circle"></i> Stokta yok
                        @endif
                    </div>
                    <div class="detail-desc">{{ $product->description }}</div>
                    <button type="button" class="btn-buy" onclick="sepeteEkle({{ $product->id }}, this)">
                        <i class="bi bi-cart-plus"></i> Sepete Ekle
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div style="height:48px;"></div>

    <script>
    function sepeteEkle(productId, button) {
        fetch('/cart/add/' + productId, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.status === 401) {
                window.location.href = '/login';
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data && data.success) {
                button.innerHTML = '<i class="bi bi-check-circle"></i> Sepete Eklendi';
                button.className = 'btn-buy-added';
                button.disabled = true;
                const badge = document.getElementById('cart-badge');
                if (badge) {
                    badge.textContent = data.cartCount;
                    badge.style.display = 'inline-block';
                }
            }
        })
        .catch(error => console.error('Hata:', error));
    }
    </script>

@endsection