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

            $results = DB::table('bill_details as b_d')
                ->join('bills as b', 'b.id', '=', 'b_d.bill_id')
                ->leftJoin('product_reviews as p', 'p.product_id', '=', 'b_d.product_id')
                ->where('b_d.bill_id', $bill->id)
                ->where('b.user_id', auth()->id())
                ->whereNull('p.rating')
                ->where('b.payment_status', PaymentStatusEnum::PAID)
                ->get();


            if (count($results) > 0) {
                $bill->check_rating  = true;
            } else {
                $bill->check_rating  = false;
            }

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
        return view('home.Change_pass');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::find(auth()->id());
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'The current password is incorrect.');
        }

        $user->password = Hash::make($request->new_password);
        $user->update();


        return redirect()->back()->with('success', 'Password updated successfully.');
    }
}
