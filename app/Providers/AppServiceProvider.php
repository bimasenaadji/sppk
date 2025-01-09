<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\View;
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
        View::composer('index', function ($view) {
            $totalCustomers = Customer::count();
            $view->with('totalCustomers', $totalCustomers);
        });

        View::composer('index', function ($view) {
            $totalOrders = Order::count();
            $view->with('totalOrders', $totalOrders);
        });
        View::composer('index', function ($view) {
            $totalTransactions = Transaction::count();
            $view->with('totalTransactions', $totalTransactions);
        });
    }
}
