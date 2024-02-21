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
        'name',
        'description'
    ];

    protected $fillable = [
        'price',
        'image',
        'stock_quantity'
    ];
    public function getUrlImgAttribute()
    {
        if (!empty($this->image)) {
            return asset('images') . '/' . $this->image;
        }
        return null;
    }
}
