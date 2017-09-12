<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;

class PostController extends Controller
{
    public function archive($year, $month)
    {
        $searchDate = Carbon::create($year, $month);
        $startDate  = clone $searchDate;
        $endDate    = clone $searchDate;
        $title      = sprintf('%d年%d月', $year, $month);

        $posts = Post::where('created_at', '>', $startDate->startOfMonth())
            ->where('created_at', '<=', $endDate->endOfMonth())
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
