<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
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
        $commentQuery = Comment::query();

        if (auth()->check() && auth()->user()->name === $name) {
            $user = auth()->user();
        } else {
            $user = User::query()
                ->where('name', $name)
                ->firstOrFail();

            $commentQuery->approved();
        }

        $comments = $commentQuery
            ->where('user_id', $user->id)
            ->with('post')
            ->recent()
            ->paginate(setting('comments_page_size', 20));

        return view('users.center', compact('user', 'comments'));
    }

    /**
     * 编辑用户资料
     *
     * @param $name
     */
    public function editProfile($name)
    {
        $user = auth()->user();

        if ($name !== $user->name) {
            return redirect()
                ->route('users.edit_profile', $user->name);
        }

        $this->authorize('update', $user);

        return view('users.profile', compact('user'));
    }

    /**
     * 处理编辑用户资料
     *
     * @param UserRequest $request
     * @param             $name
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $this->authorize('update', $user);

        $this->validate(
            $request,
            [
                'email'    => 'required|email|unique:users,email,' . $user->id,
                'nickname' => 'nullable|string|max:20',
                'profile'  => 'nullable|string|max:254',
            ],
            [
                'email.required' => '请输入邮箱',
                'email.email'    => '邮箱格式不正确',
                'email.unique'   => '邮箱已经存在',
                'nickname.max'   => '昵称最大 20 个字符',
                'profile.max'    => '个人简介最大 240 个字符',
            ]
        );

        $user->fill($request->all());
        if (! $user->save()) {
            return redirect()->route('users.edit_profile', $user->name)->withErrors('保存失败');
        }

        return redirect()->route('users.edit_profile', $user->name)->withMessage('信息编辑成功');
    }

    /**
     * 上传头像
     *
     * @param $name
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function editAvatar($name)
    {
        $user = auth()->user();

        if ($name !== $user->name) {
            return redirect()
                ->route('users.edit_avatar', $user->name);
        }

        $this->authorize('update', $user);

        return view('users.avatar', compact('user'));
    }

    public function updateAvatar(Request $request, ImageUploadHandler $uploader)
    {
        $user = auth()->user();

        $this->authorize('update', $user);

        $this->validate(
            $request,
            [
                'avatar' => 'required|image:' . $uploader->getAllowedExtsString(),
            ],
            [
                'avatar.required' => '请选择图片',
                'avatar.image'    => '图片格式 ' . $uploader->getAllowedExtsString(', '),
            ]
        );

        $result = $uploader->save($request->avatar, 'avatars', $user->id, 362);
        if (! $result) {
            return redirect()->route('users.edit_avatar', $user->name)->withErrors('头像上传失败');
        }

        // 原来的头像
        $oriAvatar = $user->avatar;

        $user->avatar = $result['path'];
        if (! $user->save()) {
            return redirect()->route('users.edit_avatar', $user->name)->withErrors('头像上传失败');
        }

        if (! empty($oriAvatar)) {
            // 删除原来的头像
            @unlink(public_path($oriAvatar));
        }

        return redirect()->route('users.edit_avatar', $user->name)->withMessage('上传成功');
    }

    /**
     * 修改密码
     *
     * @param $name
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function editPassword($name)
    {
        $user = auth()->user();

        if ($name !== $user->name) {
            return redirect()
                ->route('users.edit_password', $user->name);
        }

        $this->authorize('update', $user);

        return view('users.password', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $this->authorize('update', $user);

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
            return redirect()->route('users.edit_password', $user->name)->withErrors(['password' => '密码错误']);
        }

        $user->setPassword($request->input('new_password'));

        if (! $user->save()) {
            return redirect()->route('users.edit_password', $user->name)->withErrors('保存失败');
        }

        return redirect()->route('users.edit_password', $user->name)->withMessage('修改成功');
    }
}
