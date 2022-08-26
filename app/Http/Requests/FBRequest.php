<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Consts\MessageConst;

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
            //StudentCd
            'StudentCd'=>'required',
            //existsは省略（ドロップダウンなので）
            //LearningRoomCd
            'LearningRoomCd'=>'required',
            //existsは省略（ドロップダウンなので）
            //Title 40字以内
            'Title' => ['required','string','max:40'],
            //Detail 200字以上800字以内
            'Detail' => ['required','string','min:200','max:800'],
            //TaishoukikanFrom 必須、日付形式は割愛
            'TaishoukikanFrom' => 'required',
            //TaishoukikanTo 必須、今日以前、Fromより大きいか　日付形式割愛、
            // 'TaishoukikanTo' => ['required','before_or_equal:'.date("Y-m-d"),'gte:TaishoukikanFrom'],
            'TaishoukikanTo' => ['required','before_or_equal:today','after_or_equal:TaishoukikanFrom'],
            //KinyuuSupporterCd
            //readonlyのため省略
        ];
    }

    public function messages(){
        return[
            //StudentCd
            'StudentCd.required' => sprintf(MessageConst::REQUIRED,'生徒コード'),
            //LearningRoomCd
            'LearningRoomCd.required' => sprintf(MessageConst::REQUIRED,'LRコード'),
            //Title
            'Title.required' => sprintf(MessageConst::REQUIRED,'タイトル'),
            //Detail
            'Detail.required' => sprintf(MessageConst::REQUIRED,'フィードバック詳細'),
            //TaishoukikanFrom
            'TaishoukikanFrom.required' => sprintf(MessageConst::REQUIRED,'対象期間'),
            //TaishoukikanTo
            'TaishoukikanTo.required' => sprintf(MessageConst::REQUIRED,'対象期間'),
            'TaishoukikanTo.before_or_equal' => sprintf(MessageConst::BEFORE,'対象期間To','今日'),
            'TaishoukikanTo.after_or_equal' => sprintf(MessageConst::BEFORE,'対象期間To','対象期間From'),
            //KinyuuSupporterCd

        ];

    }

}
