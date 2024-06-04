<?php

namespace App\Http\Controllers\Home;

use App\Models\Brand;
use App\Models\Category;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check() && auth()->user()->checkAdmin()) {
            return redirect("/admin");
        }

        $products = Product::leftJoin('product_reviews', 'products.id', '=', 'product_reviews.product_id')
            ->select('products.*', DB::raw('AVG(product_reviews.rating) as avg_rating'))
            ->groupBy('products.id')
            ->orderByDesc('avg_rating')
            ->get();

        $products->transform(function ($product) {
            $product->image = $product->url_img;
            return $product;
        });

        return view('home.index', ['product' => $products]);
    }
}