<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function getChartData(Request $request)
    {
        $chartData = Cart::select(
            DB::raw('MONTH(delivery_date) as month'),
            DB::raw('SUM(total) as total')
        )
            ->where('status', 1)
            ->groupBy(DB::raw('MONTH(delivery_date)'))
            ->orderBy(DB::raw('month'), 'asc')
            ->get();
        return response()->json($chartData);
    }

}
