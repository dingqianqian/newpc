<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelRequest extends FormRequest
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
            //'logo'=>"required",
            "name"=>"required",
            "index"=>"required",
            "sort"=>"required",
            "is_show"=>"required"
        ];
    }
    public function messages()
    {
        return [
            //"logo.required"=>"请上传酒店logo",
            "name.required"=>"请填写酒店名称",
            "index.required"=>"请填写酒店缩写",
            "sort.required"=>"请填写酒店排序",
            "is_show.required"=>"请确认酒店是否显示"
        ];
    }
}
