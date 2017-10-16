<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'center',
            ],
        ]);
    }

    /**
     * User center
     *
     * @return \Illuminate\Http\Response
     */
    public function center($name)
    {
        $user = User::query()
            ->with('comments.post')
            ->where('name', $name)
            ->firstOrFail();

        $comments = Comment::query()
            ->where('user_id', $user->id)
            ->with('post')
            ->recent()
            ->paginate(option('comments_page_size', 20));

        return view('user.center', compact('user', 'comments'));
    }

    /**
     * 编辑用户资料
     *
     * @param $name
     */
    public function editProfile($name)
    {
        $user = User::query()
            ->where('name', $name)
            ->firstOrFail();

        return view('user.profile', compact('user'));
    }

    /**
     * 处理编辑用户资料
     *
     * @param UserRequest $request
     * @param             $name
     */
    public function updateProfile(Request $request, $name)
    {
        $user = User::query()
            ->where('name', $name)
            ->firstOrFail();

        if ($user->id !== auth()->user()->id) {
            return redirect()->route('user.edit_profile', $user->name)->withErrors('非法操作');
        }

        $this->validate(
            $request,
            [
                'email'    => 'required|email|unique:users,email,' . $user->id,
                'nickname' => 'nullable|string|max:20',
            ],
            [
                'email.required' => '请输入邮箱',
                'email.email'    => '邮箱格式不正确',
                'email.unique'   => '邮箱已经存在',
                'nickname.max'   => '昵称最大 20 个字符',
            ]
        );

        $user->fill($request->all());

        if (! $user->save()) {
            return redirect()->route('user.edit_profile', $user->name)->withErrors('保存失败');
        }

        return redirect()->route('user.edit_profile', $user->name)->withMessage('信息编辑成功');
    }

    public function editAvatar($name)
    {
        $user = User::query()
            ->where('name', $name)
            ->firstOrFail();

        return view('user.avatar', compact('user'));
    }

    public function updateAvatar(Request $request, $name)
    {
        $user = User::query()
            ->where('name', $name)
            ->firstOrFail();

        if ($user->id !== auth()->user()->id) {
            return redirect()->route('user.edit_profile', $user->name)->withErrors('非法操作');
        }

        $this->validate(
            $request,
            [
                'avatar' => 'required|image:jpeg,jpg,png,gig',
            ],
            [
                'avatar.required' => '请选择图片',
                'avatar.image'    => '图片格式 jpeg, jpg, png, gif',
            ]
        );

        $avatar = $request->file('avatar');
        $fileName = $user->id . '_200x200.' . ($avatar->clientExtension() ?? 'jpg');
        $avatar->move(public_path('uploads/avatars'), $fileName);

        $user->avatar = $fileName;
        $user->save();

        return redirect()->route('user.edit_avatar', $user->name)->withMessage('上传成功');
    }

    public function editPassword($name)
    {
        $user = User::query()
            ->where('name', $name)
            ->firstOrFail();

        return view('user.password', compact('user'));
    }

    public function updatePassword(Request $request, $name)
    {
        $user = User::query()
            ->where('name', $name)
            ->firstOrFail();

        if ($user->id !== auth()->user()->id) {
            return redirect()->route('user.edit_profile', $user->name)->withErrors('非法操作');
        }

        $this->validate(
            $request,
            [
                'cur_password' => 'required',
                'new_password' => 'required|confirmed',
            ],
            [
                'cur_password.required'  => '请输入密码',
                'new_password.required'  => '请输入新密码',
                'new_password.confirmed' => '两次密码不一致',
            ]
        );

        if (! $user->checkPassword($request->input('cur_password'))) {
            return redirect()->route('user.edit_password', $user->name)->withErrors(['password' => '密码错误']);
        }

        $user->setPassword($request->input('new_password'));

        if (! $user->save()) {
            return redirect()->route('user.edit_password', $user->name)->withErrors('保存失败');
        }

        return redirect()->route('user.edit_password', $user->name)->withMessage('修改成功');
    }
}
