<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $hidden = ['user_id'];

    protected $fillable = [
        'user_id',
        'delivery_date',
        'total',
        'payment_status',
        'payment_method',
    ];

    public function getUserNameAttribute()
    {
        return $this->user->name;
    }
    public function getdeli()
    {
        return $this->delivery_date;
    }
    public function gettotal()
    {
        return $this->total;
    }
    public function getstatus()
    {
        return $this->status;
    }
    public function getpayment()
    {
        return $this->payment_status;
    }
    public function getpaymentmethod()
    {
        return $this->payment_method;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(BillDetail::class, 'bill_id');
    }
}