<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $brands = [];
        for ($i = 0; $i < 5; $i++) {
            $brands[] = Brand::create([
                'name' => $faker->company,
            ])->id;
        }

        $categories = [];
        for ($i = 0; $i < 5; $i++) {
            $categories[] = Category::create([
                'name' => $faker->word,
            ])->id;
        }

        $name_img = ["p1.jpg", "p2.jpg", "p3.jpg", "p4.jpg", "p5.jpg", "p6.jpg", "p7.jpg", "p8.jpg"];
        for ($i = 1; $i <= 50; $i++) {
            $random_image = $name_img[array_rand($name_img)];
            $price = $faker->randomFloat(2, 100, 1000);
            $priceSale = $faker->randomFloat(2, 100, $price);

            Product::create([
                'name' => $faker->name,
                'category_id' => $faker->randomElement($categories),
                'brand_id' => $faker->randomElement($brands),
                'price_sale' =>  $priceSale,
                'price' =>  $price,
                'stock_quantity' => $faker->numberBetween(0, 100),
                'image' =>  "/img/product/$random_image",
                'vi' => [
                    'description' => GoogleTranslate::trans($faker->paragraph, 'vi'),
                ],
                'en' => [
                    'description' => $faker->paragraph,
                ]
            ]);
        }
    }
}
