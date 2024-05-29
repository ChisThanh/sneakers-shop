<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        for ($i = 1; $i <= 50; $i++) {
            Product::create([
                'name' => $faker->name,
                'category_id' => $faker->randomElement($categories),
                'brand_id' => $faker->randomElement($brands),
                'price' =>  $faker->randomFloat(2, 0, 1000),
                'stock_quantity' => $faker->numberBetween(0, 100),
                'image' =>  $faker->imageUrl(),
                'vi' => [
                    'description' => $faker->paragraph,
                ],
                'en' => [
                    'description' => $faker->paragraph,
                ]
            ]);
        }
    }
}
