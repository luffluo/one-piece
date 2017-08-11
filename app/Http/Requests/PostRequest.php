<?php

namespace App\Http\Requests;

class PostRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // switch ($this->method()) {
        //     // CREATE
        //     case 'POST': {
        //         return [
        //             // CREATE ROLES
        //         ];
        //     }
        //
        //     // UPDATE
        //     case 'PUT':
        //     case 'PATCH': {
        //         return [
        //             // UPDATE ROLES
        //         ];
        //     }
        //
        //     case 'GET':
        //     case 'DELETE':
        //     default: {
        //         return [];
        //     };
        // }

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
