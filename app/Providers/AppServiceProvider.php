<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Nav;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Pagination\Paginator;
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

        $this->registerObservers();

        $this->registerViewData();

        Paginator::defaultView('vendor.pagination.default');
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
        Nav::observe(\App\Observers\NavObserver::class);
        Tag::observe(\App\Observers\TagObserver::class);
        Post::observe(\App\Observers\PostObserver::class);
        Comment::observe(\App\Observers\CommentObserver::class);
        \App\Models\Attachment::observe(\App\Observers\AttachmentObserver::class);
    }

    /**
     * 注册一些视图数据
     */
    protected function registerViewData()
    {
        View::composer('layouts.app', function ($view) {
            $view->with('keywords', setting('keywords', ''));
            $view->with('description', setting('description', ''));
        });

        View::composer('common._nav', function ($view) {
            $navigations = cache()->rememberForever('navigations', function () {
                return Nav::select('title', 'slug', 'text', 'order')
                    ->show()
                    ->orderAsc()
                    ->get();
            });

            $view->with('navigations', $navigations);
        });

        View::composer(['common._sidebar'], function ($view) {

            if (sidebar_block_open('show_recent_posts')) {

                $posts = cache()->rememberForever('post.recent', function () {
                    return Post::query()
                        ->select('id', 'title', 'created_at')
                        ->published()
                        ->recent()
                        ->take(setting('posts_list_size', 10))
                        ->get();
                });

                $view->with('sidebarRecentPosts', $posts);
            }

            if (sidebar_block_open('show_recent_comments')) {

                $comments = cache()->rememberForever('comment.recent', function () {
                    return Comment::query()
                        ->select('text', 'user_id')
                        ->with('user')
                        ->recent()
                        ->take(setting('comments_list_size', 10))
                        ->get();
                });

                $view->with('sidebarRecentComments', $comments);
            }

            if (sidebar_block_open('show_tag')) {

                $tags = cache()->rememberForever('tags.had_posts', function () {
                    return Tag::query()
                        ->select('id', 'name', 'slug', 'count')
                        ->hadPosts()
                        ->get();
                });

                $view->with('sidebarTags', $tags);
            }

            if (sidebar_block_open('show_archive')) {

                $result = cache()->rememberForever('post.archive', function () {
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
