<?php

namespace App\Providers;

use Carbon\Carbon;
use Parsedown;
use App\Models\Post;
use App\Listeners\MenuRouteMatched;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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
        Carbon::setLocale('zh');

        $this->loadViewsFrom(resource_path('views/admin'), 'admin');

        $this->app['events']->subscribe(MenuRouteMatched::class);

        Post::setMarkdown(Parsedown::instance());

        View::composer('admin*', function ($view) {
            $view->with('user', Auth::user());
            $view->with('navTrigger', session('nav.trigger', false));
        });
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
