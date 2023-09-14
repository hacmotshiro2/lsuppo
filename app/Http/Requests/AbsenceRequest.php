<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Consts\MessageConst;


class AbsenceRequest extends FormRequest
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
            'AbsentDate'=>'required',
            'NotifiedDatetime'=>'required',
            'LCZiyuuCd'=>'required',
            'LCYoteiAmountImm' =>['required','numeric','between:-999,999'],
            'LCYoteiAmountExp' =>['required','numeric','between:-999,999'],
            'TourokuSupporterCd'=>'required',
            
        ];
    }

    public function messages(){
        return[
            //StudentCd
            'StudentCd.required' => sprintf(MessageConst::REQUIRED,'生徒コード'),
            //AbsentDate
            'AbsentDate.required' => sprintf(MessageConst::REQUIRED,'欠席年月日'),
            //NotifiedDatetime
            'NotifiedDatetime.required' => sprintf(MessageConst::REQUIRED,'欠席連絡受付日時'),
            //LCZiyuuCd
            'LCZiyuuCd' => sprintf(MessageConst::REQUIRED,'事由'),
            //LCYoteiAmount
            'LCYoteiAmountImm.required' => sprintf(MessageConst::REQUIRED,'エルコイン付与予定額（即時）'),
            'LCYoteiAmountImm.numeric' => sprintf(MessageConst::NUMERIC,'エルコイン付与予定額（即時）'),
            'LCYoteiAmountExp.required' => sprintf(MessageConst::REQUIRED,'エルコイン付与予定額（期限切れ）'),
            'LCYoteiAmountExp.numeric' => sprintf(MessageConst::NUMERIC,'エルコイン付与予定額（期限切れ）'),
            //TourokuSupporterCd
            'TourokuSupporterCd.required' => sprintf(MessageConst::REQUIRED,'登録サポーターコード'),
        ];
    }
}
