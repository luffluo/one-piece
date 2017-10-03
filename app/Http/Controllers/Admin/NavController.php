<?php

namespace App\Http\Controllers\Admin;

use App\Models\Nav;
use App\Http\Requests\NavRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class NavController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.admin']);
    }

    public function index()
    {
        $lists = Nav::query()
            ->orderAsc()
            ->get();

        return admin_view('nav.index', compact('lists'));
    }

    public function create()
    {
        $nav = new Nav;

        return admin_view('nav.create', compact('nav'));
    }

    public function store(NavRequest $request)
    {
        $nav = new Nav($request->all());

        DB::beginTransaction();

        if (! $nav->save()) {

            DB::rollBack();

            return redirect()->route('admin.navs.index')->withErrors("导航 {$nav->title} 添加失败");
        }

        DB::commit();

        cache()->forget('navigations');

        return redirect()->route('admin.navs.index')->with('message', "导航 {$nav->title} 已经被添加");
    }

    public function edit($id)
    {
        $nav = Nav::findOrFail($id);

        return admin_view('nav.update', compact('nav'));
    }

    public function update(NavRequest $request, $id)
    {
        $nav = Nav::findOrFail($id);

        $nav->fill($request->all());

        DB::beginTransaction();

        if (! $nav->save()) {

            DB::rollBack();

            return redirect()->route('admin.navs.index')->withErrors("导航 {$nav->title} 编辑失败");
        }

        DB::commit();

        cache()->forget('navigations');

        return redirect()->route('admin.navs.index')->with('message', "导航 {$nav->title} 已经被更新");
    }

    public function destroy($id)
    {
        $nav = Nav::findOrFail($id);

        DB::beginTransaction();

        if (! $nav->delete()) {

            DB::rollBack();

            return redirect()->route('admin.navs.index')->with('errors', "导航 {$nav->title} 删除失败");
        }

        DB::commit();

        cache()->forget('navigations');

        return redirect()->route('admin.navs.index')->with('message', "导航 {$nav->title} 已经被删除");
    }
}
