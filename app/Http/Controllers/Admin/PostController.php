<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        $lists = Post::paginate(30);

        return admin_view('post.index', compact('lists'));
    }

    public function create()
    {
        $post = new Post;

        return admin_view('post.create', compact('post'));
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'title'        => 'required',
                'text'         => 'required',
                'published_at' => 'nullable|date',
            ],
            [
                'title.required'    => '标题不能为空.',
                'text.required'     => '内容不能为空.',
                'published_at.date' => '发布时间格式不正确.',
            ]
        );
        // dd($request->all());
        $post = new Post(array_only($request->all(), ['title', 'text', 'published_at']));

        if (! $post->save()) {
            return redirect()->back()->withMessage('添加失败.');
        }

        return redirect()->route('admin.posts.index')->withMessage('添加成功.');
    }

    public function edit($id)
    {
        $post = Post::find($id);

        if (! $post || ! $post->exists) {
            return redirect()->back()->withErrors('文章不存在.');
        }

        return admin_view('post.update', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (! $post || ! $post->exists) {
            return redirect()->back()->withErrors('文章不存在.');
        }

        $this->validate(
            $request,
            [
                'title'        => 'required',
                'text'         => 'required',
                'published_at' => 'nullable|date',
            ],
            [
                'title.required'    => '标题不能为空.',
                'text.required'     => '内容不能为空.',
                'published_at.date' => '发布时间格式不正确.',
            ]
        );

        $post->fill(array_only($request->all(), ['title', 'text', 'published_at']));

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
