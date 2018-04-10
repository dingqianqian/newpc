<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            "username"=>"required|between:5,11",
            "password"=>"required",
            'captcha'=>"required|between:4,4"
        ];
    }

    /**
     * 自定义错误消息
     * @return array
     */
    public function messages()
    {
        return [
            'username.required'=>"用户名只能输入大小字母和数字5-11位！",
            'username.between'=>"用户名只能输入大小字母和数字5-11位！",
            'password.required'=>"密码不能为空",
            'captcha.between'=>"验证码错误",
            'captcha.required'=>"验证码不能为空"
        ];
    }
}
