<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        $query = Post::query();

        if ($tag = request()->get('tag')) {
            $tagModel = Tag::where('id', $tag)
                ->with('posts')
                ->first();
            $post_ids = $tagModel->posts->pluck('id')->all();

            $query->whereIn('id', $post_ids);
        }

        if ($keywords = request()->get('keywords')) {
            $query->where('title', 'like', "%{$keywords}%");
        }

        $cloneQuery = clone $query;

        if ($status = request()->get('status')) {
            if ('draft' == $status) {
                $query->draft();
            }
        }

        $draft_count = $cloneQuery->draft()->count();

        $lists = $query->with('tags')
            ->recent()
            ->paginate(20);

        $tags = Tag::select('id', 'name')->get();

        return admin_view(
            'post.index',
            compact('lists', 'status', 'draft_count', 'tag', 'keywords', 'tags')
        );
    }

    public function create()
    {
        $post             = new Post;
        $post->allow_feed = true;
        $tags             = Tag::query()->select('id', 'name')->get();


        return admin_view('post.create', compact('post', 'tags'));
    }

    public function store(PostRequest $request)
    {
        DB::beginTransaction();

        $post           = new Post($request->all());
        $post->do       = $request->get('do', null);
        $post->postTags = $request->get('tags', []);

        if (! $post->save()) {
            DB::rollBack();

            return redirect()->back()->withMessage("文章 {$post->title} 创建失败");
        }

        DB::commit();

        return redirect()->route('admin.posts.index')->withMessage("文章 {$post->title} 已经被创建");
    }

    public function edit($id)
    {
        $post = Post::find($id);

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

        DB::beginTransaction();

        $post->fill($request->all());
        $post->do         = $request->get('do', null);
        $post->allow_feed = $request->has('allow_feed');
        $post->postTags   = $request->get('tags', []);

        if (! $post->save()) {

            DB::rollBack();

            return redirect()->back()->withErrors("文章 {$post->title} 编辑失败");
        }

        DB::commit();

        cache()->forget('posts.feed');

        return redirect()->route('admin.posts.index')->withMessage("文章 {$post->title} 已经被更新");
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (! $post || ! $post->exists) {
            return redirect()->back()->withErrors('文章不存在.');
        }

        DB::beginTransaction();

        if (! $post->delete()) {

            DB::rollBack();

            return redirect()->back()->withErrors("文章 {$post->title} 删除失败");
        }

        DB::commit();

        return redirect()->route('admin.posts.index')->withMessage("文章 {$post->title} 已经被删除");
    }
}
