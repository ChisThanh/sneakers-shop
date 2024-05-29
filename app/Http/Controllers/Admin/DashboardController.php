<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
class DashboardController extends Controller
{
    public function index()
    {
        $chartData = Cart::where('status', 1)
                             ->selectRaw('MONTH(delivery_date) as thang, SUM(total) as tongTien')
                             ->groupBy('thang')
                             ->get();
        return view('admin.dashboard.index', compact('chartData'));
    }

    
}
