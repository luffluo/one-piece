<?php

namespace App\Http\Controllers;

use App\Models\Post;
use HyperDown\Parser;

class IndexController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(20);
        $parser = new Parser;

        return view('index', compact('posts', 'parser'));
    }
}
