<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection
{

    use Exportable;
    public function collection()
    {
        return Product::with(['brand', 'category'])->get()->map(function ($product) {
            return [
                'ID' => $product->id,
                'Name' => $product->name,
                'Category' => $product->category->name,
                'Brand' => $product->brand->name,
                'Price' => $product->price,
                'Sale Price' => $product->price_sale,
                'Image' => $product->image,
                'Stock Quantity' => $product->stock_quantity,
                'Description (VI)' => $product->translate('vi')->description,
                'Description (EN)' => $product->translate('en')->description,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Category',
            'Brand',
            'Price',
            'Sale Price',
            'Image',
            'Stock Quantity',
            'Description (VI)',
            'Description (EN)',
        ];
    }
}