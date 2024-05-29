<?php

use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Home\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\TranslateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/translate-text', [TranslateController::class, 'translate'])->name('translate');

Route::post("/getHistory", [ChatController::class, 'getHistory'])->name("getHistory");

Route::group([
    'prefix' => 'product',
    'as' => 'product.'
], function () {
    Route::get('/', [ProductController::class, 'getPaginate'])->name('index');
    Route::get('/{id}', [ProductController::class, 'detail'])->name('detail');
    Route::post("/import-csv", [AdminProductController::class, 'importCSV'])->name("importCSV");
});

Route::group([
    'prefix' => 'cart',
    'as' => 'cart.'
], function () {
    Route::get('/', [CartController::class, 'getPaginate'])->name('index');
    Route::get('/cart-detail/{id}', [CartController::class, 'getCartDetail'])->name('getCartDetail');
});


Route::group([
    'prefix' => 'brand',
    'as' => 'brand.'
], function () {
    Route::get('/', [BrandController::class, 'getPaginate'])->name('index');
});

Route::group([
    'prefix' => 'category',
    'as' => 'category.'
], function () {
    Route::get('/', [CategoryController::class, 'getPaginate'])->name('index');
});

Route::group([
    'prefix' => 'user',
    'as' => 'user.'
], function () {
    Route::get('/', [UserController::class, 'getPaginate'])->name('index');
});

Route::group([
    'prefix' => 'user',
    'as' => 'user.'
], function () {
    Route::get('/', [UserController::class, 'getPaginate'])->name('index');
});

Route::group([
    'prefix' => 'setting',
    'as' => 'setting.'
], function () {
    Route::get('/', [SettingController::class, 'index'])->name('index');
    Route::post('/change', [SettingController::class, 'change'])->name('change');
});