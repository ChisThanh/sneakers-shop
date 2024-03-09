<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CartStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Models\Cart;
use App\Models\CartDetail;
use Illuminate\Http\Request;


class CartController extends Controller
{
    use ResponseTrait;

    public function getPaginate()
    {
        $carts = Cart::query()->paginate(5);

        $carts->getCollection()->transform(function ($cart) {

            $cart->user_name = $cart->user->name;

            if ($cart->status === 0) {
                $cart->status_array = [CartStatusEnum::getKey(CartStatusEnum::DESTROY)];
            } else {
                $cart->status_array = CartStatusEnum::getKeys(range((int)$cart->status, CartStatusEnum::REVIEWS));
            }

            return $cart;
        });

        return $carts;
    }

    public function getCartDetail(string $id)
    {
        $cartDetail = CartDetail::with('product')->where('cart_id', $id)->get();
        if (is_null($cartDetail)) {
            return $this->errorResponse('Không tồn tại');
        }

        return $this->successResponse($cartDetail, 'Thành công');
    }

    public function index()
    {
        return view('admin.carts.index');
    }


    public function create()
    {
        return view('admin.carts.create');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        dd($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cart = Cart::query()->find($id);

        $cart->update([
            'status' => CartStatusEnum::getValue($request->status),
        ]);
        $cart->save();

        return $this->successResponse(message: 'Thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
