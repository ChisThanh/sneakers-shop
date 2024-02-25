<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductTranslation;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ProductImport implements ToArray, WithHeadingRow
{
    public function array(array $array)
    {
        foreach ($array as $each) {
            try {
                $name = $each['ten'];
                $price = $each['gia'];
                $description = $each['mo_ta'];

                $product = Product::query()->where('name', $name)->first();

                if (!is_null($product)) {
                    throw new \Exception('Sản phẩm ' . $name . ' đã tồn tại', 4009);
                }

                Product::create([
                    'name' => $name,
                    'price' => $price,
                    'stock_quantity' => 1,
                    'image' => 'Chưa có ảnh',
                    'vi' => [
                        'description' => $description,
                    ],
                    'en' => [
                        'description' => GoogleTranslate::trans($description, 'en')
                    ]
                ]);
            } catch (\Exception $ex) {
                throw $ex;
            }
        }
    }
}
