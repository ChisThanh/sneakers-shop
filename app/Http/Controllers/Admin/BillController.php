<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BillStatusEnum;
use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Config;
use Illuminate\Http\Request;


class BillController extends Controller
{
    use ResponseTrait;

    public function getPaginate()
    {
        $carts = Bill::with('user')->paginate(5);

        foreach ($carts as $cart) {
            $cart->user_name = $cart->user->name;
            $cart->payment_method = PaymentMethodEnum::getKey($cart->payment_method);
            $cart->status_array = $cart->status === 1 ?
                [BillStatusEnum::getKey(BillStatusEnum::DESTROY)] :
                BillStatusEnum::getKeys(range((int)$cart->status, BillStatusEnum::RECEIVE));
            $cart->status_payment_array = $cart->payment_status == 0 ? ["UNPAID", "PAID"] : ["PAID", "UNPAID"];
        }

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
        $config = Config::where("key", "USD")->first("value");
        $price = $config->value;
        return view('admin.carts.index', compact('price'));
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

    public function unpdatePaymentStatus(Request $request, string $id)
    {
        $cart = Bill::query()->find($id);
        $cart->update([
            'payment_status' => PaymentStatusEnum::getValue($request->status),
        ]);
        $cart->save();
        return $this->successResponse(message: 'Thành công');
    }
}
