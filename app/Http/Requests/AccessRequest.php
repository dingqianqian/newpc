<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccessRequest extends FormRequest
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
            'name'=>"required",
            'route_name'=>"required",
            'parent_id'=>"required"
        ];
    }
    /*
     *
     */
    public function messages()
    {
        return [
            'name.required'=>"权限名称不能为空",
            'route_name.required'=>"路由名称不能为空",
            'parent_id'=>"父级权限不能为空"
        ];
    }
}
