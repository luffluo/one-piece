<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;

class PostController extends Controller
{
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
            ->paginate(option('pageSize', 20));

        return view('index', compact('posts', 'title'));
    }

    public function show($id)
    {
        $post              = Post::query()->where('id', $id)->published()->firstOrFail();
        $post->views_count += 1;
        $post->save();

        return view('post.show', compact('post'));
    }
}
