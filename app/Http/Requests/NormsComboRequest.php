<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NormsComboRequest extends FormRequest
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
            'f_area_id'=>"required",
            'stock'=>"required",
            'sale_stock'=>"required",
            'piece_price'=>"required",
            'small_piece_price'=>"required",
            'single_price'=>"required",
            'sale_single_price'=>"required",
            'f_goods_id'=>"required",
            'f_goods_details_img_id'=>"required",
            'f_goods_img_id'=>"required",
            'norms'=>"required"
        ];
    }
    public function messages()
    {
        return [
            'f_area_id.required'=>"地区不能为空",
            'stock.required'=>"库存不能为空",
            'sale_stock.required'=>"促销库存不能为空",
            'piece_price.required'=>"单价不能为空",
            'small_piece_price.required'=>"11121单价不能为空",
            'single_price.required'=>"宜购价不能为空",
            'sale_single_price.required'=>"冰点价不能为空",
            'f_goods_id.required'=>"商品ID不能为空",
            'f_goods_details_img_id.required'=>"商品详情图不能为空",
            'f_goods_img_id.required'=>"商品图不能为空",
            'norms.required'=>"商品规格组合不能为空"
        ];
    }
}
