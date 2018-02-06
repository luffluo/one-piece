<?php

namespace App\Http\Requests;

class TagRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|unique:metas,name',
            'slug' => 'sometimes|unique:metas,slug',
        ];

        $tag = $this->route('tag');
        if ($tag && $tag->exists) {
            $rules['name'] .= ",{$tag->id}";
            $rules['slug'] .= ",{$tag->id}";
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '请输入名称.',
            'name.unique'   => '标签名已存在.',
            'slug.unique'   => '标识已经存在.',
        ];
    }
}
