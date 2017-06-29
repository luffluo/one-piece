<?php

namespace App\Http\Controllers;

use App\Post;

class IndexController extends Controller
{
    public function index()
    {
        $posts = Post::with('tags')->paginate(20);

        // $posts = $posts->map(function ($item, $key) {
        //     $item->simple_text = preg_replace('/^```(\r\n.\r\n)*```$/i', '{代码...}', $item->text);
        //
        //     return $item;
        // });
        //
        // dd($posts);

        return view('index', compact('posts'));
    }
}
