<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Consts\MessageConst;

class User2HogoshaRequest extends FormRequest
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
        return [
            //user_id
            'user_id' => ['required','exists:users,id'
                ,Rule::unique('user2hogosha','user_id')->withoutTrashed()
                ,'user_is_hogosha'],
            //HogoshaCd
            'HogoshaCd' => ['required','exists:m_hogosha,HogoshaCd'],
        ];
    }

    public function messages(){

        return [
            'user_id.user_is_hogosha' => MessageConst::USER_ISNT_HOGOSHA,
        ];
    }
}
