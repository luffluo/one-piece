<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Post;
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
            return redirect()->back()->withMessage('添加失败.');
        }

        return redirect()->route('admin.posts.index')->withMessage('添加成功.');
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
            return redirect()->back()->withErrors('更新失败.');
        }

        return redirect()->route('admin.posts.index')->withMessage('更新成功.');
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (! $post || ! $post->exists) {
            return redirect()->back()->withErrors('文章不存在.');
        }

        if (! $post->delete()) {
            return redirect()->back()->withErrors('文章删除失败.');
        }

        return redirect()->route('admin.posts.index')->withMessage('文章删除成功.');
    }
}
