<?php
/**
 * Created by PhpStorm.
 * User: luojingying
 * Date: 17/2/14
 * Time: 下午9:56
 */

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Post;
use App\User;

class HomeController
{
    public function index()
    {
        $posts_count = Post::count();
        $posts       = Post::select('id', 'title', 'published_at')->recent()->take(7)->get();
        $tags_count  = Tag::count();
        $users_count = User::count();

        return admin_view('index', compact('posts', 'posts_count', 'tags_count', 'users_count'));
    }
}
