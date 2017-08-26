<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function show($id)
    {
        $post = Post::query()->where('id', $id)->published()->firstOrFail();
        $post->views_count += 1;
        $post->save();

        return view('post.show', compact('post'));
    }
}
