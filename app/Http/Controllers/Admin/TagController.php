<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Http\Requests\TagRequest;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
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
            return redirect()->route('admin.tags.index')->withErrors('添加失败！');
        }

        return redirect()->route('admin.tags.index')->with('message', '添加成功！');
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
            return redirect()->route('admin.tags.index')->withErrors('更新失败！');
        }

        return redirect()->route('admin.tags.index')->with('message', '更新成功！');
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);

        if (! $tag->delete()) {
            return redirect()->route('admin.tags.index')->with('errors', '删除失败！');
        }

        return redirect()->route('admin.tags.index')->with('message', '删除成功！');
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
