<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function handleRegister(RegisterRequest $request)
    {
        $user = new User($request->only(['name', 'email']));
        $user->setPassword($request->get('password'));

        if (! $user->save()) {
            return redirect()->route('register')->withInput()->withErrors(['name' => '注册失败，请稍后重试.']);
        }

        auth()->guard()->login($user, true);

        return redirect()->route('home');
    }
}
