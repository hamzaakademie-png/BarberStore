# 💈 BarberStore

Berber ürünleri satışı ve online randevu sistemi sunan web uygulaması. Kullanıcılar bakım ürünleri satın alabilir, berberlerden randevu alabilir; yöneticiler sipariş, randevu ve ürünleri yönetebilir.

> Kocaeli Üniversitesi — TBL304 Web Programlama Dersi Projesi
> Geliştiren: Hamza Akdemir (231307025)

## 🚀 Özellikler

### Müşteri Tarafı
- Üyelik sistemi (kayıt, giriş, çıkış)
- Ürün listeleme, kategori ve detay sayfaları
- Sepete ekleme (AJAX ile anlık güncelleme, sepet rozeti)
- Sipariş oluşturma ve bakiyeli ödeme (bakiye yetmezse kalan tutar karttan)
- Sipariş takibi (Beklemede → Onaylandı → Kargoda → Teslim Edildi)
- Berberden online randevu alma ve iptal etme
- İletişim sayfası: canlı hava durumu (OpenWeatherMap API), harita (OpenStreetMap), mağaza galerisi

### Yönetici Tarafı
- Kontrol paneli (ürün, kullanıcı, sipariş, randevu istatistikleri)
- Sipariş durumu yönetimi
- Randevu durumu yönetimi (onayla / tamamla / iptal)
- Ürün yönetimi (ekleme, düzenleme, silme)

## 🛠️ Kullanılan Teknolojiler

- **Backend:** Laravel 12, PHP 8.2
- **Veritabanı:** MySQL
- **Frontend:** Blade, Bootstrap 5, Bootstrap Icons
- **Harici API:** OpenWeatherMap (hava durumu), OpenStreetMap (harita)

## ⚙️ Kurulum

```bash
# Projeyi klonla
git clone https://github.com/hamzaakademie-png/BarberStore.git
cd BarberStore

# Bağımlılıkları yükle
composer install

# .env dosyasını oluştur ve yapılandır
cp .env.example .env
php artisan key:generate

# .env içinde veritabanı bilgilerini ve OPENWEATHER_API_KEY değerini ayarla

# Veritabanı tablolarını ve örnek verileri oluştur
php artisan migrate --seed

# Sunucuyu başlat
php artisan serve
```

Uygulama `http://localhost:8000` adresinde çalışır.

## 🔑 Test Giriş Bilgileri

| Rol | E-posta | Şifre |
|-----|---------|-------|
| Yönetici | admin@barberstore.com | admin123 |
| Kullanıcı | user1@barberstore.com | user123 |

## 📄 Lisans

Bu proje eğitim amaçlı geliştirilmiştir.
