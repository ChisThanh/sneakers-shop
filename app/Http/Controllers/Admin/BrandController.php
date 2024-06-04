<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Brand\StoreRequest;
use App\Http\Requests\Brand\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{

    use ResponseTrait;

    public function index()
    {
        return view('admin.brands.index');
    }

    public function getPaginate(Request $request)
    {
        $page = $request->input('page', 1);

        $brands = Brand::query()->paginate(5);
        if ($page > $brands->lastPage()) {
            return redirect()->route('api.brand.index', ['page' =>  $brands->lastPage()]);
        }
        return $brands;
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $brand = Brand::query()->where('name', $data['name'])->first();
        if (!is_null($brand)) {
            return redirect()->back()->withErrors(['msg' => 'Tên thương hiệu đã tồn tại']);
        }

        Brand::create(['name' => $data['name']]);

        return $this->successResponse(message: 'Thành công!');
    }

    public function edit(string $id)
    {
        $brand = Brand::query()->findOrFail($id);
        return view('admin.brands.edit', [
            'brand' => $brand
        ]);
    }

    public function update(UpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $brand = Brand::query()->where('name', $data['name'])->first();
        if (!is_null($brand)) {
            return redirect()->back()->withErrors(['msg' => 'Tên thương hiệu đã tồn tại']);
        }
        try {
            $brand = Brand::query()->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return redirect()->back()->withErrors(['msg' => 'Thương hiệu không tồn tại']);
        }

        $brand->fill(['name' => $data['name']]);
        $brand->save();

        return $this->successResponse(message: 'Thành công!');
    }

    public function destroy(string $id)
    {
        try {
            Brand::query()->findOrFail($id);
            Brand::destroy($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->errorResponse("Không thành công!");
        }

        return $this->successResponse('', 'Thành công');
    }
}