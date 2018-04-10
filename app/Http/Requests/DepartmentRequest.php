<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
            "f_area_id"=>"required"
        ];
    }
    public function messages()
    {
        return [
            "name.required" => "部门名称不能为空",
            "f_area_id.required" => "地区不能为空"
        ];
    }
}
