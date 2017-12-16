<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.admin']);
    }

    public function index(Request $request)
    {
        $query = Post::query();

        if ($tag = $request->get('tag')) {
            $tagModel = Tag::where('id', $tag)
                ->with('posts')
                ->first();
            $post_ids = $tagModel->posts->pluck('id')->all();

            $query->whereIn('id', $post_ids);
        }

        if ($keywords = $request->get('keywords')) {
            $query->where('title', 'like', "%{$keywords}%");
        }

        $cloneQuery = clone $query;

        if ($status = $request->get('status')) {
            if ('draft' == $status) {
                $query->draft();
            }
        }

        $draft_count = $cloneQuery->draft()->count();

        $lists = $query->postAndDraft()
            ->with('tags')
            ->recent()
            ->paginate(20);

        $tags = Tag::select('id', 'name')->get();

        return admin_view(
            'posts.index',
            compact('lists', 'status', 'draft_count', 'tag', 'keywords', 'tags')
        );
    }

    public function create(Post $post)
    {
        $post->allow_feed    = true;
        $post->allow_comment = true;
        $tags                = Tag::query()->select('id', 'name')->get();


        return admin_view('posts.create_and_edit', compact('post', 'tags'));
    }

    public function store(PostRequest $request, Post $post)
    {
        $post->fill($request->all());
        $post->do            = $request->get('do', null);
        $post->postTags      = $request->get('tags', []);
        $post->allow_feed    = $request->has('allow_feed');
        $post->allow_comment = $request->has('allow_comment');

        DB::beginTransaction();

        if (! $post->save()) {
            DB::rollBack();

            return redirect()->back()->withMessage("文章 {$post->title} 创建失败");
        }

        DB::commit();

        return redirect()->route('admin.posts.index')->withMessage("文章 {$post->title} 已经被创建");
    }

    public function edit(Post $post)
    {
        $tags = Tag::select('id', 'name')->get();

        if (! $post || ! $post->exists) {
            return redirect()->back()->withErrors('文章不存在.');
        }

        return admin_view('posts.create_and_edit', compact('post', 'tags'));
    }

    public function update(PostRequest $request, Post $post)
    {
        $post->fill($request->all());
        $post->do            = $request->get('do', null);
        $post->postTags      = $request->get('tags', []);
        $post->allow_feed    = $request->has('allow_feed');
        $post->allow_comment = $request->has('allow_comment');

        DB::beginTransaction();

        if (! $post->save()) {

            DB::rollBack();

            return redirect()->back()->withErrors("文章 {$post->title} 编辑失败");
        }

        DB::commit();

        return redirect()->route('admin.posts.index')->withMessage("文章 {$post->title} 已经被更新");
    }

    public function destroy(Post $post)
    {
        DB::beginTransaction();

        if (! $post->delete()) {

            DB::rollBack();

            return redirect()->back()->withErrors("文章 {$post->title} 删除失败");
        }

        DB::commit();

        return redirect()->route('admin.posts.index')->withMessage("文章 {$post->title} 已经被删除");
    }
}
