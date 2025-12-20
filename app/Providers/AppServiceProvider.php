<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Order;

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
        // Share pending payments count with admin layout
        View::composer('layouts.admin', function ($view) {
            $pendingPaymentsCount = Order::whereNotNull('payment_proof')
                ->where('payment_status', 'awaiting_verification')
                ->count();
            $view->with('pendingPaymentsCount', $pendingPaymentsCount);
        });
    }
}
