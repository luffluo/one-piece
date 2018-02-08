<?php

namespace App\Providers;

use Parsedown;
use App\Models\Nav;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * 数据缓存时间
     *
     * @var int
     */
    protected $cacheTime = 360 * 24 * 60;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('zh');

        $this->loadViewsFrom(resource_path('views/admin'), 'admin');

        Post::setMarkdown(Parsedown::instance());
        Comment::setMarkdown(Parsedown::instance());

        $this->registerObservers();

        $this->registerViewData();
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

    protected function registerObservers()
    {
        Post::observe(\App\Observers\PostObserver::class);
        \App\Models\Comment::observe(\App\Observers\CommentObserver::class);
        Nav::observe(\App\Observers\NavObserver::class);
        Tag::observe(\App\Observers\TagObserver::class);
    }

    /**
     * 注册一些视图数据
     */
    protected function registerViewData()
    {
        View::composer('common._nav', function ($view) {
            $navigations = cache()->remember('navigations', $this->cacheTime, function () {
                return Nav::select('title', 'slug', 'text', 'order')
                    ->show()
                    ->orderAsc()
                    ->get();
            });

            $view->with('navigations', $navigations);
        });

        View::composer(['common._sidebar'], function ($view) {

            if (sidebar_block_open('show_recent_posts')) {

                $posts = cache()->remember('post.recent', $this->cacheTime, function () {
                    return Post::query()
                        ->select('id', 'title', 'created_at')
                        ->published()
                        ->recent()
                        ->take(option('posts_list_size', 10))
                        ->get();
                });

                $view->with('sidebarRecentPosts', $posts);
            }

            if (sidebar_block_open('show_recent_comments')) {

                $comments = cache()->remember('comment.recent', $this->cacheTime, function () {
                    return Comment::query()
                        ->select('text', 'user_id')
                        ->with('user')
                        ->recent()
                        ->take(option('comments_list_size', 10))
                        ->get();
                });

                $view->with('sidebarRecentComments', $comments);
            }

            if (sidebar_block_open('show_tag')) {

                $tags = cache()->remember('tags.had_posts', $this->cacheTime, function () {
                    return Tag::query()
                        ->select('id', 'name', 'slug', 'count')
                        ->hadPosts()
                        ->get();
                });

                $view->with('sidebarTags', $tags);
            }

            if (sidebar_block_open('show_archive')) {

                $result = cache()->remember('post.archive', $this->cacheTime, function () {
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
}
