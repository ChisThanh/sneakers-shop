<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string'
            ],
            'category'=> [
                'required',
                'string'
            ],
            'brand' => [
                'required',
                'string'
            ],
            'price' => [
                'required',
                'numeric',
                'min:0'
            ],
            'image' => [
                'required',
                'image',
                // 'size:1024'  // only 1MB is allowed
            ],
            'quantity' => [
                'required',
                'numeric',
                'min:0'
            ],
            'description-vi' => [
                'required',
                'string'
            ],
            'description-en' => [
                'required',
                'string'
            ]
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên sản phẩm',
            'category_id.required' => 'Bạn chưa chọn danh mục',
            'brand_id.required' => 'Bạn chưa chọn thương hiệu',
            'price.required' => 'Bạn chưa nhập giá sản phẩm',
            'quantity.required' => 'Bạn chưa nhập số lượng sản phẩm',
            'description.required' => 'Bạn chưa nhập mô tả sản phẩm',
        ];
    }
}
