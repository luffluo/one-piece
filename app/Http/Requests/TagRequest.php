<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'unique:metas,name'],
            'slug' => 'sometimes|unique:metas,slug',
        ];

        if ($this->route('id')) {
            $rules['name'] .= ",{$this->route('id')}";
            $rules['slug'] .= ",{$this->route('id')}";
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
