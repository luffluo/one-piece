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
        $posts = Post::with('tags')
            // ->published()
            ->recent()
            ->paginate(20);

        // dd($posts);

        return view('index', compact('posts'));
    }
}
