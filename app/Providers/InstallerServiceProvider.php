<?php

namespace App\Providers;

use App\Installer;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\InstallController;

class InstallerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->app['installer']->isInstalled()) {

            $this->app['router']->group(['middleware' => 'web', 'prefix' => 'install'], function () {
                $this->app['router']->get('/', InstallController::class . '@showPage')->name('install');
                $this->app['router']->post('/', InstallController::class . '@handle');
            });
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('installer', function ($app) {
            return new Installer($app, $app['config']);
        });
    }
}
