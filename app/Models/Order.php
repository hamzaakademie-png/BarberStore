<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'address_id', 'total_amount',
        'balance_used', 'card_amount', 'status',
    ];

    public function user()     { return $this->belongsTo(User::class); }
    public function address()  { return $this->belongsTo(Address::class); }
    public function items()    { return $this->hasMany(OrderItem::class); }
    public function payments() { return $this->hasMany(Payment::class); }
}
