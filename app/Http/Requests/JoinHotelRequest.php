<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JoinHotelRequest extends FormRequest
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
            "name"=>"required",
            "image_url"=>"required",
            "index"=>"required"
        ];
    }
    public function messages()
    {
        return [
            "name.required"=>"酒店名称必填",
            "image_url.required"=>"酒店logo必填",
            "index.required"=>"酒店首字母大写必填"
        ];
    }
}
