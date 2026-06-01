@extends('layouts.app')

@section('title', 'Siparişlerim - BarberStore')

@push('styles')
<style>
    .order-card { background-color:#222220; border:0.5px solid #3a3a38; border-radius:14px; padding:24px; margin-bottom:20px; }
    .order-head { display:flex; justify-content:space-between; align-items:center; border-bottom:0.5px solid #3a3a38; padding-bottom:16px; margin-bottom:16px; flex-wrap:wrap; gap:8px; }
    .order-no { font-size:16px; font-weight:600; color:#f5f2ea; }
    .order-date { font-size:13px; color:#888780; }
    .order-status { font-size:12px; padding:5px 14px; border-radius:20px; font-weight:500; }
    .st-pending   { background-color:#4a4520; color:#e0c862; }
    .st-approved  { background-color:#1f3a4a; color:#62b4e0; }
    .st-shipped   { background-color:#2a3a5a; color:#8aa8e0; }
    .st-completed { background-color:#1f4a2a; color:#62e08a; }
    .st-cancelled { background-color:#4a1f1f; color:#e06262; }
    .order-item { display:flex; justify-content:space-between; padding:8px 0; font-size:14px; }
    .order-item .iname { color:#d8d6d0; }
    .order-item .iqty { color:#888780; }
    .order-item .iprice { color:#c8962b; font-weight:500; }
    .order-total { display:flex; justify-content:space-between; border-top:0.5px solid #3a3a38; margin-top:14px; padding-top:14px; font-size:16px; }
    .order-total .lbl { color:#a8a6a0; }
    .order-total .val { color:#c8962b; font-weight:600; font-size:20px; }
    .pay-info { font-size:12px; color:#888780; margin-top:8px; }
    .empty-box { text-align:center; padding:80px 0; }
    .empty-box i { font-size:64px; color:#3a3a38; }
    .empty-box p { color:#888780; margin-top:16px; }
</style>
@endpush

@section('content')

    <div class="page-title">Siparişlerim</div>
    <div class="page-subtitle">Geçmiş siparişlerinizi buradan takip edebilirsiniz</div>

    @if ($orders->count() > 0)
        @foreach ($orders as $order)
            <div class="order-card">
                <div class="order-head">
                    <div>
                        <div class="order-no">Sipariş #{{ $order->id }}</div>
                        <div class="order-date">{{ $order->created_at->format('d.m.Y H:i') }}</div>
                    </div>
                    @php
                        $statusMap = [
                            'pending'   => ['BEKLEMEDE', 'st-pending'],
                            'approved'  => ['ONAYLANDI', 'st-approved'],
                            'packing'   => ['HAZIRLANIYOR', 'st-approved'],
                            'shipped'   => ['KARGODA', 'st-shipped'],
                            'delivered' => ['TESLİM EDİLDİ', 'st-completed'],
                            'completed' => ['TAMAMLANDI', 'st-completed'],
                            'cancelled' => ['İPTAL EDİLDİ', 'st-cancelled'],
                        ];
                        $st = $statusMap[$order->status] ?? ['BEKLEMEDE', 'st-pending'];
                    @endphp
                    <span class="order-status {{ $st[1] }}">{{ $st[0] }}</span>
                </div>

                @foreach ($order->items as $item)
                    <div class="order-item">
                        <span class="iname">{{ $item->product->name ?? 'Ürün' }}</span>
                        <span class="iqty">{{ $item->quantity }} adet</span>
                        <span class="iprice">{{ $item->unit_price }} ₺</span>
                    </div>
                @endforeach

                <div class="order-total">
                    <span class="lbl">Toplam Tutar</span>
                    <span class="val">{{ $order->total_amount }} ₺</span>
                </div>

                @if ($order->balance_used > 0 || $order->card_amount > 0)
                    <div class="pay-info">
                        @if ($order->balance_used > 0) Bakiyeden: {{ $order->balance_used }} ₺ @endif
                        @if ($order->card_amount > 0) · Karttan: {{ $order->card_amount }} ₺ @endif
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <div class="empty-box">
            <i class="bi bi-bag-x"></i>
            <p>Henüz siparişiniz bulunmuyor.</p>
            <a href="/products" class="btn btn-gold">Alışverişe Başla</a>
        </div>
    @endif

    <div style="height:48px;"></div>

@endsection