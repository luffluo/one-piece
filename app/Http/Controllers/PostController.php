<?php

namespace App\Http\Controllers;

use App\Models\Post;
use HyperDown\Parser;

class PostController extends Controller
{
    public function show($id)
    {
        $post   = Post::findOrFail($id);
        $parser = new Parser;

        return view('post.show', compact('post', 'parser'));
    }
}
