@extends('layouts.app')

@section('title', 'Randevularım - BarberStore')

@push('styles')
<style>
    .appt-card { background-color:#222220; border:0.5px solid #3a3a38; border-radius:12px; padding:20px 24px; margin-bottom:16px; display:flex; justify-content:space-between; align-items:center; }
    .appt-service { font-size:17px; font-weight:500; color:#f5f2ea; }
    .appt-detail { font-size:13px; color:#888780; margin-top:4px; }
    .appt-detail i { color:#c8962b; }
    .status-badge { font-size:11px; padding:4px 12px; border-radius:6px; letter-spacing:1px; }
    .status-pending { background-color:#854f0b; color:#fac775; }
    .status-cancelled { background-color:#501313; color:#f09595; }
    .status-approved { background-color:#0f6e56; color:#5dcaa5; }
    .status-completed { background-color:#185fa5; color:#85b7eb; }
    .btn-cancel { background:transparent; border:0.5px solid #a32d2d; color:#f09595; border-radius:8px; padding:6px 14px; font-size:13px; }
    .btn-cancel:hover { background-color:#3a1f1f; }
    .empty { text-align:center; padding:60px 0; color:#888780; }
    .empty i { font-size:64px; color:#3a3a38; }
    .alert-success { background-color:#1f3a2a; border:0.5px solid #1d9e75; color:#5dcaa5; padding:12px 16px; border-radius:8px; margin-top:24px; font-size:14px; }
</style>
@endpush

@section('content')

    <div class="d-flex justify-content-between align-items-center" style="margin:32px 0 8px;">
        <div class="page-title" style="margin:0;">Randevularım</div>
        <a href="/appointment" class="btn-gold" style="display:inline-block;"><i class="bi bi-plus-lg"></i> Yeni Randevu</a>
    </div>

    @if (session('success'))
        <div class="alert-success"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
    @endif

    @if ($appointments->count() > 0)
        <div class="mt-4">
            @foreach ($appointments as $appt)
                <div class="appt-card">
                    <div>
                        <div class="appt-service">{{ $appt->service->name }}</div>
                        <div class="appt-detail">
                            <i class="bi bi-person"></i> {{ $appt->barber->name }}
                            &nbsp;|&nbsp; <i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($appt->appointment_date)->format('d.m.Y') }}
                            &nbsp;|&nbsp; <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($appt->appointment_time)->format('H:i') }}
                            &nbsp;|&nbsp; <i class="bi bi-cash"></i> {{ $appt->service->price }} ₺
                        </div>
                    </div>
                    <div class="d-flex align-items-center" style="gap:16px;">
                        @if ($appt->status == 'pending')
                            <span class="status-badge status-pending">BEKLEMEDE</span>
                        @elseif ($appt->status == 'approved')
                            <span class="status-badge status-approved">ONAYLANDI</span>
                        @elseif ($appt->status == 'completed')
                            <span class="status-badge status-completed">TAMAMLANDI</span>
                        @else
                            <span class="status-badge status-cancelled">İPTAL EDİLDİ</span>
                        @endif

                        @if ($appt->status != 'cancelled' && $appt->status != 'completed')
                            <form method="POST" action="/appointment/cancel/{{ $appt->id }}">
                                @csrf
                                <button type="submit" class="btn-cancel"><i class="bi bi-x-lg"></i> İptal</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty">
            <i class="bi bi-calendar-x"></i>
            <div style="font-size:18px; margin-top:16px;">Henüz randevunuz yok</div>
            <a href="/appointment" class="btn-gold" style="display:inline-block; margin-top:20px;">Randevu Al</a>
        </div>
    @endif

    <div style="height:48px;"></div>

@endsection