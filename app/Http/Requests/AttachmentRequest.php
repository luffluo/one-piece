<?php

namespace App\Http\Requests;

class AttachmentRequest extends Request
{
    public function rules()
    {
        return [
            'title' => 'required|max:100',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '必须填写文件标题',
        ];
    }
}
