<?php

namespace App\Providers;

use HyperDown\Parser;
use Illuminate\Support\ServiceProvider;

class HyperDownServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('HyperDown', function ($app) {
            return new Parser;
        });
    }
}
