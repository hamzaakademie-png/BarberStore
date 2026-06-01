@extends('layouts.app')

@section('title', 'Ürünler - BarberStore')

@push('styles')
<style>
    .product-card { background-color:#222220; border:0.5px solid #3a3a38; border-radius:12px; overflow:hidden; transition:transform 0.2s, border-color 0.2s; height:100%; }
    .product-card:hover { transform:translateY(-4px); border-color:#c8962b; }
    .product-img { height:180px; width:100%; object-fit:cover; display:block; background-color:#1a1a1a; }
    .product-body { padding:16px; }
    .product-category { font-size:11px; letter-spacing:1px; color:#c8962b; text-transform:uppercase; }
    .product-name { font-size:15px; font-weight:500; margin:6px 0; color:#f5f2ea; }
    .product-name:hover { color:#c8962b; }
    .product-price { font-size:18px; font-weight:600; color:#c8962b; }
    .product-stock { font-size:12px; color:#888780; }
    .btn-add { background-color:#c8962b; color:#1a1a1a; border:none; border-radius:8px; padding:8px; width:100%; font-weight:500; font-size:13px; margin-top:12px; }
    .btn-add:hover { background-color:#b8862b; }
    .btn-added { background-color:#a32d2d; color:#f5f2ea; border:none; border-radius:8px; padding:8px; width:100%; font-weight:500; font-size:13px; margin-top:12px; cursor:default; }
</style>
@endpush

@section('content')

    <div class="page-title">Ürünlerimiz</div>
    <div class="page-subtitle">Premium berber ve bakım ürünleri</div>

    <div class="row g-4">
        @foreach ($products as $product)
            <div class="col-md-3">
                <div class="product-card">
                    <a href="/products/{{ $product->id }}">
                        <img src="{{ $product->image_url }}" class="product-img" alt="{{ $product->name }}">
                    </a>
                    <div class="product-body">
                        <div class="product-category">{{ $product->category->name }}</div>
                        <a href="/products/{{ $product->id }}" style="text-decoration:none;">
                            <div class="product-name">{{ $product->name }}</div>
                        </a>
                        <div class="product-price">{{ $product->price }} ₺</div>
                        <div class="product-stock">Stok: {{ $product->stock }} adet</div>
                        <button type="button" class="btn-add" onclick="sepeteEkle({{ $product->id }}, this)">
                            <i class="bi bi-cart-plus"></i> Sepete Ekle
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
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
                button.className = 'btn-added';
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