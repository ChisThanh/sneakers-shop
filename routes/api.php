<?php

use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TranslateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/translatte-text', [TranslateController::class, 'translate'])->name('translate');

Route::post("/getHistory", [ChatController::class, 'getHistory'])->name("getHistory");

Route::group([
    'prefix' => 'product',
    'as' => 'product.'
], function () {
    Route::get('/', [ProductController::class, 'getPaginate'])->name('index');
    Route::get('/{id}', [ProductController::class, 'detail'])->name('detail');

    Route::post("/import-csv", [AdminProductController::class, 'importCSV'])->name("importCSV");
});
