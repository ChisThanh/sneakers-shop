<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function addToCart(Product $product, ShoppingCart $cart)
    {
        $quantity = request('quantity', 1);
        $quantity = $quantity > 0 ? floor($quantity) : 1;
        $cart->addCart($product, $quantity);

        return redirect()->back();
    }
    
    public function show(ShoppingCart $cart)
    {
        return view('home.cart.cart-show', compact('cart'));
    }

    public function deleteCart($id, ShoppingCart $cart)
    {
        $cart->deleteCart($id);
        return redirect()->route('cart-show');
    }

    public function updateCart(Request $request)
    {
        $items = $request->input('items');
        $cart = new ShoppingCart();

        foreach ($items as $item) {
            $id = $item['id'];
            $quantity = max(1, (int)$item['quantity']);
            $cart->updateCart($id, $quantity);
        }

        return redirect()->route('cart-show');
    }
    public function updateCartItem($id, Request $request, ShoppingCart $cart)
    {
        $quantity = $request->input('quantity', 1);
        $quantity = max(1, (int)$quantity);
        $cart->updateCart($id, $quantity);

        return redirect()->route('cart-show');
    }
    public function clearCart(ShoppingCart $cart)
    {
        $cart->clearCart();
        return redirect()->route('cart-show');
    }
}