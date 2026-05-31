<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - BarberStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background-color:#1a1a1a; font-family:'Poppins',sans-serif; color:#f5f2ea; }
        .navbar-custom { background-color:#222220; border-bottom:2px solid #c8962b; padding:16px 0; }
        .navbar-custom .brand { font-size:22px; font-weight:600; color:#f5f2ea; }
        .navbar-custom .brand i { color:#c8962b; }
        .navbar-custom .badge-admin { background-color:#c8962b; color:#1a1a1a; font-size:11px; padding:4px 10px; border-radius:6px; letter-spacing:1px; }
        .page-title { font-size:26px; font-weight:600; margin:32px 0 24px; }
        .stat-card { background-color:#222220; border:0.5px solid #3a3a38; border-radius:12px; padding:20px; }
        .stat-card .stat-icon { font-size:28px; color:#c8962b; }
        .stat-card .stat-value { font-size:32px; font-weight:600; color:#f5f2ea; }
        .stat-card .stat-label { font-size:13px; color:#888780; }
        .table-section { background-color:#222220; border:0.5px solid #3a3a38; border-radius:12px; padding:24px; margin-top:24px; }
        .table-section h5 { font-weight:500; margin-bottom:16px; }
        table { width:100%; color:#f5f2ea; }
        table th { font-size:12px; letter-spacing:1px; color:#888780; text-transform:uppercase; padding:10px; border-bottom:1px solid #3a3a38; text-align:left; }
        table td { padding:10px; border-bottom:0.5px solid #3a3a38; font-size:14px; }
        .price-cell { color:#c8962b; font-weight:500; }
    </style>
</head>
<body>

    <div class="navbar-custom">
        <div class="container d-flex justify-content-between align-items-center">
            <span class="brand"><i class="bi bi-scissors"></i> BARBERSTORE</span>
            <span class="badge-admin">YÖNETİCİ PANELİ</span>
        </div>
    </div>

    <div class="container">
        <div class="page-title">Kontrol Paneli</div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="bi bi-box-seam stat-icon"></i>
                    <div class="stat-value">{{ $products->count() }}</div>
                    <div class="stat-label">Toplam Ürün</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="bi bi-people stat-icon"></i>
                    <div class="stat-value">{{ $userCount }}</div>
                    <div class="stat-label">Kayıtlı Kullanıcı</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="bi bi-bag-check stat-icon"></i>
                    <div class="stat-value">{{ $orderCount }}</div>
                    <div class="stat-label">Toplam Sipariş</div>
                </div>
            </div>
        </div>

        <div class="table-section">
            <h5><i class="bi bi-list-ul"></i> Ürün Listesi</h5>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ürün Adı</th>
                        <th>Kategori</th>
                        <th>Fiyat</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td class="price-cell">{{ $product->price }} ₺</td>
                            <td>{{ $product->stock }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="height:48px;"></div>
    </div>

</body>
</html>