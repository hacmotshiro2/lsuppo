<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LCoinRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

         //#TODO
         return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'StudentCd'=>'required',
            'HasseiDate'=>'required',
            'ZiyuuCd'=>'required',
            'Amount' =>['numeric','required','between:-999,999'],
        ];
    }
    public function messages(){
        #TODO
        return[
           
        ];
    }
}
