<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class ShoppingCart extends Model
{
    public $items = [];
    public $totalPrice = 0;
    public $totalQuantity = 0;

    public function __construct()
    {
        $this->items = json_decode(Cookie::get('cart'), true) ?? [];
        $this->totalQuantity = $this->getTotalQuantity();
        $this->totalPrice = $this->getTotalPrice();
    }

    public function addCart($product, $quantity = null)
    {
        if ($quantity === null) {
            $quantity = request('quantity', 1);
        }

        if (isset($this->items[$product->id])) {
            $this->items[$product->id]['quantity'] += $quantity;
        } else {
            $cart_item = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price_sale,
                'image' => $product->image,
                'quantity' => $quantity
            ];
            $this->items[$product->id] = $cart_item;
        }
        Cookie::forget('cart');
        Cookie::queue('cart', json_encode($this->items), 60 * 24 * 7);
    }

    public function updateCart($id, $quantity = null)
    {


        if ($quantity === null) {
            $quantity = request('quantity', 1);
        }

        if (isset($this->items[$id])) {
            $this->items[$id]['quantity'] = $quantity;
        }
        Cookie::queue('cart', json_encode($this->items), 60 * 24 * 30);
    }

    public function deleteCart($id)
    {
        if (isset($this->items[$id])) {
            unset($this->items[$id]);
            Cookie::queue('cart', json_encode($this->items), 60 * 24 * 7);
        }
    }

    public function clearCart()
    {
        Cookie::forget('cart');
        Cookie::queue('cart', json_encode([]), 60);
    }

    public function getTotalPrice()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['quantity'] * $item['price'];
        }
        return $total;
    }

    public function getTotalQuantity()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['quantity'];
        }
        return $total;
    }
}
