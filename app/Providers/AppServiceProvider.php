<?php

namespace App\Providers;

use App\Post;
use App\Listeners\MenuRouteMatched;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(resource_path('views/admin'), 'admin');

        $this->app['events']->subscribe(MenuRouteMatched::class);

        Post::setMarkdown($this->app->make('HyperDown'));
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
