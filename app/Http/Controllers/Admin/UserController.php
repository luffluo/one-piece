<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.admin']);
    }

    public function index()
    {
        $lists = User::paginate(20);

        return admin_view('user.index', compact('lists'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return admin_view('user.update', compact('user'));
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->fill($request->except(['password']));

        if ($request->get('password')) {
            $user->setPassword($request->get('password'));
        }

        if (! $user->save()) {
            return redirect()->route('admin.users.edit', $user->id)->withErrors(['用户编辑失败!']);
        }

        return redirect()->route('admin.users.edit', $user->id)->withMessage('用户编辑成功!');
    }

    public function destroy($id)
    {

    }
}
