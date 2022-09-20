<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Consts\DBConst;

class Hogosha extends Model
{
    use HasFactory;

    protected $table = 'm_hogosha';
    protected $primaryKey = 'HogoshaCd';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'HogoshaCd','Sei','Mei','Hurigana','RiyouKaisiDate','RiyouShuuryouDate','LearningRoomCd','IsLocked','IsNeedPWChange',
        'UpdateGamen','UpdateSystem'
    ];
    public static $rules = [
        //HogoshaCd
        'HogoshaCd' => ['required','unique:m_hogosha,HogoshaCd'],
        //Sei
        'Sei'=>'required',
        //Mei
        'Mei'=>'required',
        //Hurigana
        'Hurigana'=>'required',
        //LearningRoomCd
        'LearningRoomCd'=>['exists:m_learningroom,LearningRoomCd'],
    ];

    public function lr(){
        return $this->belongsTo('App\Models\LR');

    }

    //Update系項目のセット
    public function setUpdateColumn(){

        $this->UpdateGamen=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; //:現在のURL
        $this->UpdateSystem=DBConst::UPDATE_SYSTEM;
        
    }
    
   
    //認証情報から保護者情報の取得
    public static function getHogoshaCd(User $user){
    
        //UserとHogoshaの紐づけテーブルからレコードを取得する。
        $u2h = User2Hogosha::where('user_id',$user->id)->first();

        //取得できないときは、空で返す。
        if(empty($u2h)){
            return '';
            // abort('500',$message=MessageConst::U2H_ERROR);
            // // return view('error',['errors'=>['管理者の登録が未済です']]);
        }

        return $u2h->HogoshaCd;
    }
    

}

