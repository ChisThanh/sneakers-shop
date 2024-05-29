<?php

use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\CategoryController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\OrderController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Home\ProductController;
use App\Http\Controllers\Home\ShoppingCart;
use App\Http\Controllers\Home\ShoppingCartController;
use App\Http\Controllers\SocialiteController;
use App\Mail\CustomMail;
use App\Models\Cart;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/',  fn () =>  redirect('/home'));
Route::get('/home', [App\Http\Controllers\Home\HomeController::class, 'index'])->name('home');

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

Route::get('/test', function () {
    dd(Cart::with('cart_detail')->first());
    return 1;
});

Route::get('cart/view-invoice-pdf/{id}', [PDFController::class, 'viewPdfInvoice']);
Route::get('cart/down-invoice-pdf/{id}', [PDFController::class, 'downloadPdfInvoice']);


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


Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/search-image', [ProductController::class, 'searchImage'])->name('searchImage');
    // Route::get('/create', [ProductController::class, 'create'])->name('create');
    // Route::post('/create', [ProductController::class, 'store'])->name('store');
    // Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
    // Route::put('/edit/{id}', [ProductController::class, 'update'])->name('update');
    // Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('destroy');

});
Route::get('/category/{id}',[ProductController::class,'Cateproduct'])->name('cate');
Route::get('/brand/{id}',[ProductController::class,'Brandproduct'])->name('brand');
Route::get('/search',[HomeController::class,'searchByName'])->name('searchByName');
Route::post('/search',[HomeController::class,'searchByName'])->name('searchByName');
Route::get('/detail/{id}',[ProductController::class,'detailpro'])->name('detailpro');
//commennt
Route::post('/comment/{product_id}',[ProductController::class,'post_commnet'])->name('post.commnet');
//Shopping Cart
Route::group(['prefix'=>'cart'],function()
{
    Route::get('/show',[ShoppingCartController::class,'show']) -> name ('cart-show');
    Route::get('/add/{product}',[ShoppingCartController::class, 'addToCart'] ) -> name ('cart.add');
    Route::get('/delete/{id}',[ShoppingCartController::class,'deleteCart'])->name('cart.delete');
    Route::post('/update', [ShoppingCartController::class, 'updateCart'])->name('cart.update');
    Route::post('/updateItem/{id}', [ShoppingCartController::class, 'updateCartItem'])->name('cart.updateitem');
    Route::get('/clear',[ShoppingCartController::class,'clearCart'])->name('cart.clear');

});
Route::get('/test', 'ProductController@test');

Route::middleware(['auth'])->group(function () {
Route::get('/checkout',[OrderController::class,'checkout'])->name('checkout');
Route::post('/checkout/update', [OrderController::class, 'update'])->name('checkout.update');
Route::get('/Bill',[OrderController::class,'Bill'])->name('Bill');
Route::get('/my-order', [OrderController::class,'Myorder'])->name('my-order');

});
