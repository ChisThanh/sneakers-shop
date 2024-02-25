<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $hidden = ['user_id'];
    protected $fillable = [
        'user_id',
        'delivery_date',
        'total',
        'status',
    ];

    public function getUserNameAttribute()
    {
        return $this->user->name;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(CartDetail::class, 'cart_id');
    }
}
