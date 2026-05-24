# BarberStore

## Proje Tanımı
Berber ve kişisel bakım ürünleri satışı ile berber randevu sistemi sunan web tabanlı bir e-ticaret uygulaması.

## Teknolojiler
- **Framework**: Laravel 12
- **Dil**: PHP 8.2+
- **Veritabanı**: MySQL 8
- **Frontend**: Bootstrap 5
- **Kimlik Doğrulama**: Laravel Breeze

## Özellikler
- Kullanıcı kaydı ve giriş sistemi
- Ürün listeleme ve detay sayfaları
- Sepet ve sipariş yönetimi
- Bakiye tabanlı ödeme sistemi
- Berber randevu alma
- Admin paneli (ürün, sipariş, randevu yönetimi)
- Kargo takibi (5 aşama)
- Web API entegrasyonu (hava durumu + Google Maps)

## Veritabanı
Proje 12 tabladan oluşmaktadır:
- users, addresses, categories, products, product_images
- cart_items, orders, order_items, payments
- barbers, services, appointments

SQL dosyası: `database.sql`

## Kurulum
1. Laravel 12 projesini klonla
2. `composer install` çalıştır
3. `.env` dosyasını konfigüre et
4. `php artisan migrate` ile veritabanını oluştur
5. `php artisan serve` ile sunucuyu başlat