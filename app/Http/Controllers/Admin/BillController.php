<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BillStatusEnum;
use App\Enums\CartStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Cart;
use App\Models\CartDetail;
use Illuminate\Http\Request;


class BillController extends Controller
{
    use ResponseTrait;

    public function getPaginate()
    {
        $carts = Bill::query()->paginate(5);

        $carts->transform(function ($cart) {
            $cart->user_name = $cart->user->name;

            if ($cart->status === 1) {
                $cart->status_array = [BillStatusEnum::getKey(BillStatusEnum::DESTROY)];
            } else {
                $cart->status_array = BillStatusEnum::getKeys(range((int)$cart->status, BillStatusEnum::REVIEWS));
            }
            return $cart;
        });

        return $carts;
    }

    public function getCartDetail(string $id)
    {
        $cartDetail = BillDetail::with('product')->where('bill_id', $id)->get();
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

    public function update(Request $request, string $id)
    {
        $cart = Bill::query()->find($id);
        $cart->update([
            'status' => BillStatusEnum::getValue($request->status),
        ]);

        $cart->save();

        return $this->successResponse(message: 'Thành công');
    }
}