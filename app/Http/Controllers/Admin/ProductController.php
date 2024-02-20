<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Product\StoreRequest;
use App\Imports\ProductImport;
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $product = ProductTranslation::query()->where('name', $data['name'])->first();
        if (!is_null($product)) {
            return redirect()->back()->withErrors(['msg' => 'Sản phẩm đã tồn tại']);
        }

        $imagePath = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $newFileName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $request->file('image')->storeAs('/products', $newFileName, ['disk' => 'public']);
        }

        Product::create([
            'price' =>  $data['price'],
            'stock_quantity' => $data['quantity'],
            'image' =>  $imagePath,
            'vi' => [
                'name' => $data['name'],
                'description' => $data['description-vi'],
            ],
            'en' => [
                'name' => $data['name'],
                'description' => $data['description-en'],
            ]
        ]);
        return $this->successResponse(message: 'Thành công!');
        // return redirect()->route('admin.product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
