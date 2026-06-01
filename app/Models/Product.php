<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'description', 'price', 'stock', 'status',
    ];

    public function category()   { return $this->belongsTo(Category::class); }
    public function images()     { return $this->hasMany(ProductImage::class); }
    public function cartItems()  { return $this->hasMany(CartItem::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }

    public function getImageUrlAttribute()
    {
        $images = [
            'Sampuan'              => '/images/products/626aa920-ec44-4f8c-acc6-fbfe86c4e12e.jpg',
            'Sac Kremi'            => '/images/products/41410364-7a6d-477c-abdc-aa5784229175.jpg',
            'Sac Maskesi'          => '/images/products/3803de78-dc42-4d01-947e-f01072466b11.jpg',
            'Sac Serumu'           => '/images/products/02276364-e081-48aa-8781-816af2bcf349.jpg',
            'Jole'                 => '/images/products/596902aa-ffba-472d-b8f4-d1fb4d7b282e.jpg',
            'Wax'                  => '/images/products/edab6765-fa54-456d-b417-76629771845c.jpg',
            'Sac Spreyi'           => '/images/products/d55417fc-3f75-454f-b08a-c10d17707c36.jpg',
            'Pomat'                => '/images/products/da4ec1e9-8ad5-47c4-b57c-71f0933b7cfa.jpg',
            'Sakal Yagi'           => '/images/products/e3e026fc-1e01-4491-8c06-cb6c701ecd74.jpg',
            'Sakal Sampuani'       => '/images/products/30537ca0-e53c-4150-8ff9-115b7bba8252.jpg',
            'Sakal Balmi'          => '/images/products/3c596091-a93b-4b14-b14d-8035784f868b.jpg',
            'Sakal Fircasi'        => '/images/products/270ae4bc-d1ac-4528-af2a-3d33ea85604d.jpg',
            'Tiras Kopugu'         => '/images/products/676b5e4c-91d7-48f6-a752-98a2cb1746b7.jpg',
            'Tiras Bicagi'         => '/images/products/b82ad726-5148-4d34-ba1c-b5e69db4c22d.jpg',
            'Tiras Sonrasi Losyon' => '/images/products/watermarked_img_1320720416840973602.jpg',
            'Tiras Jeli'           => '/images/products/54608113-fd3e-4a87-ade7-217b9cdbfddd.jpg',
            'Sac Kesme Makinesi'   => '/images/products/watermarked_img_12353648803267623313.jpg',
            'Fon Makinesi'         => '/images/products/watermarked_img_10950122626994009498.jpg',
            'Tarak Seti'           => '/images/products/watermarked_img_10356068990793272876.jpg',
            'Profesyonel Makas'    => '/images/products/watermarked_img_12553626714720575202.jpg',
        ];

        return $images[$this->name] ?? '/images/products/626aa920-ec44-4f8c-acc6-fbfe86c4e12e.jpg';
    }
}