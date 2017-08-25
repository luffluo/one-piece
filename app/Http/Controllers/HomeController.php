<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::query()
            ->published()
            ->recent()
            ->with('tags')
            ->paginate(20);

        return view('index', compact('posts'));
    }
}
