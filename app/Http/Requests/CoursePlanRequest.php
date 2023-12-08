<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Consts\MessageConst;

class CoursePlanRequest extends FormRequest
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
            //
            'StudentCd'=>'required',
            //1日以外では登録できないようにする
            'ApplicationDate'=>['required','date_format:Y-m-d','regex:/^[0-9]{4}-[0-9]{2}-01$/','appdate_exists:'.$this->StudentCd],
            'CourseCd'=>'required',
            'PlanCd'=>'required',
            
        ];
       
    }

    public function messages(){
        return[
            //StudentCd
            'StudentCd.required' => sprintf(MessageConst::REQUIRED,'生徒コード'),
            //ApplicationDate
            'ApplicationDate.required' => sprintf(MessageConst::REQUIRED,'適用開始日'),
            'ApplicationDate.date_format' => "適用開始日は、日付形式で入力してください",
            'ApplicationDate.regex' => "適用開始日は、月初日（1日）以外入力できません",
            'ApplicationDate.appdate_exists' => "適用開始日は、すでに登録されています",
            //CourseCd
            'CourseCd.required' => sprintf(MessageConst::REQUIRED,'コースコード'),
            //PlanCd
            'PlanCd.required' => sprintf(MessageConst::REQUIRED,'プランコード'),
        ];
    }
}
