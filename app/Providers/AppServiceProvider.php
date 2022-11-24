<?php

namespace App\Providers;

use App\Library\Services\Payments\MidtransService;
use App\Library\Services\Payments\PaypalService;
use Illuminate\Support\Facades\Schema;
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
        $this->app->bind(PaypalService::class, function () {
            return new PaypalService();
        });

        $this->app->bind(MidtransService::class, function () {
            return new MidtransService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
    }
}
