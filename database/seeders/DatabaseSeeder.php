<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Barber;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Veritabanina baslangic verilerini ekler.
     * En az: 1 admin, 5 user, 5 kategori, 20 urun, 4 berber, 6 hizmet.
     */
    public function run(): void
    {
        // ---- 1 Admin ----
        User::create([
            'name'     => 'Admin Kullanici',
            'email'    => 'admin@barberstore.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'phone'    => '05000000000',
            'balance'  => 0,
            'status'   => 'active',
        ]);

        // ---- 5 User ----
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name'     => "Kullanici $i",
                'email'    => "user$i@barberstore.com",
                'password' => Hash::make('user123'),
                'role'     => 'user',
                'phone'    => '0500000000' . $i,
                'balance'  => 0,
                'status'   => 'active',
            ]);
        }

        // ---- 5 Kategori ----
        $categories = [
            'Sac Bakimi', 'Sac Sekillendirme', 'Sakal Bakimi',
            'Tiras Urunleri', 'Aletler & Aksesuar',
        ];
        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }

        // ---- 20 Urun (her kategoriye 4) ----
        $products = [
            1 => ['Sampuan', 'Sac Kremi', 'Sac Maskesi', 'Sac Serumu'],
            2 => ['Jole', 'Wax', 'Sac Spreyi', 'Pomat'],
            3 => ['Sakal Yagi', 'Sakal Sampuani', 'Sakal Balmi', 'Sakal Fircasi'],
            4 => ['Tiras Kopugu', 'Tiras Bicagi', 'Tiras Sonrasi Losyon', 'Tiras Jeli'],
            5 => ['Sac Kesme Makinesi', 'Fon Makinesi', 'Tarak Seti', 'Profesyonel Makas'],
        ];
        foreach ($products as $catId => $names) {
            foreach ($names as $name) {
                Product::create([
                    'category_id' => $catId,
                    'name'        => $name,
                    'description' => "$name - kaliteli berber urunu.",
                    'price'       => rand(50, 500),
                    'stock'       => rand(10, 100),
                    'status'      => 'on_sale',
                ]);
            }
        }

        // ---- 4 Berber ----
        $barbers = [
            ['Ahmet Usta', 'Sac kesimi ve sakal'],
            ['Mehmet Usta', 'Sac boyama'],
            ['Ali Usta', 'Cocuk sac kesimi'],
            ['Veli Usta', 'Cilt bakimi ve tiras'],
        ];
        foreach ($barbers as [$name, $specialty]) {
            Barber::create([
                'name'      => $name,
                'specialty' => $specialty,
                'phone'     => '05300000000',
                'status'    => 'active',
            ]);
        }

        // ---- 6 Hizmet ----
        $services = [
            ['Sac Kesimi', 150, 30],
            ['Sakal Tirasi', 80, 20],
            ['Sac + Sakal', 200, 45],
            ['Sac Boyama', 400, 60],
            ['Cocuk Sac Kesimi', 100, 25],
            ['Yuz / Cilt Bakimi', 250, 40],
        ];
        foreach ($services as [$name, $price, $duration]) {
            Service::create([
                'name'         => $name,
                'description'  => "$name hizmeti.",
                'price'        => $price,
                'duration_min' => $duration,
            ]);
        }
    }
}
