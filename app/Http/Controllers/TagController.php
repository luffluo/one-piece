<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::select('id', 'name', 'slug', 'count')
            ->hadPosts()
            ->with(['posts' => function ($query) {
                return $query->select('id', 'title');
            }])
            ->get();

        return view('tag.index', compact('tags'));
    }

    public function posts($slug)
    {
        $tag = Tag::where('slug', $slug)->first();

        if (null == $tag) {
            return abort(404);
        }

        $postIds = $tag ? $tag->posts()->get()->pluck('id')->all() : [];

        $posts = Post::query()
            ->whereIn('id', $postIds)
            ->published()
            ->recent()
            ->with('tags')
            ->paginate(option('pageSize', 20));

        return view('index', compact('posts', 'tag'));
    }
}
