<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    use ResponseTrait;

    public function addToCart($id, ShoppingCart $cart)
    {
        $product = Product::find($id);
        if (!$product) {
            return back()->withErrors("lõi");
        }

        $quantity = request('quantity', 1);
        $quantity = $quantity > 0 ? floor($quantity) : 1;
        $cart->addCart($product, $quantity);

        return $this->successResponse('', 'Thành congg');
    }

    public function show(ShoppingCart $cart)
    {
        return view('home.cart.cart-show', compact('cart'));
    }

    public function deleteCart($id, ShoppingCart $cart)
    {
        $cart->deleteCart($id);
        return redirect()->back();
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

        return redirect()->back();
    }
    public function updateCartItem($id, Request $request, ShoppingCart $cart)
    {
        $quantity = $request->input('quantity', 1);
        $quantity = max(1, (int)$quantity);
        $cart->updateCart($id, $quantity);

        return $this->successResponse('', 'Thành công');;
    }
    public function clearCart()
    {
        $cart = new ShoppingCart();
        $cart->clearCart();
        return redirect()->back();
    }

    public function quantityCart()
    {
        $card = new ShoppingCart();
        return response()->json([
            "quantity" => $card->totalQuantity
        ]);
    }
}
