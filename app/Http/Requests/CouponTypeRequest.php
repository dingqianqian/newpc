<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponTypeRequest extends FormRequest
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
            'name'=>'required',
            'expire_time_start'=>'required',
            'expire_time_end'=>'required',
            'use_value'=>'required',
            'distribute_count'=>'required',
            'start_price'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required'=>'请输入优惠券名称',
            'expire_time_start.required'=>'请输入有效期起点',
            'expire_time_end.required'=>'请输入有效期终点',
            'use_value.required'=>'请输入抵用金额(折扣)',
            'distribute_count.required'=>'请输入派发总数',
            'start_price.required'=>'请输入使用金额起点'
        ];
    }
}
