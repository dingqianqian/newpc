<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomRequest extends FormRequest
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
            'hotel_name' => "required|max:255",
            'hotel_address' => "required",
            'area_name'=>"required|between:3,4",
            'phone_name'=>"required|between:7,8",
            'logo' => "nullable"
        ];
    }
    public function messages()
    {
        return [
            'hotel_name.required'=>"酒店名称不能为空",
            'hotel_address.required'=>"地址不能为空",
            'area_name.required'=>"区号不能为空",
            'phone_name.required'=>"固话不能为空",
        ];
    }
}
