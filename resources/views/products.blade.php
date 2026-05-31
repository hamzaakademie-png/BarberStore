<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürünler - BarberStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background-color:#1a1a1a; font-family:'Poppins',sans-serif; color:#f5f2ea; }
        .navbar-custom { background-color:#222220; border-bottom:2px solid #c8962b; padding:16px 0; }
        .navbar-custom .brand { font-size:22px; font-weight:600; color:#f5f2ea; }
        .navbar-custom .brand i { color:#c8962b; }
        .page-title { font-size:28px; font-weight:600; margin:32px 0 8px; }
        .page-subtitle { color:#888780; font-size:14px; margin-bottom:32px; }
        .product-card { background-color:#222220; border:0.5px solid #3a3a38; border-radius:12px; overflow:hidden; transition:transform 0.2s, border-color 0.2s; height:100%; }
        .product-card:hover { transform:translateY(-4px); border-color:#c8962b; }
        .product-img { height:160px; background-color:#1a1a1a; display:flex; align-items:center; justify-content:center; }
        .product-img i { font-size:48px; color:#3a3a38; }
        .product-body { padding:16px; }
        .product-category { font-size:11px; letter-spacing:1px; color:#c8962b; text-transform:uppercase; }
        .product-name { font-size:15px; font-weight:500; margin:6px 0; color:#f5f2ea; }
        .product-price { font-size:18px; font-weight:600; color:#c8962b; }
        .product-stock { font-size:12px; color:#888780; }
        .btn-add { background-color:#c8962b; color:#1a1a1a; border:none; border-radius:8px; padding:8px; width:100%; font-weight:500; font-size:13px; margin-top:12px; }
    </style>
</head>
<body>

    <div class="navbar-custom">
        <div class="container">
            <span class="brand"><i class="bi bi-scissors"></i> BARBERSTORE</span>
        </div>
    </div>

    <div class="container">
        <div class="page-title">Ürünlerimiz</div>
        <div class="page-subtitle">Premium berber ve bakım ürünleri</div>

        <div class="row g-4">
            @foreach ($products as $product)
                <div class="col-md-3">
                    <div class="product-card">
                        <div class="product-img">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div class="product-body">
                            <div class="product-category">{{ $product->category->name }}</div>
                            <div class="product-name">{{ $product->name }}</div>
                            <div class="product-price">{{ $product->price }} ₺</div>
                            <div class="product-stock">Stok: {{ $product->stock }} adet</div>
                            <button class="btn-add"><i class="bi bi-cart-plus"></i> Sepete Ekle</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="height:48px;"></div>
    </div>

</body>
</html>