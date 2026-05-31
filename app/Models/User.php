<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'balance', 'status',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'balance' => 'decimal:2',
        ];
    }

    public function addresses()    { return $this->hasMany(Address::class); }
    public function cartItems()    { return $this->hasMany(CartItem::class); }
    public function orders()       { return $this->hasMany(Order::class); }
    public function appointments() { return $this->hasMany(Appointment::class); }

    public function isAdmin(): bool { return $this->role === 'admin'; }
}
