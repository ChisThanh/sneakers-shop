<?php

namespace Database\Seeders;

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

        for ($i = 1; $i <= 10; $i++) {
            Product::create([
                'name' => $faker->name,
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
