<?php

use App\Enums\PaymentStatusEnum;
use App\Models\Bill;
use App\Models\ProductReview;
use App\Models\ShoppingCart;

if (!function_exists('getCart')) {
    function getCart()
    {
        return new ShoppingCart();
    }
}

if (!function_exists('checkCmt')) {
    function checkCmt($idP, $idU): bool
    {
        $exists = Bill::query()
            ->whereHas('details', function ($query) use ($idP) {
                $query->where('product_id', $idP);
            })
            ->where('user_id', $idU)
            ->first();

        if (!$exists)
            return false;

        $exists = ProductReview::where('product_id', $idP)
            ->where('user_id', $idU)
            ->first();

        if (!$exists)
            return true;

        if ($exists->quantity_limit >= 0)
            return false;

        return true;
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