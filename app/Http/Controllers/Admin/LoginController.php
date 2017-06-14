<?php
/**
 * Created by PhpStorm.
 * User: luojingying
 * Date: 17/6/6
 * Time: 下午7:03
 */

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return admin_view('auth.login');
    }

    public function handleLogin(Request $request)
    {
        $this->validate(
            $request,
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'username.required' => '请输入账号.',
                'password.required' => '请输入密码.'
            ]
        );

        $user = User::where('username', $request->username)->first();

        if (! $user || ! $user->exists || ! $user->checkPassword($request->password)) {
            return redirect()->back()->withErrors(['username' => '用户名或密码不正确.'])->withInput();
        }

        $this->guard()->login($user);

        return redirect()->intended(route('admin.home'));
    }

    protected function guard($guard = null)
    {
        return Auth::guard($guard);
    }
}
