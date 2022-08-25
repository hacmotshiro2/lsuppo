<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User2Supporter;

class Supporter extends Model
{
    use HasFactory;
  
    protected $table = 'm_supporter';
    protected $guarded = ['UpdateTimeStamp'];

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
    