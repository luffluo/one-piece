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
                $searches = array_map(function ($val) {
                    return strtolower($val);
                }, preg_split('/[\s]+/', $search));

                $query->where(function ($query) use ($searches) {
                    foreach ($searches as $search) {
                        $query->where('title', 'like', "%{$search}%");
                    }

                    return $query;
                })
                    ->orWhere(function ($query) use ($searches) {
                        foreach ($searches as $search) {
                            $query->where('text', 'like', "%{$search}%");
                        }

                        return $query;
                    });
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
