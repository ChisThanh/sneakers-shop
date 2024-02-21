<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ResponseTrait;
    public function getPaginate(Request $request)
    {
        $page = $request->input('page', 1);

        $products = Product::query()->paginate(2);

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
}
