<?php

namespace App\Http\Controllers\Home;

use App\Enums\BillStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InforUserController extends Controller
{
    public function show()
    {

        $user = auth()->user();

        $bills = Bill::where('user_id', $user->id)
            ->get();;

        $bills->transform(function ($bill) {
            $bill->status =  BillStatusEnum::getKey($bill->status);
            $bill->payment_status = PaymentStatusEnum::getKey($bill->payment_status);

            $check_rating = DB::table(DB::raw('(SELECT DISTINCT b.user_id, b.id AS _bill_id, bd.product_id FROM bills b
            JOIN bill_details bd ON b.id = bd.bill_id
            WHERE payment_status = ' . PaymentStatusEnum::PAID . ') AS bf'))
                ->leftJoin('product_reviews as pr', function ($join) {
                    $join->on('pr.user_id', '=', 'bf.user_id')
                        ->on('pr.product_id', '=', 'bf.product_id');
                })
                ->where('bf.user_id', auth()->id())
                ->where('bf._bill_id', $bill->id)
                ->whereNull('pr.rating')
                ->exists();

            $bill->check_rating  =  $check_rating;

            return $bill;
        });

        return view('home.user.show', compact("user", "bills"));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'firtsname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->fill($request->only(['name', 'email', 'phone', 'address', 'firtsname', 'lastname']))
            ->save();

        return redirect()->back()->with('success', 'User information updated successfully.');
    }


    public function showPass()
    {
        return view('auth.change_pass');
    }

    public function updatePass(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'password_new' => 'required|string|min:8',
        ]);

        $email = $request->get("email");
        $pass = $request->get("password");

        $user = User::where('email', $email)
            ->first();

        if (!$user) {
            return back()->with("error", "Tài khoảng không tồn tại");
        }

        if (!Hash::check($pass, $user->password)) {
            return redirect()->back()->with('error', 'Mật khẩu cũ không khớp');
        }


        $user->password = Hash::make($request->password_new);
        $user->update();


        return redirect()->back()->with('error', 'Thay đổi thành công');
    }
}