<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FBRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //このフォームリクエストの利用が許可されているかどうか
        
        // if($this->path() == 'fb/regist/'){
        //     return true;
        // }
        // else{
        //     return false;
        // }

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
            'LearningRoomCd'=>'required',
            'Title' => 'required',
            'Detail' => 'required',
            'TaishoukikanFrom' => 'required',
            'TaishoukikanTo' => 'required',
        ];
    }

    public function messages(){
        return[
            'fbTitle.required' =>'タイトルが未入力です',


        ];

    }

}
