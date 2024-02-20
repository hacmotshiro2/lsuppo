<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
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
            //StudentCd
            
            //HogoshaCd
            'HogoshaCd' => ['required','exists:m_hogosha,HogoshaCd'],
            //Sei
            'Sei'=>'required',
            //Mei
            'Mei'=>'required',
            //Hurigana
            'Hurigana'=>'required',
            //HyouziMei
            'HyouziMei'=>'required',
            //ScratchID
            'ScratchID'=>'required',
            //LearningRoomCd
            'LearningRoomCd'=>['exists:m_learningroom,LearningRoomCd'],
            //riyouShuuryouDate
            // 'RiyouShuuryouDate'=>['after_or_equal:RiyouKaisiDate'],//nullのとき上手くいかないので
        ];
        //StudentCd
        //新規モードの時
        if($this->mode=='create'){
            $rules['StudentCd'] = ['required',Rule::unique('m_student','StudentCd')];
        }
 
        return $rules;
    }
}
