<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model implements TranslatableContract
{
    use Translatable;
    use HasFactory;


    public $translatedAttributes = [
        'description'
    ];

    protected $fillable = [
        'name',
        'category_id',
        'brand_id',
        'price',
        'image',
        'stock_quantity'
    ];
    public function getUrlImgAttribute()
    {
        if (isset($this->image) && strpos($this->image, 'products/') === 0) {
            return asset('images') . '/' . $this->image;
        } else {
            return $this->image;
        }
    }
}
