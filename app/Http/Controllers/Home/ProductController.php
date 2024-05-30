<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\Size;
use Illuminate\Http\Request;
use App\Models\ProductReview;

class ProductController extends Controller
{
    use ResponseTrait;


    public function index(Request $request)
    {
        $category = Category::all();
        $brand = Brand::all();
        $sort = $request->input('sort', 'default');

        $q = $request->input('q');
        $category_id = $request->get("category_id") ?? null;
        $brand_id = $request->get("brand_id") ?? null;

        $query = Product::query();

        if ($category_id !== null)
            $query->where('category_id', $category_id);

        if ($brand_id !== null)
            $query->where('brand_id', $brand_id);

        if ($q)
            $result = $query->where("name", "like", '%' . $q . '%');


        switch ($sort) {
            case 'az':
                $query->orderBy('name', 'asc');
                break;
            case 'za':
                $query->orderBy('name', 'desc');
                break;
            case 'asc':
                $query->orderBy('price', 'asc');
                break;
            case 'desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                break;
        }

        $product = $query->paginate(6);

        $product->transform(function ($product) {
            $product->image = $product->url_img;
            return $product;
        });

        return view('home.products.index', compact('category', 'brand', 'product'));
    }

    public function getPaginate(Request $request)
    {
        $page = $request->input('page', 1);

        $products = Product::query()->paginate(5);

        $products->transform(function ($products) {
            $products->image = $products->url_img;
            return $products;
        });

        if ($page > $products->lastPage()) {
            return redirect()->route('api.product.index', ['page' =>  $products->lastPage()]);
        }
        return $products;
    }

    public function detail(string $id)
    {
        try {
            $product = Product::query()->findOrFail($id);
        } catch (\Throwable $th) {
            return $this->errorResponse('Sản phẩm không tồn tại');
        }
        $product->image = $product->url_img;
        return $this->successResponse($product, 'Thành công');
    }

    public function searchImage(Request $request)
    {
        $images = $request->get("data");
        $products = Product::where(function ($query) use ($images) {
            foreach ($images as $image) {
                $query->orWhere('image', 'like', '%' . $image . '%');
            }
        })->get();
        return $products;
    }


    public function detailProduct($id)
    {
        $product = Product::where("id", $id)->first();
        $product->image = $product->url_img;

        $productReviews = ProductReview::where('product_id', $id)->get();

        $ratingAvg = $productReviews->avg('rating');

        $rating_user = $productReviews->pluck('rating', 'user_id');

        $numberOfReviews = $productReviews->count();

        return view("home.products.detail", compact('product',  'productReviews', 'ratingAvg', 'rating_user', 'numberOfReviews'));
    }

    public function post_commnet($proid)
    {
        $data = request()->validate([
            'comment' => 'required|string',
            'rating' => 'required|numeric',
        ]);

        $data['product_id'] = $proid;
        $data['user_id'] = auth()->id();

        $review = ProductReview::where('product_id', $data['product_id'])
            ->where('user_id', $data['user_id'])
            ->first();

        if ($review) {
            $review->update([
                "quantity_limit" => $review->quantity_limit += 1,
                "comment" => $data['comment'],
                "rating" => $data['rating'],
            ]);
        } else {
            $review = ProductReview::Create([
                "product_id" => $data['product_id'],
                "user_id" => $data['user_id'],
                "quantity_limit" => 0,
                "comment" => $data['comment'],
                "rating" => $data['rating'],
            ]);
        }

        return redirect()->back();
    }
}