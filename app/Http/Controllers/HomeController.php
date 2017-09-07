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
        /*$url = 'http://www.sina.com.cn/abc/de/fg.php?id=1';
        $str1 = parse_url($url);
        $str2 = pathinfo($url);

        dd($str1, $str2, request());*/

        $posts = Post::query()
            ->published()
            ->recent()
            ->with('tags')
            ->paginate(20);

        return view('index', compact('posts'));
    }
}
