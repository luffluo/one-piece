<?php

namespace App\Http\Controllers;

use App\Post;

class SiteMapController extends Controller
{
    public function __invoke()
    {
        $view = cache()->remember('generated.sitemap', 24 * 60, function () {
            $posts = Post::query()->select('id', 'updated_at')->get();

            return view('sitemap', compact('posts'))->render();
        });

        return response($view)->header('Content-Type', 'text/xml');
    }
}
