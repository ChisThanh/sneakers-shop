<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model implements TranslatableContract
{
    use Translatable;
    use HasFactory;
    use SoftDeletes;

    public $translatedAttributes = [
        'description'
    ];

    protected $fillable = [
        'name',
        'category_id',
        'brand_id',
        'price',
        'price_sale',
        'image',
        'stock_quantity'
    ];

    public function getUrlImgAttribute()
    {
        if (isset($this->image) && strpos($this->image, '/img/product') === 0) {
            return  asset("assets_home") . $this->image;
        } else {
            return asset('images') . '/' . $this->image;
        }
    }

    public function category()
    {
        return $this->hasone(Category::class, 'id', 'category_id');
    }
}