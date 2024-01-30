<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Models\Hogosha;

class HogoshaRequest extends FormRequest
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
            //LearningRoomCd
            'LearningRoomCd'=>['exists:m_learningroom,LearningRoomCd'],
        ];
        //HogoshaCd
        //新規モードの時
        if($this->mode=='create'){
           $rules['HogoshaCd'] = ['required',Rule::unique('m_hogosha','HogoshaCd')->withoutTrashed()];
        }

        return $rules;
    }
}
