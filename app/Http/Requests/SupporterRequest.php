<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupporterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            //Sei
            'Sei'=>'required',
            //Mei
            'Mei'=>'required',
            //Hurigana
            'Hurigana'=>'required',
            //HyouziMei
            'HyouziMei'=>'required',
            //LearningRoomCd
            'LearningRoomCd'=>['exists:m_learningroom,LearningRoomCd'],
            //authlevel 数値1~9
            'authlevel' => ['required','integer','between:1,9'],
            //riyouShuuryouDate
            // 'RiyouShuuryouDate'=>['after_or_equal:RiyouKaisiDate'],//nullのとき上手くいかないので
        ];

        //SupporterCd
        //新規モードの時
        if($this->mode=='create'){
            $rules['SupporterCd'] = ['required',Rule::unique('m_supporter','SupporterCd')];
         }
 
         return $rules;

    }
}
