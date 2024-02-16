<?php

use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SocialiteController;
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
    $exitCode = Artisan::call('cache:clear');
    // $exitCode = Artisan::call('config:cache');
    return 'DONE';
});

Route::get('/test', function () {
    // $product = Product::create([
    //     'price' => 999,
    //     'stock_quantity' => 1,
    //     'vi' => [
    //         'name' => 'giày',
    //         'description' => 'giày',
    //     ],
    //     'en' => [
    //         'name' => 'sneaker',
    //         'description' => 'sneaker',
    //     ]
    // ]);


    // $product = Product::create([
    //     'price' => 999,
    //     'stock_quantity' => 1,
    //     'vi' => [
    //         'name' => 'giày 1',
    //         'description' => 'giày 1',
    //     ],
    //     'en' => [
    //         'name' => 'sneaker 1',
    //         'description' => 'sneaker 1',
    //     ]
    // ]);

    // $product = Product::query()->first();

    // // return $product->name;
    // return view('welcome', [
    //     'product' =>  $product,
    // ]);
});
