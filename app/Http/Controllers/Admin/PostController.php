<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        $lists = Post::query()
            ->with('tags')
            ->recent()
            ->paginate(30);

        return admin_view('post.index', compact('lists'));
    }

    public function create()
    {
        $post = new Post;
        $tags = Tag::query()->select('id', 'name')->get();


        return admin_view('post.create', compact('post', 'tags'));
    }

    public function store(PostRequest $request)
    {
        $post             = new Post(array_only($request->all(), ['title', 'text', 'published_at']));
        $post->do         = $request->get('do', null);
        $post->visibility = $request->get('visibility', null);

        if (! $post->save()) {
            return redirect()->back()->withMessage("文章 {$post->title} 创建失败");
        }

        $post->slug = $post->id;
        $post->save();

        return redirect()->route('admin.posts.index')->withMessage("文章 {$post->title} 已经被创建");
    }

    public function edit($id)
    {
        $post = Post::query()
            ->where('id', $id)
            ->with('tags')
            ->first();

        $tags = Tag::select('id', 'name')->get();

        if (! $post || ! $post->exists) {
            return redirect()->back()->withErrors('文章不存在.');
        }

        return admin_view('post.update', compact('post', 'tags'));
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);

        if (! $post || ! $post->exists) {
            return redirect()->back()->withErrors('文章不存在.');
        }

        $post->fill(array_only($request->all(), ['title', 'text', 'published_at']));
        $post->do         = $request->get('do', null);
        $post->visibility = $request->get('visibility', null);

        if (! $post->save()) {
            return redirect()->back()->withErrors("文章 {$post->title} 编辑失败");
        }

        return redirect()->route('admin.posts.index')->withMessage("文章 {$post->title} 已经被更新");
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (! $post || ! $post->exists) {
            return redirect()->back()->withErrors('文章不存在.');
        }

        if (! $post->delete()) {
            return redirect()->back()->withErrors("文章 {$post->title} 删除失败");
        }

        return redirect()->route('admin.posts.index')->withMessage("文章 {$post->title} 已经被删除");
    }
}
