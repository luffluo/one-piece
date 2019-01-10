<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Support\Facades\View;

class TagsController extends Controller
{
    public function index()
    {
        $tags = Tag::select('id', 'name', 'slug', 'count')
            ->hadPosts()
            ->with(['posts' => function ($query) {
                return $query->select('id', 'title');
            }])
            ->get();

        return view('tags.index', compact('tags'));
    }

    public function posts($slug)
    {
        $tag = Tag::where('slug', $slug)->first();

        if (null == $tag) {
            return abort(404);
        }

        $postIds = $tag ? $tag->posts()->get()->pluck('id')->all() : [];

        View::composer('layouts.app', function ($view) use ($tag) {
            $view->with('keywords', $tag->name);
            $view->with('description', $tag->description);
        });

        $posts = Post::query()
            ->whereIn('id', $postIds)
            ->published()
            ->recent()
            ->with('tags')
            ->paginate(setting('page_size', 20));

        return view('posts.index', compact('posts', 'tag'));
    }
}
