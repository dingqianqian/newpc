<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 通过json字符串操作数据库的时候认证
 * Class JsonRequest
 * @package App\Http\Requests
 */
class JsonRequest extends FormRequest
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
            'info'=>"json"
        ];
    }
    //错误信息
    public function messages()
    {
        return [
            'info.json'=>"参数格式错误"
        ];
    }
}
