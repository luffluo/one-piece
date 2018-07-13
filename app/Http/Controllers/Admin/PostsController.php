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
            $query->whereHas('tags', function ($q) use ($tag) {
                $q->whereKey($tag);
            });
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

        $tags = Tag::all('id', 'name');

        return admin_view(
            'posts.index',
            compact('lists', 'status', 'draft_count', 'tag', 'keywords', 'tags')
        );
    }

    public function create(Post $post)
    {
        $post->allow_feed    = true;
        $post->allow_comment = true;

        $defaultTagId = option('defaultTag', 1);

        $tags                = Tag::query()
            ->select('id', 'name')
            ->get()
            ->map(function ($item) use ($defaultTagId) {
                return [
                    'name'     => $item['name'],
                    'value'    => $item['id'],
                    'selected' => $item['id'] == $defaultTagId ? true : false,
                ];
            })
            ->toArray();

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

        return redirect()->route('admin.posts.edit', [$post->id])->withMessage("文章 {$post->title} 已经被创建");
    }

    public function edit(Post $post)
    {
        if (! $post || ! $post->exists) {
            return back()->withErrors('文章不存在.');
        }

        $post->load([
            'tags:id,name',
            'attachments' => function ($query) {
                $query->select('id', 'parent_id', 'order')->orderBy('order');
            }
        ]);

        $selectedTagIds = $post->tags->pluck('id')->toArray();
        $tags           = Tag::all('id', 'name');
        $tags = $tags->map(function ($item) use ($selectedTagIds) {
            return [
                'name'     => $item['name'],
                'value'    => $item['id'],
                'selected' => in_array($item['id'], $selectedTagIds),
            ];
        })->toArray();

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

            return back()->withErrors("文章 {$post->title} 编辑失败");
        }

        DB::commit();

        return redirect()->route('admin.posts.edit', [$post->id])->withMessage("文章 {$post->title} 已经被更新");
    }

    public function destroy(Post $post)
    {
        DB::beginTransaction();

        if (! $post->delete()) {

            DB::rollBack();

            return back()->withErrors("文章 {$post->title} 删除失败");
        }

        DB::commit();

        return redirect()->route('admin.posts.index')->withMessage("文章 {$post->title} 已经被删除");
    }
}
