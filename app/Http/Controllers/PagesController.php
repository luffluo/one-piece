<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PagesController extends Controller
{
    public function rss()
    {
        $view = cache()->remember('post.feed', 7 * 24 * 60, function () {
            $posts = Post::query()
                ->select('id', 'user_id', 'title', 'text', 'created_at', 'updated_at')
                ->with('user')
                ->with('tags')
                ->published()
                ->allowFeed()
                ->recent()
                ->get();

            return view('pages.rss', compact('posts'))->render();
        });

        return response($view)->header('Content-Type', 'text/xml');
    }

    public function siteMap()
    {
        $view = cache()->remember('sitemap', 7 * 24 * 60, function () {
            $posts = Post::query()
                ->select('id', 'updated_at')
                ->published()
                ->recent()
                ->get();

            return view('pages.sitemap', compact('posts'))->render();
        });

        return response($view)->header('Content-Type', 'text/xml');
    }
}
