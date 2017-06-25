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
        $lists = Post::with('tags')
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return admin_view('post.index', compact('lists'));
    }

    public function create()
    {
        $post = new Post;
        $tags = Tag::select('id', 'name')->get();


        return admin_view('post.create', compact('post', 'tags'));
    }

    public function store(PostRequest $request)
    {
        $post = new Post(array_only($request->all(), ['title', 'text', 'published_at']));

        if (! $post->save()) {
            return redirect()->back()->withMessage('添加失败.');
        }

        $tags = Tag::select('id', 'count')
            ->whereIn('id', array_unique(array_map('trim', $request->get('tags', []))))
            ->get();

        $post->tags()->sync($tags->pluck('id'));

        foreach ($tags as $tag) {
            $tag->count += 1;
            $tag->save();
        }

        return redirect()->route('admin.posts.index')->withMessage('添加成功.');
    }

    public function edit($id)
    {
        $post = Post::where('id', $id)
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

        if (! $post->save()) {
            return redirect()->back()->withErrors('更新失败.');
        }

        $existsTags = $post->tags()->get();

        $tags = Tag::select('id', 'count')
            ->whereIn('id', array_unique(array_map('trim', $request->get('tags', []))))
            ->get();

        foreach ($existsTags as $existsTag) {
            if ($tags->where('id', $existsTag->id)->isEmpty() && $existsTag->count > 0) {
                $existsTag->count += -1;
                $existsTag->save();
            }
        }

        $post->tags()->sync($tags->pluck('id'));

        foreach ($tags as $tag) {
            $tag->count += 1;
            $tag->save();
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
