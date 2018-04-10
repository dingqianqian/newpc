<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AreaPriceRequest extends FormRequest
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
            "area"=>"required",
            "discount"=>"required"
        ];
    }
    public function messages()
    {
        return[
            "area.required"=>"地区必填",
            "discount.required"=>"折扣必填"
        ];
    }
}
