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
        //hiển thị theo sản phẩm có ddanhss giá cao
        $product = Product::leftJoin('product_reviews', 'products.id', '=', 'product_reviews.product_id')
                        ->select('products.*', DB::raw('AVG(product_reviews.rating) as avg_rating'))
                        ->groupBy('products.id')
                        ->orderByDesc('avg_rating')
                        ->get();
        return view('home.index',compact( 'product'));
    }
    public function searchByName(Request $request)
    {
        $category = Category::all();
        $brand = Brand::all();
        $name = $request->input('name');
        $sort = $request->input('sort', 'default');

        $result = Product::query();

        if ($name) {
            $result = $result->where("name", "like", '%' . $name . '%');
        }


        switch ($sort) {
            case 'az':
                $result->orderBy('name', 'asc');
                break;
            case 'za':
                $result->orderBy('name', 'desc');
                break;
            case 'asc':
                $result->orderBy('price', 'asc');
                break;
            case 'desc':
                $result->orderBy('price', 'desc');
                break;
            default:

                break;
        }

        $result = $result->paginate(6);

        return view("home.searchByName", [
            'product' => $result,
            'category' => $category,
            'brand' => $brand
        ]);
    }






}
