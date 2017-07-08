<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('id');

        $rules = [];

        if (empty($id)) {
            $rules['name'] = 'required|unique:users,name';
        }

        if ($id) {
            $rules['email'] = 'required|email|unique:users,email,' . $id;
        }

        if ($id) {
            $rules['password'] = 'nullable|confirmed';
        } else {
            $rules['password'] = 'required|confirmed';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'      => '请输入账号.',
            'name.unique'        => '账号已经存在.',
            'email.required'     => '请输入邮箱.',
            'email.email'        => '邮箱格式不正确.',
            'email.unique'       => '邮箱已经存在.',
            'password.required'  => '请输入密码.',
            'password.confirmed' => '两次密码不一致.',
        ];
    }
}
