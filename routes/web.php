<?php

use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


// Home
Route::get('/',  fn () =>  redirect('/home'));
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth
Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect'])->name('oauth');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback']);

Route::get('/login',  [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login',  [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Localization
Route::get('/greeting/{locale}', [LocalizationController::class, 'greeting'])->name('locale');

// Send Mail
Route::get('/mail', [MailController::class, 'send']);

// Chat app
Route::post('/chat/broadcast/{senderId}', [ChatController::class, 'broadcast'])->name('chat.broadcast');

// Route Admin
include __DIR__ . '/admin.php';


Route::get('/clear-cache', function () {
    // $exitCode = Artisan::call('cache:clear');
    // $exitCode = Artisan::call('config:cache');

    return 'DONE';
});

Route::get('/test', function () {
    // dd(public_path('public'));
    // dd($request->all());
    return 1;
});


Route::post('/vnpay-payment', function () {
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = "https://localhost/test";
    $vnp_TmnCode = "698UJF8Y";
    $vnp_HashSecret = "CPRGZROFKTVEDHZLZWQPYQHKHMODXUMO";

    $vnp_TxnRef = '1232'; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
    $vnp_OrderInfo = 'Thanh toan don hàng'; // Tiếng Việt không dấu và không bao gồm các ký tự đặc biệt)
    $vnp_OrderType = 'billpayment';
    $vnp_Amount = 20000 * 100;
    $vnp_Locale = 'vn';
    $vnp_BankCode = 'NCB';
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    //Add Params of 2.0.1 Version
    // $vnp_ExpireDate = $_POST['txtexpire'];

    //Billing
    // $vnp_Bill_Mobile = $_POST['txt_billing_mobile'];
    // $vnp_Bill_Email = $_POST['txt_billing_email'];
    // $fullName = trim($_POST['txt_billing_fullname']);
    // if (isset($fullName) && trim($fullName) != '') {
    //     $name = explode(' ', $fullName);
    //     $vnp_Bill_FirstName = array_shift($name);
    //     $vnp_Bill_LastName = array_pop($name);
    // }
    // $vnp_Bill_Address=$_POST['txt_inv_addr1'];
    // $vnp_Bill_City=$_POST['txt_bill_city'];
    // $vnp_Bill_Country=$_POST['txt_bill_country'];
    // $vnp_Bill_State=$_POST['txt_bill_state'];
    // // Invoice
    // $vnp_Inv_Phone=$_POST['txt_inv_mobile'];
    // $vnp_Inv_Email=$_POST['txt_inv_email'];
    // $vnp_Inv_Customer=$_POST['txt_inv_customer'];
    // $vnp_Inv_Address=$_POST['txt_inv_addr1'];
    // $vnp_Inv_Company=$_POST['txt_inv_company'];
    // $vnp_Inv_Taxcode=$_POST['txt_inv_taxcode'];
    // $vnp_Inv_Type=$_POST['cbo_inv_type'];
    $inputData = array(
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef,
        // "vnp_ExpireDate"=>$vnp_ExpireDate,
        // "vnp_Bill_Mobile"=>$vnp_Bill_Mobile,
        // "vnp_Bill_Email"=>$vnp_Bill_Email,
        // "vnp_Bill_FirstName"=>$vnp_Bill_FirstName,
        // "vnp_Bill_LastName"=>$vnp_Bill_LastName,
        // "vnp_Bill_Address"=>$vnp_Bill_Address,
        // "vnp_Bill_City"=>$vnp_Bill_City,
        // "vnp_Bill_Country"=>$vnp_Bill_Country,
        // "vnp_Inv_Phone"=>$vnp_Inv_Phone,
        // "vnp_Inv_Email"=>$vnp_Inv_Email,
        // "vnp_Inv_Customer"=>$vnp_Inv_Customer,
        // "vnp_Inv_Address"=>$vnp_Inv_Address,
        // "vnp_Inv_Company"=>$vnp_Inv_Company,
        // "vnp_Inv_Taxcode"=>$vnp_Inv_Taxcode,
        // "vnp_Inv_Type"=>$vnp_Inv_Type

    );

    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }
    if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
        $inputData['vnp_Bill_State'] = $vnp_Bill_State;
    }

    //var_dump($inputData);
    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashdata .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }

    $vnp_Url = $vnp_Url . "?" . $query;
    if (isset($vnp_HashSecret)) {
        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }
    $returnData = array(
        'code' => '00', 'message' => 'success', 'data' => $vnp_Url
    );
    if (isset($_POST['redirect'])) {
        header('Location: ' . $vnp_Url);
        die();
    } else {
        echo json_encode($returnData);
    }
})->name('vnpay');
