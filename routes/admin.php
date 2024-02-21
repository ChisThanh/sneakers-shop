<?php

use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Route::middleware(['admin', 'auth'])->prefix('admin')->name('admin.')->group(function () {
Route::middleware('web')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat');

    Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/create', [ProductController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });
});
