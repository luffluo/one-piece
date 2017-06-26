<?php

namespace App\Http\Controllers;

use App\Models\Post;

class IndexController extends Controller
{
    public function index()
    {
        $posts = Post::with('tags')->paginate(20);

        return view('index', compact('posts'));
    }
}
