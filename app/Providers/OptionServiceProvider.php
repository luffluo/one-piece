<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\OptionDatabaseRepository;

class OptionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('option.repository', function ($app) {
            return new OptionDatabaseRepository($app['db']->connection());
        });
    }
}
