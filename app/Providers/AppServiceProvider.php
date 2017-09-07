<?php

namespace App\Providers;

use App\Models\Tag;
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

        View::composer('components.sidebar', function ($view) {
            $sidebarBlock = json_decode(option('sidebarBlock', ''), true);
            $sidebarBlock = is_array($sidebarBlock) ? $sidebarBlock : [];
            $view->with('sidebarBlock', $sidebarBlock);

            if (in_array('ShowRecentPosts', $sidebarBlock)) {
                $posts = Post::query()->select('id', 'title', 'created_at')->recent()->take(5)->get();
                $view->with('sidebarRecentPosts', $posts);
            }

            if (in_array('ShowTag', $sidebarBlock)) {
                $tags = Tag::query()->select('id', 'name', 'slug', 'count')->take(5)->get();
                $view->with('sidebarTags', $tags);
            }
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
