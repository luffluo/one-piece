<?php

namespace App\Http\Requests;

class InstallRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'          => 'required',
            'db_host'        => 'required',
            'db_database'    => 'required',
            'db_username'    => 'required',
            'db_password'    => 'required',
            'admin_username' => 'required',
            'admin_password' => 'required',
            'admin_email'    => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'title.required'          => '请填写网站名称',
            'db_host.required'        => '请填写服务器地址',
            'db_database.required'    => '请填写数据库',
            'db_username.required'    => '请填写数据库用户名',
            'db_password.required'    => '请填写数据库密码',
            'admin_username.required' => '请填写管理员账号',
            'admin_password.required' => '请填写管理员密码',
            'admin_email.required'    => '请填写管理员邮箱',
            'admin_email.email'       => '管理员邮箱格式不正确',
        ];
    }
}
