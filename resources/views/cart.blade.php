@extends('layouts.app')

@section('title', 'Sepetim - BarberStore')

@push('styles')
<style>
    .cart-item { background-color:#222220; border:0.5px solid #3a3a38; border-radius:12px; padding:16px 20px; margin-bottom:12px; display:flex; align-items:center; justify-content:space-between; }
    .cart-item-icon { width:60px; height:60px; background-color:#1a1a1a; border-radius:8px; display:flex; align-items:center; justify-content:center; }
    .cart-item-icon i { font-size:28px; color:#3a3a38; }
    .cart-item-name { font-size:16px; font-weight:500; color:#f5f2ea; }
    .cart-item-meta { font-size:13px; color:#888780; }
    .cart-item-price { font-size:18px; font-weight:600; color:#c8962b; }
    .btn-remove { background:transparent; border:0.5px solid #a32d2d; color:#f09595; border-radius:8px; padding:6px 12px; font-size:13px; }
    .btn-remove:hover { background-color:#3a1f1f; }
    .summary-box { background-color:#222220; border:0.5px solid #3a3a38; border-radius:12px; padding:24px; }
    .summary-total { font-size:28px; font-weight:600; color:#c8962b; }
    .empty-cart { text-align:center; padding:60px 0; color:#888780; }
    .empty-cart i { font-size:64px; color:#3a3a38; }
    .alert-success { background-color:#1f3a2a; border:0.5px solid #1d9e75; color:#5dcaa5; padding:12px 16px; border-radius:8px; margin-top:24px; font-size:14px; }
    .alert-error { background-color:#3a1f1f; border:0.5px solid #a32d2d; color:#f09595; padding:12px 16px; border-radius:8px; margin-top:24px; font-size:14px; }
</style>
@endpush

@section('content')

    <div class="page-title">Sepetim</div>

    @if (session('success'))
        <div class="alert-success"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert-error"><i class="bi bi-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    @if ($cartItems->count() > 0)
        <div class="row g-4 mt-2">
            <div class="col-md-8">
                @foreach ($cartItems as $item)
                    <div class="cart-item">
                        <div class="d-flex align-items-center" style="gap:16px;">
                            <div class="cart-item-icon"><i class="bi bi-box-seam"></i></div>
                            <div>
                                <div class="cart-item-name">{{ $item->product->name }}</div>
                                <div class="cart-item-meta">{{ $item->quantity }} adet × {{ $item->product->price }} ₺</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center" style="gap:20px;">
                            <div class="cart-item-price">{{ $item->product->price * $item->quantity }} ₺</div>
                            <form method="POST" action="/cart/remove/{{ $item->id }}">
                                @csrf
                                <button type="submit" class="btn-remove"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-4">
                <div class="summary-box">
                    <div style="font-size:14px; color:#888780; letter-spacing:1px; margin-bottom:16px;">SİPARİŞ ÖZETİ</div>
                    <div class="d-flex justify-content-between" style="margin-bottom:8px; color:#a8a6a0; font-size:14px;">
                        <span>Ürün sayısı</span>
                        <span>{{ $cartItems->count() }} çeşit</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center" style="border-top:0.5px solid #3a3a38; padding-top:16px; margin-top:16px;">
                        <span style="color:#f5f2ea;">Toplam</span>
                        <span class="summary-total">{{ $total }} ₺</span>
                    </div>

                    <form method="POST" action="/order/create">
                        @csrf
                        <button type="submit" class="btn-gold w-100" style="margin-top:20px; padding:12px;"><i class="bi bi-bag-check"></i> Siparişi Tamamla</button>
                    </form>

                    <a href="/products" style="display:block; text-align:center; margin-top:12px; color:#888780; text-decoration:none; font-size:14px;">
                        <i class="bi bi-arrow-left"></i> Alışverişe devam et
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="empty-cart">
            <i class="bi bi-cart-x"></i>
            <div style="font-size:18px; margin-top:16px;">Sepetiniz boş</div>
            <a href="/products" class="btn-gold" style="display:inline-block; margin-top:20px;">Alışverişe Başla</a>
        </div>
    @endif

    <div style="height:48px;"></div>

@endsection