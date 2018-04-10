<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdate extends FormRequest
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
            'signin_name'=>"required|digits:11",
            'username'=>"required",
            'f_department_id'=>'required',
            'f_area_id'=>"required"
        ];
    }
    public function messages()
    {
        return [
            'signin_name.required'=>"用户名不能为空",
            'signin_name.digits'=>"用户名为员工11位手机号",
            'username.required'=>"员工姓名不能为空",
            'f_department_id.required'=>"所属部门不能为空",
            'f_area_id.required'=>"所属地区不能为空"
        ];
    }
}
