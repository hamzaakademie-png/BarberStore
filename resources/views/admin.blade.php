@extends('layouts.app')

@section('title', 'Admin Panel - BarberStore')

@push('styles')
<style>
    .badge-admin { background-color:#c8962b; color:#1a1a1a; font-size:11px; padding:4px 10px; border-radius:6px; letter-spacing:1px; }
    .stat-card { background-color:#222220; border:0.5px solid #3a3a38; border-radius:12px; padding:20px; }
    .stat-card .stat-icon { font-size:28px; color:#c8962b; }
    .stat-card .stat-value { font-size:32px; font-weight:600; color:#f5f2ea; }
    .stat-card .stat-label { font-size:13px; color:#888780; }
    .table-section { background-color:#222220; border:0.5px solid #3a3a38; border-radius:12px; padding:24px; margin-top:24px; }
    .table-section h5 { font-weight:500; margin-bottom:16px; color:#f5f2ea; }
    table { width:100%; color:#f5f2ea; }
    table th { font-size:12px; letter-spacing:1px; color:#888780; text-transform:uppercase; padding:10px; border-bottom:1px solid #3a3a38; text-align:left; }
    table td { padding:10px; border-bottom:0.5px solid #3a3a38; font-size:14px; vertical-align:middle; }
    .price-cell { color:#c8962b; font-weight:500; }
    .status-select { background-color:#1a1a1a; border:0.5px solid #3a3a38; color:#f5f2ea; border-radius:6px; padding:4px 8px; font-size:12px; }
    .btn-mini { background-color:#c8962b; color:#1a1a1a; border:none; border-radius:6px; padding:4px 10px; font-size:12px; font-weight:500; }
    .btn-del { background-color:#501313; color:#f09595; border:none; border-radius:6px; padding:4px 10px; font-size:12px; }
    .btn-del:hover { background-color:#6a1818; }
    .input-dark { background-color:#222220; border:0.5px solid #3a3a38; color:#f5f2ea; border-radius:6px; padding:8px 12px; width:100%; font-size:13px; }
    .input-dark:focus { outline:none; border-color:#c8962b; }
    .form-label-mini { font-size:11px; color:#888780; letter-spacing:1px; margin-bottom:4px; display:block; }
    .alert-success { background-color:#1f3a2a; border:0.5px solid #1d9e75; color:#5dcaa5; padding:12px 16px; border-radius:8px; margin-top:24px; font-size:14px; }
    .badge-st { font-size:11px; padding:3px 10px; border-radius:6px; letter-spacing:1px; }
    .st-pending { background-color:#854f0b; color:#fac775; }
    .st-cancelled { background-color:#501313; color:#f09595; }
    .st-approved { background-color:#0f6e56; color:#5dcaa5; }
    .st-completed { background-color:#185fa5; color:#85b7eb; }
</style>
@endpush

@section('content')

    <div class="d-flex justify-content-between align-items-center" style="margin:32px 0 24px;">
        <div class="page-title" style="margin:0;">Kontrol Paneli</div>
        <span class="badge-admin">YÖNETİCİ</span>
    </div>

    @if (session('success'))
        <div class="alert-success"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div class="row g-4 mt-1">
        <div class="col-md-3">
            <div class="stat-card">
                <i class="bi bi-box-seam stat-icon"></i>
                <div class="stat-value">{{ $products->count() }}</div>
                <div class="stat-label">Toplam Ürün</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <i class="bi bi-people stat-icon"></i>
                <div class="stat-value">{{ $userCount }}</div>
                <div class="stat-label">Kullanıcı</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <i class="bi bi-bag-check stat-icon"></i>
                <div class="stat-value">{{ $orderCount }}</div>
                <div class="stat-label">Sipariş</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <i class="bi bi-calendar-check stat-icon"></i>
                <div class="stat-value">{{ $appointmentCount }}</div>
                <div class="stat-label">Randevu</div>
            </div>
        </div>
    </div>

    {{-- SİPARİŞLER --}}
    <div class="table-section">
        <h5><i class="bi bi-bag-check"></i> Sipariş Yönetimi</h5>
        @if ($orders->count() > 0)
            <table>
                <thead>
                    <tr><th>No</th><th>Müşteri</th><th>Tutar</th><th>Tarih</th><th>Durum</th><th>Güncelle</th></tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? '-' }}</td>
                            <td class="price-cell">{{ $order->total_amount }} ₺</td>
                            <td>{{ $order->created_at->format('d.m.Y') }}</td>
                            <td><span class="badge-st st-pending">{{ strtoupper($order->status) }}</span></td>
                            <td>
                                <form method="POST" action="/admin/order/{{ $order->id }}/status" class="d-flex" style="gap:6px;">
                                    @csrf
                                    <select name="status" class="status-select">
                                        <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Beklemede</option>
                                        <option value="approved" {{ $order->status=='approved'?'selected':'' }}>Onaylandı</option>
                                        <option value="packing" {{ $order->status=='packing'?'selected':'' }}>Hazırlanıyor</option>
                                        <option value="shipped" {{ $order->status=='shipped'?'selected':'' }}>Kargoda</option>
                                        <option value="delivered" {{ $order->status=='delivered'?'selected':'' }}>Teslim Edildi</option>
                                        <option value="completed" {{ $order->status=='completed'?'selected':'' }}>Tamamlandı</option>
                                        <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>İptal</option>
                                    </select>
                                    <button type="submit" class="btn-mini">Kaydet</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="color:#888780; font-size:14px;">Henüz sipariş yok.</div>
        @endif
    </div>

    {{-- RANDEVULAR --}}
    <div class="table-section">
        <h5><i class="bi bi-calendar-check"></i> Randevu Yönetimi</h5>
        @if ($appointments->count() > 0)
            <table>
                <thead>
                    <tr><th>No</th><th>Müşteri</th><th>Berber</th><th>Hizmet</th><th>Tarih/Saat</th><th>Durum</th><th>Güncelle</th></tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $appt)
                        <tr>
                            <td>#{{ $appt->id }}</td>
                            <td>{{ $appt->user->name ?? '-' }}</td>
                            <td>{{ $appt->barber->name ?? '-' }}</td>
                            <td>{{ $appt->service->name ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($appt->appointment_date)->format('d.m.Y') }} {{ \Carbon\Carbon::parse($appt->appointment_time)->format('H:i') }}</td>
                            <td>
                                @if ($appt->status=='pending') <span class="badge-st st-pending">BEKLEMEDE</span>
                                @elseif ($appt->status=='approved') <span class="badge-st st-approved">ONAYLANDI</span>
                                @elseif ($appt->status=='completed') <span class="badge-st st-completed">TAMAMLANDI</span>
                                @else <span class="badge-st st-cancelled">İPTAL</span>
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="/admin/appointment/{{ $appt->id }}/status" class="d-flex" style="gap:6px;">
                                    @csrf
                                    <select name="status" class="status-select">
                                        <option value="pending" {{ $appt->status=='pending'?'selected':'' }}>Beklemede</option>
                                        <option value="approved" {{ $appt->status=='approved'?'selected':'' }}>Onayla</option>
                                        <option value="completed" {{ $appt->status=='completed'?'selected':'' }}>Tamamla</option>
                                        <option value="cancelled" {{ $appt->status=='cancelled'?'selected':'' }}>İptal</option>
                                    </select>
                                    <button type="submit" class="btn-mini">Kaydet</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="color:#888780; font-size:14px;">Henüz randevu yok.</div>
        @endif
    </div>

    {{-- ÜRÜN YÖNETİMİ --}}
    <div class="table-section">
        <h5><i class="bi bi-list-ul"></i> Ürün Yönetimi</h5>

        <button type="button" class="btn-mini" style="margin-bottom:16px; padding:8px 14px;" onclick="toggleEl('add-form','block')">
            <i class="bi bi-plus-circle"></i> Yeni Ürün Ekle
        </button>

        {{-- Yeni Ürün Formu --}}
        <div id="add-form" style="display:none; background-color:#1a1a1a; border:0.5px solid #3a3a38; border-radius:10px; padding:20px; margin-bottom:20px;">
            <form method="POST" action="/admin/product/create">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label-mini">ÜRÜN ADI</label>
                        <input type="text" name="name" class="input-dark" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-mini">KATEGORİ</label>
                        <select name="category_id" class="input-dark" required>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label-mini">FİYAT (₺)</label>
                        <input type="number" name="price" step="0.01" class="input-dark" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label-mini">STOK</label>
                        <input type="number" name="stock" class="input-dark" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label-mini">AÇIKLAMA</label>
                        <textarea name="description" class="input-dark" rows="2"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn-mini" style="margin-top:16px; padding:8px 14px;"><i class="bi bi-check-circle"></i> Ürünü Kaydet</button>
            </form>
        </div>

        <table>
            <thead>
                <tr><th>ID</th><th>Ürün</th><th>Kategori</th><th>Fiyat</th><th>Stok</th><th>İşlem</th></tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td class="price-cell">{{ $product->price }} ₺</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            <div style="display:flex; gap:6px;">
                                <button type="button" class="btn-mini" onclick="toggleEl('edit-{{ $product->id }}','table-row')"><i class="bi bi-pencil"></i></button>
                                <form method="POST" action="/admin/product/{{ $product->id }}/delete" onsubmit="return confirm('Bu ürünü silmek istediğinize emin misiniz?');">
                                    @csrf
                                    <button type="submit" class="btn-del"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    {{-- Düzenleme Satırı (gizli) --}}
                    <tr id="edit-{{ $product->id }}" style="display:none;">
                        <td colspan="6" style="background-color:#1a1a1a;">
                            <form method="POST" action="/admin/product/{{ $product->id }}/update">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label-mini">ÜRÜN ADI</label>
                                        <input type="text" name="name" class="input-dark" value="{{ $product->name }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label-mini">KATEGORİ</label>
                                        <select name="category_id" class="input-dark" required>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label-mini">FİYAT (₺)</label>
                                        <input type="number" name="price" step="0.01" class="input-dark" value="{{ $product->price }}" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label-mini">STOK</label>
                                        <input type="number" name="stock" class="input-dark" value="{{ $product->stock }}" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label-mini">AÇIKLAMA</label>
                                        <textarea name="description" class="input-dark" rows="2">{{ $product->description }}</textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn-mini" style="margin-top:16px; padding:8px 14px;"><i class="bi bi-check-circle"></i> Güncelle</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="height:48px;"></div>

    <script>
    function toggleEl(id, type) {
        var el = document.getElementById(id);
        if (el.style.display === 'none' || el.style.display === '') {
            el.style.display = type;
        } else {
            el.style.display = 'none';
        }
    }
    </script>

@endsection