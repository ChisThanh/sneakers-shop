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

// Bill
Route::get('bill/view-invoice-pdf/{id}', [PDFController::class, 'viewPdfInvoice']);
Route::get('bill/down-invoice-pdf/{id}', [PDFController::class, 'downloadPdfInvoice']);

// payment VNPAY
Route::post('/vnpayment', [OrderController::class, "vnpayment"])->name("vnpayment");

// product
Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/search-image', [ProductController::class, 'searchImage'])->name('searchImage');
    Route::get('/detail/{id}', [ProductController::class, 'detailProduct'])->name('detailpro');
});

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

// auth check
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/update', [OrderController::class, 'update'])->name('checkout.update');
    Route::get('/bill', [OrderController::class, 'Bill'])->name('bill');
    Route::get('/my-order', [OrderController::class, 'Myorder'])->name('my-order');
});

// Route Admin
include __DIR__ . '/admin.php';