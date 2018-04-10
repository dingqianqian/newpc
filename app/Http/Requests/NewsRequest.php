<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            //
            'title'=>"required",
            'content'=>"required",
            'authour'=>"required",
            'type'=>"required",
            //'image_url'=>"required",
            "small_image_url"=>"required"
        ];
    }
    public function messages()
    {
        return [
            'title.required'=>"标题不能为空",
            'content.required'=>"内容不能为空",
            'authour.required'=>"作者不能为空",
            'type.required'=>"类型不能为空",
            'image_url.required'=>"PC大图不能为空",
            "small_image_url.required"=>"手机大图不能为空"
        ];
    }
}
