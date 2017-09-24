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
        $query = Post::query();

        if ($search = request()->get('q')) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('text', 'like', "%{$search}%");
            });
        }

        $posts = $query
            ->published()
            ->recent()
            ->with('tags')
            ->paginate(option('page_size', 20));

        return view('index', compact('posts', 'search'));
    }
}
