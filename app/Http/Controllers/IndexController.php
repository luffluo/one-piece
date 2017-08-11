<?php

namespace App\Http\Controllers;

use App\Post;

class IndexController extends Controller
{
    public function index()
    {
        $posts = Post::with('tags')
            ->published()
            ->recent()
            ->paginate(20);

        return view('index', compact('posts'));
    }
}
