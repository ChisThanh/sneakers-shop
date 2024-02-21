<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string'
            ],
            'price' => [
                'required',
                'numeric',
                'min:0'
            ],
            'image' => [
                'nullable',
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
}
