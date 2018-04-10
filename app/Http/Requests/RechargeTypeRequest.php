<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RechargeTypeRequest extends FormRequest
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
            'money'=>"required|integer",
            'give_back'=>"required|integer",
            //'description'=>"required",
            'image'=>"required"
        ];
    }
    public function messages()
    {
        return [
            'money.required'=>"充值金额不能为空",
            'give_back.required'=>"返现金额不能为空",
            'money.integer'=>"充值金额必须为整数",
            'give_back.integer'=>"返现金额必须为整数",
            //'description.required'=>"充值描述不能为空",
            'image.required'=>"图片不能为空"
        ];
    }
}
