<?php

namespace App\Providers;

use App\Services\Option;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use App\Repositories\OptionFileRepository;
use App\Repositories\OptionDatabaseRepository;

class OptionServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * 应该被转换成原生类型的属性
     *
     * @var array
     */
    protected $casts = [
        'sidebar_block' => 'array',
        'comments_show' => 'array',
    ];

    public function register()
    {
        $this->app->singleton('option.repository.file', function ($app) {
            return new OptionFileRepository($app[Filesystem::class]);
        });

        $this->app->singleton('option.repository.database', function ($app) {
            return new OptionDatabaseRepository($app['db']->connection(), $app['cache']->store());
        });

        $this->app->singleton('option', function ($app) {
            return new Option(
                $app[OptionFileRepository::class],
                $app[OptionDatabaseRepository::class],
                $this->casts
            );
        });

        $this->app->alias('option.repository.file', OptionFileRepository::class);
        $this->app->alias('option.repository.database', OptionDatabaseRepository::class);
        $this->app->alias('option', Option::class);
    }

    public function provides()
    {
        return [
            'option',
            Option::class,
            'option.repository.file',
            OptionFileRepository::class,
            'option.repository.database',
            OptionDatabaseRepository::class,
        ];
    }
}
