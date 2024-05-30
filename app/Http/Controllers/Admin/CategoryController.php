<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        return view('admin.categories.index');
    }

    public function getPaginate(Request $request)
    {
        $page = $request->input('page', 1);

        $categories = Category::query()->paginate(5);
        if ($page > $categories->lastPage()) {
            return redirect()->route('api.brand.index', ['page' =>  $categories->lastPage()]);
        }
        return $categories;
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $category = Category::query()->where('name', $data['name'])->first();
        if (!is_null($category)) {
            return redirect()->back()->withErrors(['msg' => 'Tên danh mục đã tồn tại']);
        }

        Category::create(['name' => $data['name']]);

        return $this->successResponse(message: 'Thành công!');
    }

    public function edit(string $id)
    {
        $category = Category::query()->findOrFail($id);
        return view(
            'admin.categories.edit',
            [
                'category' => $category
            ]
        );
    }

    public function update(UpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $category = Category::query()->where('name', $data['name'])->first();
        if (!is_null($category)) {
            return redirect()->back()->withErrors(['msg' => 'Tên danh mục đã tồn tại']);
        }
        try {
            $category = Category::query()->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return redirect()->back()->withErrors(['msg' => 'Danh mục không tồn tại']);
        }

        $category->fill(['name' => $data['name']]);
        $category->save();

        return $this->successResponse(message: 'Thành công!');
    }

    public function destroy(string $id)
    {
        try {
            $category = Category::query()->findOrFail($id);
            Category::destroy($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->errorResponse("Không thành công!");
        }

        return $this->successResponse('', 'Thành công');
    }
}