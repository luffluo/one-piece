<?php

namespace App\Providers;

use App\Services\Composite;
use App\Services\Installer;
use App\Services\PhpVersion;
use App\Services\PhpExtension;
use App\Services\WritablePath;
use App\Contracts\Prerequisite;
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

        $this->app->singleton(Prerequisite::class, function () {
            return new Composite(
                new PhpVersion('7.0.0'),
                new PhpExtension(
                    'fileinfo',
                    'gd',
                    'json',
                    'mbstring',
                    'openssl',
                    'pdo_mysql'
                ),
                new WritablePath(
                    public_path(),
                    storage_path()
                )
            );
        });
    }
}
