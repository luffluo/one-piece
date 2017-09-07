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

        $query = Post::query();

        if ($keywords = request()->get('keywords')) {
            $query->where(function ($query) use ($keywords) {
                $query->where('title', 'like', "%{$keywords}%")
                    ->orWhere('text', 'like', "%{$keywords}%");
            });
        }

        $posts = $query
            ->published()
            ->recent()
            ->with('tags')
            ->paginate(option('pageSize', 20));

        return view('index', compact('posts', 'keywords'));
    }
}
