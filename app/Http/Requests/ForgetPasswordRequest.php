<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordRequest extends FormRequest
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
            "email"=>"required|email"
        ];
    }
    /*
     * 消息
     */
    public function messages()
    {
        return [
            'username.required'=>"用户名只能输入大小字母和数字5-11位！",
            'username.between'=>"用户名只能输入大小字母和数字5-11位！",
            'email.required'=>"邮箱不能为空",
            'email.email'=>"邮箱格式不正确",
            ];
    }
}
