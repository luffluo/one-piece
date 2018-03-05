<?php

namespace App\Http\Requests;

class UserRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->route('user');

        if (! $user || ! $user->exists) {
            $rules = [
                'name'     => 'required|unique:users',
                'email'    => 'required|email|unique:users',
                'password' => 'required|confirmed',
            ];
        } else {
            $rules = [
                'name'     => 'required|unique:users,name,' . $user->id,
                'email'    => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|confirmed',
            ];
        }

        if (1 != $user->id) {
            $rules['group'] = 'required|in:administrator,visitor';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'      => '请输入账号',
            'name.unique'        => '账号已经存在',
            'email.required'     => '请输入邮箱',
            'email.email'        => '邮箱格式不正确',
            'email.unique'       => '邮箱已经存在',
            'password.required'  => '请输入密码',
            'password.confirmed' => '两次密码不一致',
            'group.required'     => '请选择用户组',
            'group.in'           => '无效的用户组',
        ];
    }
}
