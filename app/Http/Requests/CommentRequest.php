<?php

namespace App\Http\Requests;

class CommentRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'text'      => 'required',
            'parent_id' => 'nullable|exists:comments,id',
        ];
    }

    public function messages()
    {
        return [
            'text.required'    => '请输入内容',
            'parent_id.exists' => '父评论不存在',
        ];
    }
}
