<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Carbon;
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
        $data  = [];

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
            ->paginate(option('page_size', 20));

        $data['posts'] = $posts;

        return view('posts.index', $data);
    }

    /**
     * 查看单个文章
     *
     * @param $id
     *
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
        $post->views_count += 1;
        $post->save();

        $comments = $post->getCommentsGroupByParentId();

        View::composer('layouts.app', function ($view) use ($post) {
            $view->with('keywords', '');
            $view->with('description', $post->description);
        });

        return view('posts.show', compact('post', 'comments'));
    }

    /**
     * 文章归档
     *
     * @param      $year
     * @param null $month
     * @param null $day
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function archive($year, $month = null, $day = null)
    {
        if (! empty($year) && ! empty($month) && ! empty($day)) {

            // 如果是按日期归档
            $searchDate = Carbon::create($year, $month, $day);
            $startDate  = clone $searchDate;
            $endDate    = clone $searchDate;
            $from       = $startDate->startOfDay();
            $to         = $endDate->endOfDay();

            $title = sprintf('%d年%d月%d日', $year, $month, $day);
        } elseif (! empty($year) && ! empty($month)) {

            // 如果按月归档
            $searchDate = Carbon::create($year, $month);
            $startDate  = clone $searchDate;
            $endDate    = clone $searchDate;
            $from       = $startDate->startOfMonth();
            $to         = $endDate->endOfMonth();

            $title = sprintf('%d年%d月', $year, $month);
        } elseif (! empty($year)) {

            // 如果按年归档
            $searchDate = Carbon::create($year);
            $startDate  = clone $searchDate;
            $endDate    = clone $searchDate;
            $from       = $startDate->startOfYear();
            $to         = $endDate->endOfYear();

            $title = sprintf('%d年', $year);
        }

        $posts = Post::where('created_at', '>=', $from)
            ->where('created_at', '<=', $to)
            ->published()
            ->recent()
            ->with('tags')
            ->paginate(option('page_size', 20));

        return view('posts.index', compact('posts', 'title'));
    }
}
