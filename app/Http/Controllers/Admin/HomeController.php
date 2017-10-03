<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.admin']);
    }

    public function index()
    {
        $posts_count = Post::count();
        $posts       = Post::query()->select('id', 'title', 'created_at')
            ->postAndDraft()
            ->recent()
            ->take(10)
            ->get();
        $tags_count  = Tag::count();

        return admin_view('index', compact('posts', 'posts_count', 'tags_count'));
    }

    public function navTrigger()
    {
        if (request()->ajax()) {

            if (session('nav.trigger', false)) {
                session(['nav.trigger' => false]);
            } else {
                session(['nav.trigger' => true]);
            }
        }
    }
}
