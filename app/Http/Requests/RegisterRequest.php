<?php

namespace App\Http\Requests;

class RegisterRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'required|alpha_dash|unique:users,name',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'captcha'  => 'required|captcha',
        ];
    }

    public function messages()
    {
        return [
            'name.required'      => '请输入用户名',
            'name.alpha_dash'    => '用户名只能是字母、数字、破折号（ - ）以及下划线（ _ ）',
            'name.unique'        => '用户名已经存在',
            'email.required'     => '请输入邮箱',
            'email.email'        => '无效的邮箱',
            'email.unique'       => '邮箱已经存在',
            'password.required'  => '请输入密码',
            'password.min'       => '密码长度最小 6 位',
            'password.confirmed' => '两次密码不一致',
            'captcha.required'   => '请输入验证码',
            'captcha.captcha'    => '验证码不正确',
        ];
    }
}
