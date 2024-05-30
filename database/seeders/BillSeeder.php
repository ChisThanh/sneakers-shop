<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Product;
use Illuminate\Database\Seeder;

class BillSeeder extends Seeder
{

    public function run(): void
    {
        $products = Product::query()->pluck('id')->toArray();
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $cart = Bill::create([
                'user_id' => 2,
                'delivery_date' => $faker->date(),
                'total' => $faker->numberBetween(100000, 1000000),
            ]);
            for ($j = 0; $j < 4; $j++) {
                BillDetail::create([
                    'bill_id' => $cart->id,
                    'product_id' => $products[array_rand($products)],
                    'quantity' => $faker->numberBetween(1, 10),
                    'price' => $faker->numberBetween(100000, 1000000),
                ]);
            }
        }
    }
}