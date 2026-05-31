-- ===========================================================
-- BarberStore - Veritabani Semasi
-- Berber urunleri satis ve randevu sitesi
-- Kocaeli Universitesi - TBL304 Web Programlama Projesi
-- ===========================================================

SET FOREIGN_KEY_CHECKS = 0;

-- users tablosu
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    phone VARCHAR(20) NULL,
    balance DECIMAL(10, 2) DEFAULT 0,
    status ENUM('active', 'passive', 'frozen') DEFAULT 'active',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- categories tablosu
CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NULL,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- barbers tablosu
CREATE TABLE barbers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    photo VARCHAR(255) NULL,
    specialty VARCHAR(255) NULL,
    phone VARCHAR(20) NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- services tablosu
CREATE TABLE services (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NULL,
    price DECIMAL(10, 2) NOT NULL,
    duration_min INT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- addresses tablosu
CREATE TABLE addresses (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(100) NULL,
    address_line TEXT NOT NULL,
    city VARCHAR(50) NOT NULL,
    district VARCHAR(50) NULL,
    postal_code VARCHAR(10) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- products tablosu
CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(200) NOT NULL,
    description TEXT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    status ENUM('on_sale', 'off_sale') DEFAULT 'on_sale',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- product_images tablosu
CREATE TABLE product_images (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id BIGINT UNSIGNED NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_primary BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- cart_items tablosu
CREATE TABLE cart_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    quantity INT DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- orders tablosu
CREATE TABLE orders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    address_id BIGINT UNSIGNED NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    balance_used DECIMAL(10, 2) DEFAULT 0,
    card_amount DECIMAL(10, 2) DEFAULT 0,
    status ENUM('pending', 'approved', 'supplying', 'packing',
                'shipped', 'on_the_way', 'delivered', 'completed', 'cancelled')
                DEFAULT 'pending',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (address_id) REFERENCES addresses(id)
);

-- order_items tablosu
CREATE TABLE order_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    quantity INT DEFAULT 1,
    unit_price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- payments tablosu
CREATE TABLE payments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id BIGINT UNSIGNED NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    method VARCHAR(50) NULL,
    paid_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

-- appointments tablosu
CREATE TABLE appointments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    barber_id BIGINT UNSIGNED NOT NULL,
    service_id BIGINT UNSIGNED NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    status ENUM('pending', 'approved', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (barber_id) REFERENCES barbers(id),
    FOREIGN KEY (service_id) REFERENCES services(id)
);

SET FOREIGN_KEY_CHECKS = 1;

-- ===========================================================
-- Ornek Veri (1 admin, 5 user, 5 kategori, 4 berber, 6 hizmet)
-- Sifreler Laravel Hash ile uretilmelidir; asagidaki ornek
-- veriler 'php artisan migrate --seed' ile de eklenebilir.
-- ===========================================================

INSERT INTO categories (name, created_at, updated_at) VALUES
('Sac Bakimi', NOW(), NOW()),
('Sac Sekillendirme', NOW(), NOW()),
('Sakal Bakimi', NOW(), NOW()),
('Tiras Urunleri', NOW(), NOW()),
('Aletler & Aksesuar', NOW(), NOW());

INSERT INTO barbers (name, specialty, phone, status, created_at, updated_at) VALUES
('Ahmet Usta', 'Sac kesimi ve sakal', '05300000001', 'active', NOW(), NOW()),
('Mehmet Usta', 'Sac boyama', '05300000002', 'active', NOW(), NOW()),
('Ali Usta', 'Cocuk sac kesimi', '05300000003', 'active', NOW(), NOW()),
('Veli Usta', 'Cilt bakimi ve tiras', '05300000004', 'active', NOW(), NOW());

INSERT INTO services (name, description, price, duration_min, created_at, updated_at) VALUES
('Sac Kesimi', 'Sac kesimi hizmeti.', 150, 30, NOW(), NOW()),
('Sakal Tirasi', 'Sakal tirasi hizmeti.', 80, 20, NOW(), NOW()),
('Sac + Sakal', 'Sac ve sakal hizmeti.', 200, 45, NOW(), NOW()),
('Sac Boyama', 'Sac boyama hizmeti.', 400, 60, NOW(), NOW()),
('Cocuk Sac Kesimi', 'Cocuk sac kesimi hizmeti.', 100, 25, NOW(), NOW()),
('Yuz / Cilt Bakimi', 'Yuz ve cilt bakimi hizmeti.', 250, 40, NOW(), NOW());
