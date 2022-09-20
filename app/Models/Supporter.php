<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Consts\DBConst;
use App\Models\User2Supporter;

class Supporter extends Model
{
    use HasFactory;
  
    protected $table = 'm_supporter';
    protected $primaryKey = 'SupporterCd';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    //validationルール
    public static $rules_edit = [
            //SupporterCd
            
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
            //authlevel 1字以内
            'authlevel' => ['required','size:1'],
            //riyouShuuryouDate
            // 'RiyouShuuryouDate'=>['after_or_equal:RiyouKaisiDate'],//nullのとき上手くいかないので
    ];
    public static $rules_create = [
        //SupporterCd
        'SupporterCd'=>['required','unique:m_supporter,SupporterCd'],
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
        //authlevel 1字以内
        'authlevel' => ['required','size:1'],
        //riyouShuuryouDate
        // 'RiyouShuuryouDate'=>['after_or_equal:RiyouKaisiDate'],//nullのとき上手くいかないので
];
public function getCdName(){
        return $this->SupporterCd.':'.$this->HyouziMei;
    }
    //Update系項目のセット
    public function setUpdateColumn(){

        $this->UpdateGamen=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; //:現在のURL
        $this->UpdateSystem=DBConst::UPDATE_SYSTEM;
        
    }

    //認証情報からサポーター情報の取得
    public static function getSupporterCd(User $user){

        //UserとHogoshaの紐づけテーブルからレコードを取得する。
        $u2s = User2Supporter::where('user_id',$user->id)->first();

        //取得できないときは、空で返す。
        if(empty($u2s)){
            return '';
            // abort('500',$message=MessageConst::U2H_ERROR);
            // // return view('error',['errors'=>['管理者の登録が未済です']]);
        }

        return $u2s->SupporterCd;
    }
    
}
    