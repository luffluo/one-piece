<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
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
    public function editInfo($name)
    {
        $user = User::query()
            ->where('name', $name)
            ->firstOrFail();

        return view('user.update', compact('user'));
    }

    /**
     * 处理编辑用户资料
     *
     * @param UserRequest $request
     * @param             $name
     */
    public function updateInfo(UserRequest $request, $name)
    {

    }

    public function editPassword()
    {
        return view('user.password');
    }

    public function updatePassword()
    {

    }

    public function editAvatar()
    {
        return view('user.avatar');
    }

    public function updateAvatar()
    {
        
    }
}
