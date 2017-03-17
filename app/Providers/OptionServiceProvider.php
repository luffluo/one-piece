<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-03-17 16:50
 */

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
