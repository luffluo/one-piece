<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.admin']);
    }

    public function index()
    {
        $lists = Tag::query()
            ->paginate(20);

        $defaultTag = option('defaultTag', 1);

        return admin_view('tags.index', compact('lists', 'defaultTag'));
    }

    public function create(Tag $tag)
    {
        return admin_view('tags.create_and_edit', compact('tag'));
    }

    public function store(TagRequest $request, Tag $tag)
    {
        $tag->fill($request->all());

        if (! $tag->save()) {
            return redirect()
                ->route('admin.tags.index')
                ->withErrors("标签 {$tag->name} 添加失败");
        }

        return redirect()
            ->route('admin.tags.index')
            ->with('message', "标签 {$tag->name} 已经被添加");
    }

    public function edit(Tag $tag)
    {
        return admin_view('tags.create_and_edit', compact('tag'));
    }

    public function update(TagRequest $request, Tag $tag)
    {
        if (! $tag->update($request->all())) {

            return redirect()
                ->route('admin.tags.index')
                ->withErrors("标签 {$tag->name} 编辑失败");
        }

        return redirect()
            ->route('admin.tags.index')
            ->with('message', "标签 {$tag->name} 已经被更新");
    }

    public function setDefault(Request $request, Tag $tag)
    {
        try {
            option(['defaultTag' => $tag->id]);

            $returnUrl = $request->headers->get('referer');
            if (empty($returnUrl)) {
                $returnUrl = route('admin.tags.index');
            }

            return redirect()->to($returnUrl)
                ->withSuccess("{$tag->name} 已经被设为默认标签");

        } catch (\Exception $e) {
            return redirect()->back()->withErrors('设置默认标签失败，请重试.');
        }
    }

    public function destroy(Tag $tag)
    {
        if (! $tag->delete()) {
            return redirect()
                ->route('admin.tags.index')
                ->with('errors', "标签 {$tag->name} 删除失败");
        }

        return redirect()
            ->route('admin.tags.index')
            ->with('message', "标签 {$tag->name} 已经被删除");
    }
}
