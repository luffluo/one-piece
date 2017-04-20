<?php

namespace App\Http\Requests;

class PostRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'        => 'required',
            'text'         => 'required',
            'published_at' => 'nullable|date',
        ];
    }

    public function messages()
    {
        return [
            'title.required'    => '标题不能为空.',
            'text.required'     => '内容不能为空.',
            'published_at.date' => '发布时间格式不正确.',
        ];
    }
}
