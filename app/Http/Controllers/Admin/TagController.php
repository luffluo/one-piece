<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Http\Requests\TagRequest;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.admin']);
    }

    public function index()
    {
        $lists = Tag::paginate(20);

        return admin_view('tag.index', compact('lists'));
    }

    public function create()
    {
        $tag = new Tag;

        return admin_view('tag.create', compact('tag'));
    }

    public function store(TagRequest $request)
    {
        $tag       = new Tag($request->except('slug'));
        $tag->slug = slug_name($request->get('slug') ? $request->get('slug') : $request->get('name'));


        if (! $tag->save()) {
            return redirect()->route('admin.tags.index')->withErrors("标签 {$tag->name} 添加失败");
        }

        return redirect()->route('admin.tags.index')->with('message', "标签 {$tag->name} 已经被添加");
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);

        return admin_view('tag.update', compact('tag'));
    }

    public function update(TagRequest $request, $id)
    {
        $tag = Tag::findOrFail($id);

        if (! $tag->update($request->all())) {
            return redirect()->route('admin.tags.index')->withErrors("标签 {$tag->name} 编辑失败");
        }

        return redirect()->route('admin.tags.index')->with('message', "标签 {$tag->name} 已经被更新");
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);

        if (! $tag->delete()) {
            return redirect()->route('admin.tags.index')->with('errors', "标签 {$tag->name} 删除失败");
        }

        return redirect()->route('admin.tags.index')->with('message', "标签 {$tag->name} 已经被删除");
    }

    public function getByName()
    {
        if (request()->ajax() || request()->wantsJson()) {
            $input = request()->get('q');

            if (empty($input)) {
                return response()->json([]);
            }

            $tags = Tag::select('id', 'name')->where('name', 'like', "%{$input}%")->get();

            if (count($tags) < 1) {
                return response()->json([]);
            }

            return response()->json(['items' => $tags->toArray()]);
        }
    }
}
