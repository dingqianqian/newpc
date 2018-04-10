<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/*
 * 通过ID进行数据库操作时候认证
 */
class ByIdRequest extends FormRequest
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
            'id'=>"required|integer"
        ];
    }
    //定义错误消息
    public function messages()
    {
        return [
            'id.required'=>"参数不存在",
            'id.integer'=>"参数错误"
        ];
    }
}
