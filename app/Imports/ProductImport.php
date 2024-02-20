<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductTranslation;
use Exception;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
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
                $product = ProductTranslation::query()->where('name', $name)->first();
                if (!is_null($product)) {
                    throw new \Exception('Sản phẩm ' . $name . ' đã tồn tại', 4009);
                }
                Product::create([
                    'price' => $price,
                    'stock_quantity' => 1,
                    'image' => '',
                    'vi' => [
                        'name' => $name,
                        'description' => $description,
                    ],
                    'en' => [
                        'name' => $name,
                        'description' => GoogleTranslate::trans($description, 'en')
                    ]
                ]);
            } catch (\Exception $ex) {
                throw $ex;
            }
        }
    }
}
