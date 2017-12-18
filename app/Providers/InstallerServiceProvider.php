<?php

namespace App\Providers;

use App\Services\Installer;
use App\Contracts\Detectable;
use App\Detections\Composite;
use App\Detections\PhpVersion;
use App\Detections\PhpExtension;
use App\Detections\WritablePath;
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
        if (! $this->app['installer']->installed()) {

            $this->app['router']->group(['middleware' => 'web', 'prefix' => 'install'], function () {

                $this->app['router']->get('/', InstallController::class . '@showInstall')->name('install');
                $this->app['router']->post('/', InstallController::class . '@handleInstall');
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

        $this->app->bind(Detectable::class, function () {
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
                    storage_path(),
                    base_path('bootstrap/cache')
                )
            );
        });
    }
}
