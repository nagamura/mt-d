<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('ShopOrdersService', \App\Services\ShoppingMallOrdersService::class);
        $this->app->bind('NewsService', \App\Services\NewsService::class);
        $this->app->bind('SuppliersService', \App\Services\SuppliersService::class);
        $this->app->bind('UsersService', \App\Services\UsersService::class);
        $this->app->bind('StockService', \App\Services\StockService::class);
        $this->app->bind('MProductsService', \App\Services\M_ProductsService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
