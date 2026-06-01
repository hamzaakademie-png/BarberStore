@extends('layouts.app')

@section('title', 'Randevu Al - BarberStore')

@push('styles')
<style>
    .booking-card { background-color:#222220; border:0.5px solid #3a3a38; border-radius:14px; padding:32px; margin-top:32px; }
    .field-label { font-size:13px; letter-spacing:1px; color:#a8a6a0; margin-bottom:8px; display:block; }
    .form-control-dark { background-color:#1a1a1a; border:0.5px solid #3a3a38; border-radius:8px; color:#f5f2ea; padding:10px 14px; width:100%; font-size:14px; margin-bottom:20px; }
    .form-control-dark:focus { outline:none; border-color:#c8962b; }
    .barber-option { background-color:#1a1a1a; border:0.5px solid #3a3a38; border-radius:10px; padding:16px; cursor:pointer; text-align:center; transition:border-color 0.2s; }
    .barber-option:hover { border-color:#c8962b; }
    .barber-option.selected { border-color:#c8962b; background-color:#2a2620; }
    .barber-photo { width:80px; height:80px; border-radius:50%; object-fit:cover; border:2px solid #3a3a38; }
    .barber-option.selected .barber-photo { border-color:#c8962b; }
    .barber-option .b-name { font-size:14px; font-weight:500; color:#f5f2ea; margin-top:10px; }
    .barber-option .b-spec { font-size:11px; color:#888780; }
    .alert-error { background-color:#3a1f1f; border:0.5px solid #a32d2d; color:#f09595; padding:12px 16px; border-radius:8px; margin-top:24px; font-size:14px; }
</style>
@endpush

@section('content')

    <div class="page-title">Randevu Al</div>
    <div class="page-subtitle">Berberini, hizmetini ve zamanını seç</div>

    @if (session('error'))
        <div class="alert-error"><i class="bi bi-exclamation-circle"></i> {{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert-error"><i class="bi bi-exclamation-circle"></i> {{ $errors->first() }}</div>
    @endif

    <form method="POST" action="/appointment/create">
        @csrf
        <div class="booking-card">

            <label class="field-label">BERBER SEÇ</label>
            <div class="row g-3" style="margin-bottom:24px;">
                @php
                    $barberPhotos = [
                        'Ahmet Usta'  => '/images/products/barbers/ahmet.png',
                        'Mehmet Usta' => '/images/products/barbers/mehmet.png',
                        'Ali Usta'    => '/images/products/barbers/ali.png',
                        'Veli Usta'   => '/images/products/barbers/veli.png',
                    ];
                @endphp
                @foreach ($barbers as $barber)
                    <div class="col-md-3">
                        <label class="barber-option" onclick="selectBarber(this)">
                            <input type="radio" name="barber_id" value="{{ $barber->id }}" style="display:none;" required>
                            <img src="{{ $barberPhotos[$barber->name] ?? '/images/products/barbers/ahmet.png' }}" class="barber-photo" alt="{{ $barber->name }}">
                            <div class="b-name">{{ $barber->name }}</div>
                            <div class="b-spec">{{ $barber->specialty }}</div>
                        </label>
                    </div>
                @endforeach
            </div>

            <label class="field-label">HİZMET SEÇ</label>
            <select name="service_id" class="form-control-dark" required>
                <option value="">-- Hizmet seçiniz --</option>
                @foreach ($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }} — {{ $service->price }} ₺ ({{ $service->duration_min }} dk)</option>
                @endforeach
            </select>

            <div class="row">
                <div class="col-md-6">
                    <label class="field-label">TARİH</label>
                    <input type="date" name="appointment_date" class="form-control-dark" required>
                </div>
                <div class="col-md-6">
                    <label class="field-label">SAAT</label>
                    <select name="appointment_time" class="form-control-dark" required>
                        <option value="">-- Saat seçiniz --</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                        <option value="17:00">17:00</option>
                        <option value="18:00">18:00</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-gold w-100" style="margin-top:24px; padding:14px;">
                <i class="bi bi-calendar-check"></i> Randevuyu Onayla
            </button>

        </div>
    </form>

    <div style="height:48px;"></div>

    <script>
    function selectBarber(label) {
        document.querySelectorAll('.barber-option').forEach(function(el) {
            el.classList.remove('selected');
        });
        label.classList.add('selected');
        label.querySelector('input[type=radio]').checked = true;
    }
    </script>

@endsection