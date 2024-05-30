<?php

use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\OrderController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Home\ProductController;
use App\Http\Controllers\Home\ShoppingCartController;
use App\Http\Controllers\SocialiteController;
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


Route::get('bill/view-invoice-pdf/{id}', [PDFController::class, 'viewPdfInvoice']);
Route::get('bill/down-invoice-pdf/{id}', [PDFController::class, 'downloadPdfInvoice']);


Route::post('/vnpayment', [OrderController::class, "vnpayment"])->name("vnpayment");

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
    );

    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }
    if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
        $inputData['vnp_Bill_State'] = $vnp_Bill_State;
    }

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
});


Route::get('/detail/{id}', [ProductController::class, 'detailProduct'])->name('detailpro');

//commennt
Route::post('/comment/{product_id}', [ProductController::class, 'post_commnet'])->name('post.commnet');


//Shopping Cart
Route::group(['prefix' => 'cart'], function () {
    Route::get('/show', [ShoppingCartController::class, 'show'])->name('cart-show');
    Route::get('/add/{product}', [ShoppingCartController::class, 'addToCart'])->name('cart.add');
    Route::get('/delete/{id}', [ShoppingCartController::class, 'deleteCart'])->name('cart.delete');
    Route::post('/update', [ShoppingCartController::class, 'updateCart'])->name('cart.update');
    Route::post('/updateItem/{id}', [ShoppingCartController::class, 'updateCartItem'])->name('cart.updateitem');
    Route::get('/clear', [ShoppingCartController::class, 'clearCart'])->name('cart.clear');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/update', [OrderController::class, 'update'])->name('checkout.update');
    Route::get('/bill', [OrderController::class, 'Bill'])->name('bill');
    Route::get('/my-order', [OrderController::class, 'Myorder'])->name('my-order');
});