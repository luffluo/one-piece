<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use Illuminate\Support\Facades\View;

class PostsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Post::query();
        $data = [];

        if ($search = request()->get('q')) {

            $query->where(function ($query) use ($search) {
                $searches = array_map(function ($val) {
                    return strtolower($val);
                }, preg_split('/[\s]+/', $search));

                $query->where(function ($query) use ($searches) {
                    foreach ($searches as $search) {
                        $query->where('title', 'like', "%{$search}%");
                    }

                    return $query;
                })
                    ->orWhere(function ($query) use ($searches) {
                        foreach ($searches as $search) {
                            $query->where('text', 'like', "%{$search}%");
                        }

                        return $query;
                    });
            });

            $data['search'] = $search;

            View::composer('layouts.app', function ($view) use ($search) {
                $view->with('keywords', $search);
            });
        }

        $posts = $query
            ->published()
            ->recent()
            ->with('tags', 'user')
            ->paginate(setting('page_size', 20));

        $data['posts'] = $posts;

        return view('posts.index', $data);
    }

    /**
     * 查看单个文章
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        /* @var Post $post */
        $post = Post::query()
            ->where('id', $id)
            ->published()
            ->firstOrFail();

        $post->load('user', 'comments.user');

        // 每次浏览，浏览数 +1
        if (! session('post_viewed_' . $post->id)) {
            $post->views_count += 1;
            $post->save();

            session(['post_viewed_' . $post->id => true]);
        }

        $comments = $post->getCommentsGroupByParentId();

        View::composer('layouts.app', function ($view) use ($post) {
            $view->with('keywords', '');
            $view->with('description', $post->description);
        });

        $prevPostId = Post::query()
                ->where('id', '<', $post->id)
                ->published()
                ->max('id') ?? null;

        $nextPostId = Post::query()
                ->where('id', '>', $post->id)
                ->published()
                ->min('id') ?? null;

        return view('posts.show', compact('post', 'comments', 'prevPostId', 'nextPostId'));
    }

    /**
     * 文章归档
     *
     * @param      $year
     * @param null $month
     * @param null $day
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function archive($year, $month = null, $day = null)
    {
        if (! empty($year) && ! empty($month) && ! empty($day)) {

            // 如果是按日期归档
            $searchDate = Carbon::create($year, $month, $day);
            $startDate = $searchDate->copy();
            $endDate = $searchDate->copy();
            $from = $startDate->startOfDay();
            $to = $endDate->endOfDay();

            $title = sprintf('%d年%d月%d日', $year, $month, $day);
        } elseif (! empty($year) && ! empty($month)) {

            // 如果按月归档
            $searchDate = Carbon::create($year, $month);
            $startDate = $searchDate->copy();
            $endDate = $searchDate->copy();
            $from = $startDate->startOfMonth();
            $to = $endDate->endOfMonth();

            $title = sprintf('%d年%d月', $year, $month);
        } elseif (! empty($year)) {

            // 如果按年归档
            $searchDate = Carbon::create($year);
            $startDate = $searchDate->copy();
            $endDate = $searchDate->copy();
            $from = $startDate->startOfYear();
            $to = $endDate->endOfYear();

            $title = sprintf('%d年', $year);
        }

        $posts = Post::where('created_at', '>=', $from)
            ->where('created_at', '<=', $to)
            ->published()
            ->recent()
            ->with('tags')
            ->paginate(setting('page_size', 20));

        return view('posts.index', compact('posts', 'title'));
    }
}
