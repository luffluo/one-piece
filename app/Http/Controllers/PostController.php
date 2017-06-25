<?php

namespace App\Http\Controllers;

use App\Models\Post;
use HyperDown\Parser;
use Illuminate\Database\Eloquent\Model;

class PostController extends Controller
{
    public function show($id)
    {
        /* @var Model */
        $post   = Post::findOrFail($id);
        // $post->views_count += 1;
        // $post->save();

        $parser = new Parser;

        return view('post.show', compact('post', 'parser'));
    }
}