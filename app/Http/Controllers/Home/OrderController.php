<?php

namespace App\Http\Controllers\Home;

use App\Enums\CartStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Order;
use App\Models\ShoppingCart;
use BenSampo\Enum\Rules\Enum;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function checkout()
    {
        $user=auth()->user();
        $cart = session()->get('cart', []);
        return view('home.order.checkout',compact('user','cart'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'firtsname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $user->update($request->only('firtsname', 'lastname', 'phone', 'address'));

        $cart = $request->session()->get('cart');
        $totalPrice = 0;
        
        foreach ($cart as $item) {
            $totalPrice += $item['quantity'] * $item['price']+50;
        }

        $order = new Cart();
        $order->user_id = auth()->id();
        $order->total = $totalPrice;
        $order->delivery_date = now();
        $order->payment_status = 0;
        $order->payment_method = 0;
        $order->status = CartStatusEnum::ORDER;
        $order->save();
        session(['order' => $order]);


        foreach ($cart as $item) {
            $cartDetail = new CartDetail();
            $cartDetail->cart_id = $order->id;
            $cartDetail->product_id = $item['id'];
            $cartDetail->quantity = $item['quantity'];
            $cartDetail->price = $item['price'];
            $cartDetail->save();
            $orderDetails[] = $cartDetail;
        }

        session(['orderdetails' => $orderDetails]);
        session(['cart1' => $cart]);
        
        $request->session()->forget('cart');

        return redirect()->route('bill');
    }

    public function Bill(Request $request)
    {
        $user = auth()->user();
        $order = session()->get('order');
        $orderdetails = session()->get('orderdetails');
        $cart1 = session()->get('cart1');

        return view('home.order.check_status', compact('user', 'order','cart1'));
    }
    
    public function Myorder()
    {
        $user = auth()->user();
        $orders = $user->cart;
        return view('Order.MyOrder', compact('orders'));
    }
}