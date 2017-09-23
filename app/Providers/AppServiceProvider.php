<?php

namespace App\Providers;

use Parsedown;
use Carbon\Carbon;
use App\Models\Tag;
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

        View::composer(['index', 'tag.index', 'post.show', 'common.sidebar'], function ($view) {

            $sidebarBlock = sidebar_block();

            if (in_array('ShowRecentPosts', $sidebarBlock)) {
                $posts = Post::query()
                    ->select('id', 'title', 'created_at')
                    ->recent()
                    ->take(option('postsListSize', 10))
                    ->get();

                $view->with('sidebarRecentPosts', $posts);
            }

            if (in_array('ShowTag', $sidebarBlock)) {
                $tags = Tag::query()
                    ->select('id', 'name', 'slug')
                    ->hadPosts()
                    ->get();

                $view->with('sidebarTags', $tags);
            }

            if (in_array('ShowArchive', $sidebarBlock)) {

                $result = cache()->remember('post.archive', 7 * 24 * 60, function () {
                    $posts = Post::select('created_at')->published()
                        ->recent()
                        ->get();

                    $result = [];
                    foreach ($posts as $post) {
                        $date   = $post->created_at->format('F Y');

                        if (isset($result[$date])) {
                            $result[$date]['count']++;
                        } else {
                            $result[$date]['year']  = $post->created_at->format('Y');
                            $result[$date]['month'] = $post->created_at->format('m');
                            $result[$date]['day']   = $post->created_at->format('d');
                            $result[$date]['date']  = $date;
                            $result[$date]['count'] = 1;
                        }
                    }

                    return $result;
                });


                $view->with('sidebarArchives', $result);
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
