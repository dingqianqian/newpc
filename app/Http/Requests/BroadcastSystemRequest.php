<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BroadcastSystemRequest extends FormRequest
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
        return [
            "title"=>"required",
            "commit"=>"required",
            "img"=>"required"
        ];
    }
    public function messages()
    {
        return [
            "title.required"=>"请输入广播标题",
            "commit.required"=>"请输入广播内容",
            "img.required"=>"请输入图片链接"
        ];
    }
}
