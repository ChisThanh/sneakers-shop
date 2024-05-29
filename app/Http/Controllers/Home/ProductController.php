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
        
        return view('home.products.index');
    }

    public function getPaginate(Request $request)
    {
        $page = $request->input('page', 1);

        $products = Product::query()->paginate(5);
        $products->getCollection()->transform(function ($products) {

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


    public function detailpro($id)
    {
        $product = Product::where("id", $id)->first();
        $product->image = $product->url_img;

        $category = Category::where("id", $product->category_id)->first();
        $product_tran = ProductTranslation::where("product_id", $id)->get();

        $comments = ProductReview::where('product_id', $id)->orderBy('id', 'DESC')->get();
        $size = Size::where('product_id', $id)->get();
        $ratingAvg = ProductReview::where('product_id', $id)->avg('rating');

        $rating_user = ProductReview::where('product_id', $id)->pluck('rating', 'user_id');
        $numberOfReviews = ProductReview::where('product_id', $id)->count();

        return view("home.products.detail", compact('product', 'category', 'product_tran', 'size', 'comments', 'ratingAvg', 'rating_user', 'numberOfReviews'));
    }

    public function post_commnet($proid)
    {
        $data = request()->validate([
            'comment' => 'required|string',
            'rating' => 'required|numeric',
        ]);

        $data['product_id'] = $proid;
        $data['user_id'] = auth()->id();

        // Tìm đánh giá của sản phẩm này từ người dùng
        $model = ProductReview::where([
            'product_id' => $proid,
            'user_id' => auth()->id()
        ])->first();

        if ($model)
            $model->update($data);
        else
            ProductReview::create($data);

        return redirect()->back();
    }
}
