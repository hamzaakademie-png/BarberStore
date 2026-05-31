<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap - BarberStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background-color:#1a1a1a; font-family:'Poppins',sans-serif; min-height:100vh; display:flex; align-items:center; justify-content:center; }
        .auth-card { width:400px; background-color:#222220; border:0.5px solid #3a3a38; border-radius:14px; overflow:hidden; }
        .auth-header { background-color:#1a1a1a; padding:28px 32px 24px; text-align:center; border-bottom:2px solid #c8962b; }
        .auth-header .tagline-top { font-size:13px; letter-spacing:3px; color:#c8962b; font-weight:500; }
        .auth-header .brand { font-size:26px; color:#f5f2ea; font-weight:600; margin-top:4px; }
        .auth-header .tagline-bottom { font-size:12px; letter-spacing:2px; color:#888780; margin-top:4px; }
        .auth-body { padding:28px 32px 32px; }
        .auth-title { font-size:18px; color:#f5f2ea; font-weight:500; }
        .auth-subtitle { font-size:13px; color:#888780; margin-bottom:24px; }
        .field-label { font-size:12px; letter-spacing:1px; color:#a8a6a0; margin-bottom:6px; }
        .input-box { display:flex; align-items:center; background-color:#1a1a1a; border:0.5px solid #3a3a38; border-radius:8px; padding:4px 12px; margin-bottom:14px; }
        .input-box i { color:#c8962b; margin-right:10px; }
        .input-box input { background:transparent; border:none; outline:none; color:#f5f2ea; width:100%; padding:8px 0; font-size:14px; }
        .input-box input::placeholder { color:#5f5e5a; }
        .btn-gold { background-color:#c8962b; color:#1a1a1a; width:100%; padding:12px; border:none; border-radius:8px; font-weight:600; font-size:15px; letter-spacing:1px; margin-top:8px; }
        .btn-gold:hover { background-color:#b8862b; }
        .auth-footer { text-align:center; margin-top:16px; font-size:13px; color:#888780; }
        .auth-footer a { color:#c8962b; text-decoration:none; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <div class="tagline-top">EST. 2026</div>
            <div class="brand"><i class="bi bi-scissors"></i> BARBERSTORE</div>
            <div class="tagline-bottom">PREMIUM GROOMING</div>
        </div>
        <div class="auth-body">
            <div class="auth-title">Tekrar hoş geldin</div>
            <div class="auth-subtitle">Hesabına giriş yap</div>

            <form method="POST" action="/login">
                @csrf
                @if ($errors->any())
    <div style="background-color:#3a1f1f; border:0.5px solid #a32d2d; color:#f09595; padding:10px 14px; border-radius:8px; margin-bottom:16px; font-size:13px;">
        <i class="bi bi-exclamation-circle"></i>
        {{ $errors->first() }}
    </div>
@endif

                <div class="field-label">E-POSTA</div>
                <div class="input-box">
                    <i class="bi bi-envelope"></i>
                    <input type="email" name="email" placeholder="ornek@email.com">
                </div>

                <div class="field-label">ŞİFRE</div>
                <div class="input-box">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" placeholder="••••••••">
                </div>

                <button type="submit" class="btn-gold">GİRİŞ YAP</button>
            </form>

            <div class="auth-footer">
                Hesabın yok mu? <a href="/register">Kayıt ol</a>
            </div>
        </div>
    </div>
</body>
</html>