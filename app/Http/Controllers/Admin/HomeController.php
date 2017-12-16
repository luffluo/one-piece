<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Comment;
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

        $comments = Comment::query()
            ->select('text', 'created_at', 'user_id')
            ->with('user')
            ->take(10)
            ->get();

        return admin_view('home.index', compact('posts', 'posts_count', 'tags_count', 'comments'));
    }

    /**
     * 异步保持开关侧边导航
     */
    public function navTrigger()
    {
        if (request()->ajax()) {

            if (session('admin_nav_trigger')) {
                session(['admin_nav_trigger' => false]);
            } else {
                session(['admin_nav_trigger' => true]);
            }
        }
    }
}
