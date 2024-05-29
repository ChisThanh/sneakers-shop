<?php

namespace App\Providers;

use App\Models\ShoppingCart;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        view()->composer('*',function($view)
        {
            $cart=new ShoppingCart();
            $view->with(compact('cart'));//tất cả các view trong resource sẽ nhận đc biến cart này
        });
    }
}
