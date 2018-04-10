<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoodsPackageRequest extends FormRequest
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
            "name"=>"required",
            "show_price"=>"required",
            "show_sale_price"=>"required",
            "status"=>"required",
            "f_goods_norms_id"=>"required",
            "masterImg"=>"required",
            "detailsImg"=>"required"
        ];
    }
    public function messages()
    {
        return [
            "name.required"=>"套餐名称不能为空",
            "show_price.required"=>"易购价不能为空",
            'show_sale_price.required'=>'狂购价不能为空',
            "status.required"=>"商品状态不能为空",
            "f_goods_norms_id.required"=>"商品不能为空",
            "masterImg.required"=>"请上传商品主图",
            "detailsImg.required"=>"请上传商品详情图"
        ];
    }
}
