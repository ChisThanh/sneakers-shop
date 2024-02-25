<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::query()->pluck('id')->toArray();
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $cart = Cart::create([
                'user_id' => 2,
                'delivery_date' => $faker->date(),
                'total' => $faker->randomFloat(2, 0, 1000),
                'status' => $faker->randomElement([0, 1, 2, 3, 4, 5]),
            ]);
            for ($j = 0; $j < 4; $j++) {
                CartDetail::create([
                    'cart_id' => $cart->id,
                    'product_id' => $products[array_rand($products)],
                    'quantity' => $faker->numberBetween(1, 10),
                    'price' => $faker->randomFloat(2, 0, 1000),
                ]);
            }
        }
    }
}
