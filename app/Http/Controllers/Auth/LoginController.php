<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function handleLogin(Request $request)
    {
        $this->validate(
            $request,
            [
                'name'     => 'required',
                'password' => 'required',
            ],
            [
                'name.required'     => '请输入账号.',
                'password.required' => '请输入密码.',
            ]
        );

        $user = User::query()->where('name', $request->name)->first();

        if (! $user || ! $user->exists || ! $user->checkPassword($request->password)) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['name' => '用户名或密码不正确.']);
        }

        $this->guard()->login($user, $request->has('remember'));

        return redirect()->intended(route('home'));
    }

    protected function guard($guard = null)
    {
        return Auth::guard($guard);
    }
}
