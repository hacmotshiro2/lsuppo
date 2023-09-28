<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;
use App\Consts\DBConst;
use Illuminate\Support\Facades\Log;

class Absence extends Model
{
    use HasFactory;

    protected $table = 'r_absence'; 
    protected $guarded = ['UpdateTimeStamp'];

    // protected $fillable = [    ];

    //Update系項目のセット
    public function setUpdateColumn(){

        // $this->UpdateDatetime=date("Y-m-d H:i:s");テーブル変更によりなくなった
        $this->UpdateGamen=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; //:現在のURL
        $this->UpdateSystem=DBConst::UPDATE_SYSTEM;
    }

    //リレーション
    public function student(){
        return $this->belongsTo('App\Models\Student','StudentCd','StudentCd');
    }
    public function supporter(){
        return $this->belongsTo('App\Models\Supporter','TourokuSupporterCd','SupporterCd');
    }
    public function ziyuu(){
        return $this->belongsTo('App\Models\LCZiyuu','LCZiyuuCd','ZiyuuCd');
    }

    //欠席連絡日を表示用に「m-d」に変換
    public function getFormattedNotifiedDatetimeAttribute(){

        $dt = DateTime::createFromFormat('Y-m-d H:i:s', $this->NotifiedDatetime);

        if ($dt !== false) {
            // 正常にDateTimeオブジェクトが作成された場合の処理
            return $dt->format('m-d'); // 例: "2023-09-22"
        } else {
            // 失敗した場合の処理
            return "";
        }
    }

    //独自の列(DBには持っていない項目だが、Modelの要素として使いたいとき)"HurikaeStatus"で呼び出せる
    public function getHurikaeStatusNameAttribute(){

        //振替実績日がNULLではない → 別の日に振替が完了している　①振替済み
        //LCMeisaiIdがNULLではない → エルコインへの変換が完了している　②エルコイン変換済み
        //振替期限日を超過している → 振替超過により失効（ただしこの場合エルコインへ変換される想定のため、②に入る想定
        //いずれもNULLの場合 → ⓪未振替

        // //振替実績日がNULLまたは空白ではない
        // if(!empty($this->ToActualDate)){
        //     return "振替済み";
        // }
        // //LCMeisaiIdがNULLではない
        // else if(!empty($this->LCMeisaiId)){
        //     return "エルコイン変換済み";
        // }
        // //振替期限日を超過している
        // else if(strtotime($this->ExpirationDate) >  strtotime('today')){
        //     return "振替期限超過";
        // }
        // else{
        //     return "未振替";
        // }

        // データベースにHurikaeStatusを持つように変更


        switch ($this->HurikaeStatus) {
            case 0:
                return "未振替";
                break;
            case 3:
                return "振替済み";
                break;
            case 5:
                return "エルコイン変換済み";
                break;
            case 9:
                return "振替期限超過";
                break;
            default:
                return "";
        }


    }

    //他の項目を見て、振替ステータスをセットする
    //必ず各項目をセットしてから、コールしてください
    //AbsenceControllerからコールすることを想定してつくっています
    public function setHurikaeStatus(){

        $status = 0; //未振替

        if(!empty($this->ToActualDate)){
            //振替実績日がセットされている場合　3振替済み
            $status = 3;
        }
        else if(!empty($this->LCMeisaiId)){
            //LCMeisaiidがセットされている場合　5エルコイン変換済み
            //ここは通らない想定
            $status = 5;
        }
        else if(strtotime($this->ExpirationDate) <  strtotime('today')){
            //期限が切れている場合　9期限切れ
            $status = 9;
        }

        Log::info("setHurikaeStatus",[$status,$this->HurikaeStatus,$this->ExpirationDate,strtotime($this->ExpirationDate) , strtotime('today')]);

        //（編集モード時用）今のステータスを見て、更新可否を判定
        //更新不可の場合は、元のステータスのママにして返す
        if($this->HurikaeStatus==3){
            if(in_array($status, [5,9])){
                return false;
            }
        }
        else if($this->HurikaeStatus==5){
            if(in_array($status, [3,9])){
                return false;
            }
        }
        else if($this->HurikaeStatus==9){
            if($status == 3){ 
                return false;
            }
        }


        $this->HurikaeStatus = $status;
        return true;
    }
}
