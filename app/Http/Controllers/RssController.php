<?php

namespace App\Http\Controllers;

use App\Post;

class RssController extends Controller
{
    public function __invoke()
    {
        $view = cache()->remember('generated.feed', 7 * 24 * 60, function () {
            $posts = Post::query()
                ->select('id', 'user_id', 'title', 'text', 'created_at', 'updated_at')
                ->with('user')
                ->with('tags')
                ->get();

            return view('rss', compact('posts'))->render();
        });

        return response($view)->header('Content-Type', 'text/xml');
    }
}