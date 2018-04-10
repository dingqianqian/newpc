<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TakeOverAddrRequest extends FormRequest
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
            'name'=>"required|max:25",
            'province'=>"required",
            'city'=>"required",
            //'town'=>"required",
            'ex'=>"required",
            'tel_no'=>"required|digits:11"
        ];
    }
}
