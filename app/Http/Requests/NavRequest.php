<?php

namespace App\Http\Requests;

class NavRequest extends Request
{
    public function rules()
    {
        return [
            'title' => 'required',
            'text'  => 'required|url',
            'order' => 'nullable|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '请输入导航名称',
            'text.required'  => '请输入导航链接',
            'text.url'       => '请输入有效的链接',
            'order.integer'  => '请输入整数',
            'order.min'      => '导航顺序最小值为 1',
        ];
    }
}
