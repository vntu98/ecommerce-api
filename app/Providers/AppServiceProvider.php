<?php

namespace App\Providers;

use App\Cart\Cart;
use App\Cart\Payments\Gateway;
use App\Cart\Payments\Gateways\StripeGateway;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(Cart::class, function ($app) {
            $user = $app->auth->user()->load([
                'cart.stock'
            ]) ?? User::query()->first();
            
            return new Cart($user);
        });

        $this->app->singleton(Gateway::class, function () {
            return new StripeGateway();
        });
    }
}
