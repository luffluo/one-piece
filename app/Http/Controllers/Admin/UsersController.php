<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.admin']);
    }

    public function index()
    {
        $lists = User::paginate(20);

        return admin_view('users.index', compact('lists'));
    }

    public function edit(User $user)
    {
        return admin_view('users.create_and_edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $user->fill($request->except(['password']));

        if ($request->input('password')) {
            $user->setPassword($request->input('password'));
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
