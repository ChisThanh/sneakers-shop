<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    use HasFactory;
    public $items=[];//chứa thông tin các sản phẩm
    public $totalPrice=0;
    public $totalQuantity=0;
    public function __construct()
    {

        $this->items=session('cart')?session('cart'):[];//lấy thông tin cũ trong session nếu có ra trước;
        $this->totalQuantity=$this->getTotalQuantity();
        $this->totalPrice=$this->getTotalPrice();
    }

    public function addCart($product, $quantity = null)
    {
        if ($quantity === null) {
            $quantity = request('quantity', 1);
        }

        if (isset($this->items[$product->id])) {
            $this->items[$product->id]['quantity'] += $quantity;
        } else {
            // Sản phẩm chưa tồn tại trong giỏ hàng, thêm sản phẩm mới
            $cart_item = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $quantity
            ];
            $this->items[$product->id] = $cart_item;
        }

        session(['cart' => $this->items]);
    }

    public function updateCart($id,$quantity=null)
    {
        if ($quantity === null) {
            $quantity = request('quantity', 1);
        }
        if (isset($this->items[$id])) {
            $this->items[$id]['quantity'] = $quantity;
        }
        session(['cart' => $this->items]);
    }
    public function deleteCart($id)
    {
        if(isset($this->items[$id])){
            unset($this->items[$id]);//xóa
            session(['cart' => $this->items]);
        }

    }
    public function clearCart()
    {
        session()->forget('cart');

    }

    private function getTotalPrice()
    {
        $total=0;

        foreach($this->items as $item)
        {
            $total+=$item['quantity']*$item['price'];
        }
        return $total;
    }
    private function getTotalQuantity()
    {
        $total=0;
        //dd($this->item);
        foreach($this->items as $item)
        {
            $total+=$item['quantity'];
        }
        return $total;
    }
}
