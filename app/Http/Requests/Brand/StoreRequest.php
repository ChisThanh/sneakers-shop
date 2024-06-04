<?php

namespace App\Http\Requests\Brand;

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
            ]
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên thương hiệu',
        ];
    }
}
