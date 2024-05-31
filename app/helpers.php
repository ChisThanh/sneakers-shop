<?php

use App\Enums\BillStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Bill;
use App\Models\Config;
use App\Models\ProductReview;
use App\Models\ShoppingCart;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

if (!function_exists('getCart')) {
    function getCart()
    {
        return new ShoppingCart();
    }
}

if (!function_exists('checkCmt')) {
    function checkCmt($idP): bool
    {
        $results = DB::table('bill_details as b_d')
            ->join('bills as b', 'b.id', '=', 'b_d.bill_id')
            ->leftJoin('product_reviews as p', 'p.product_id', '=', 'b_d.product_id')
            ->where('b.user_id', auth()->id())
            ->whereNull('p.rating')
            ->where('b.payment_status', PaymentStatusEnum::PAID)
            ->where('b_d.product_id', $idP)
            ->exists();
        return $results;
    }
}



if (!function_exists('checkPayment')) {
    function checkPayment($idBill): bool
    {
        $check = Bill::query()
            ->where('id', $idBill)
            ->where("user_id", auth()->user()->id)
            ->where("payment_status", PaymentStatusEnum::PAID)
            ->exists();
        return $check;
    }
}

if (!function_exists('formatCurrency')) {
    function formatCurrency($n)
    {
        if (App::isLocale('vi')) {
            $inputStr = strval($n);
            $parts = explode('.', $inputStr);
            $parts[0] = number_format($parts[0]);
            return implode('.', $parts) . " VND";
        } else {
            $conf = Config::where("key", "USD")->first('value');
            $rate = (int) $conf->value;
            $cur = $n / $rate;
            return "$" . round($cur, 2);
        }
    }
}