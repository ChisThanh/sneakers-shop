<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Category;
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
                $price_sale = $each['gia_khuyen_mai'];
                $quantiy = $each['so_luong'];
                $description = $each['mo_ta'];
                $brand_name = $each['nhan_hieu'];
                $category_name = $each['the_loai'];

                $brand = Brand::firstOrCreate(
                    ["name" => $brand_name],
                    ["name" => $brand_name]
                );
                $ategory = Category::firstOrCreate(
                    ["name" => $category_name],
                    ["name" => $category_name]
                );



                $product = Product::query()->where('name', $name)->first();

                if (!is_null($product)) {
                    throw new \Exception('Sản phẩm ' . $name . ' đã tồn tại', 4009);
                }

                Product::create([
                    'brand_id' => $brand->id,
                    'category_id' => $ategory->id,
                    'name' => $name,
                    'price' => $price,
                    'price_sale' => $price_sale,
                    'stock_quantity' =>  $quantiy,
                    'image' => '',
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
