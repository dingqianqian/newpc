<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoodsRequest extends FormRequest
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
            'open_id'=>"required",
            'send_time'=>"required",
            'unit'=>"required",
            'explain'=>"required",
            'min_sale'=>"required",
            'show_price'=>"required",
            'show_sale_price'=>"required",
            'f_goods_status_id'=>"required",
            'f_goods_type_id'=>"required",
            'norms_group'=>"required"
        ];
    }
    public function messages()
    {
        return [
            'name.required'=>"商品名称不能为空",
            "open_id.required"=>"打印送货单时显示的名字不能为空",
            'send_time.required'=>'预计到达时间不能为空',
            'unit.required'=>'商品单位不能为空',
            'explain.required'=>'商品说明不能为空',
            'min_sale.required'=>'最小售卖单位不能为空',
            'show_price.required'=>'易购价不能为空',
            'show_sale_price.required'=>'狂购价不能为空',
            'f_goods_status_id.required'=>'商品状态不能为空',
            'norms_group.required'=>'规格分组不能为空'
        ];
    }
}
