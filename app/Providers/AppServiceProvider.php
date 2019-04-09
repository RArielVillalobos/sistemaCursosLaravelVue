<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Cashier\Cashier;
use Stripe\Stripe;




class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //Cashier::useCurrency('eur', '€');
        Schema::defaultStringLength(191);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //


    }
}
