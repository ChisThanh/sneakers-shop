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
        $status_pm = PaymentStatusEnum::PAID;
        $result = DB::table(DB::raw('(SELECT DISTINCT b.user_id, bd.product_id FROM bills b
            JOIN bill_details bd ON b.id = bd.bill_id
            WHERE payment_status = ' . $status_pm . ') AS bf'))
            ->leftJoin('product_reviews as pr', function ($join) {
                $join->on('pr.user_id', '=', 'bf.user_id')
                    ->on('pr.product_id', '=', 'bf.product_id');
            })
            ->where('bf.user_id', auth()->id())
            ->where('bf.product_id', $idP)
            ->whereNull('pr.rating')
            ->exists();

        return $result;
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
