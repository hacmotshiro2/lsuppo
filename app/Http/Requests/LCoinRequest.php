<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Consts\MessageConst;

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
            //欠席情報が紐づけ可能な状態かどうかチェック
            'AbsenceId'=>['absence_available'],
            //パラメータ（：以降）は文字列として渡されてしまう。ここでrequestから取り出して、文字連結して渡す。
            'StudentCd'=>['required','absence_student:'.$this->AbsenceId],
            'HasseiDate'=>'required',
            'ZiyuuCd'=>'required',
            'Amount' =>['numeric','required','between:-999,999'],
        ];
    }
    public function messages(){
        return[
            //欠席情報
            'AbsenceId.absence_available' => "紐づけ可能な欠席情報ではありません",
            //生徒コード
            'StudentCd.required' => sprintf(MessageConst::REQUIRED,'生徒コード'),
            'StudentCd.absence_student' => "欠席情報の生徒コードと一致しません",
            //発生日
            'HasseiDate.required' => sprintf(MessageConst::REQUIRED,'発生日'),
            //事由コード
            'ZiyuuCd.required' => sprintf(MessageConst::REQUIRED,'事由コード'),
            //エルコイン数量
            'Amount.required' => sprintf(MessageConst::REQUIRED,'エルコイン数量'),
            'Amount.numeric' => sprintf(MessageConst::NUMERIC,'エルコイン数量'),
           
        ];
    }
}
