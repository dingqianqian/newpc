<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'signin_name'=>"required|digits:11|unique:employee,signin_name",
            'pwd'=>"required|confirmed",
            'username'=>"required",
            'f_department_id'=>'required',
            'f_area_id'=>"required"
        ];
    }
    public function messages()
    {
        return [
            'signin_name.required'=>"用户名不能为空",
            'signin_name.unique'=>"用户名已经存在",
            'signin_name.digits'=>"用户名为员工11位手机号",
            'pwd.required'=>"密码不能为空",
            'pwd.confirmed'=>"两次输入的密码不一致",
            'username.required'=>"员工姓名不能为空",
            'f_department_id.required'=>"所属部门不能为空",
            'f_area_id.required'=>"所属地区不能为空"
        ];
    }
}
