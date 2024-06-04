<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'bill_id',
        'product_id',
        'quantity',
        'price',
        'product_name'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getProductNameAttribute()
    {
        return $this->product->name;
    }
}