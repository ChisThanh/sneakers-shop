<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatusEnum;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Models\Bill;
use App\Models\BillDetail;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $quantityBill = Bill::get()->count();
        $quantityUser = User::get()->count();
        $quantityProduct = Product::get()->count();
        $totalBill = Bill::query()->sum("total");

        return view('admin.dashboard.index', [
            "quantityBill" => $quantityBill,
            "quantityUser" => $quantityUser,
            "quantityProduct" => $quantityProduct,
            "totalBill" => rtrim(number_format($totalBill, 2), '.0'),
        ]);
    }

    public function getChartData()
    {
        $chartData = Bill::select(
            DB::raw('MONTH(delivery_date) as month'),
            DB::raw('SUM(total) as total')
        )
            ->where('payment_status', PaymentStatusEnum::PAID)
            // ->whereYear('delivery_date', date('Y'))
            ->groupBy(DB::raw('MONTH(delivery_date)'))
            ->orderBy(DB::raw('month'), 'asc')
            ->get();

        return $this->successResponse($chartData, 'Thành công');
    }

    public function getChartCategories()
    {
        $datas = BillDetail::query()
            ->join('products', 'products.id', '=', 'bill_details.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->select('categories.name',  DB::raw('ROUND((COUNT(categories.id) * 100.0) / SUM(COUNT(categories.id)) OVER()) AS percentage'))
            ->groupBy('categories.id', 'categories.name')
            ->get();
        return $this->successResponse($datas, 'Thành công');
    }
}