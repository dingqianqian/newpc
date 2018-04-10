<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * id逗号分割字符串认证
 * Class IdsRequest
 * @package App\Http\Requests
 */
class IdsRequest extends FormRequest
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
            'id'=>['regex:/(\d+,)+/']
        ];
    }
    //错误消息
    public function messages()
    {
        return [
            'id.regex'=>"参数错误"
        ];
    }
}
