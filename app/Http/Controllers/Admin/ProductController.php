<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Imports\ProductImport;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{

    use ResponseTrait;

    public function index()
    {
        return view('admin.products.index');
    }

    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $product = Product::query()->where('name', $data['name'])->first();
        if (!is_null($product)) {
            return redirect()->back()->withErrors(['msg' => 'Sản phẩm đã tồn tại']);
        }

        $imagePath = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $newFileName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('/products', $newFileName, ['disk' => 'public']);
            $image->move(public_path('images/products'), $newFileName);
        }

        Product::create([
            'price' =>  $data['price'],
            'category_id' => $data['category'],
            'brand_id' => $data['brand'], 
            'stock_quantity' => $data['quantity'],
            'image' =>  $imagePath,
            'name' => $data['name'],

            'vi' => [
                'description' => $data['description-vi'],
            ],
            'en' => [
                'description' => $data['description-en'],
            ]
        ]);
        
        return $this->successResponse(message: 'Thành công!');
    }

    public function edit(string $id)
    {
        $product = Product::query()->findOrFail($id);
        return view('admin.products.edit', [
            'product' => $product
        ]);
    }

    public function update(UpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $product = Product::query()->where('name', $data['name'])->first();
        if (!is_null($product)) {
            return redirect()->back()->withErrors(['msg' => 'Sản phẩm đã tồn tại']);
        }
        try {
            $product = Product::query()->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return redirect()->back()->withErrors(['msg' => 'Sản phẩm không tồn tại']);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $newFileName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('/products', $newFileName, ['disk' => 'public']);
            $image->move(public_path('images/products'), $newFileName);
        }
        
        $product->fill([
            'price' =>  $data['price'],
            'stock_quantity' => $data['quantity'],
            'image' =>  $imagePath ?? $product->image,
            'name' => $data['name'],
            'vi' => [
                'description' => $data['description-vi'],
            ],
            'en' => [
                'description' => $data['description-en'],
            ]
        ]);
        $product->save();
        return $this->successResponse(message: 'Thành công!');
    }

    public function destroy(string $id)
    {
        try {
                $product = Product::query()->findOrFail($id);
                Product::destroy($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception){
            return $this->errorResponse("Không thành công!");
        }
        
        return $this->successResponse('', 'Thành công');
    }

    public function importCSV(Request $request)
    {
        $file = $request->file('file');
        try {
            Excel::import(new ProductImport, $file);
            return $this->successResponse(message: 'Thành công');
        } catch (\Exception $ex) {
            if ($ex->getCode() === 4009) {
                return $this->errorResponse($ex->getMessage());
            }
            return $this->errorResponse("Không thành công");
        }
    }
}
