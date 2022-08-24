<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class FB extends Model
{
    use HasFactory;

    protected $table = 'r_fe_feedbackmeisai'; 
    protected $primaryKey = 'FbNo';
    protected $guarded = ['UpdateTimeStamp'];

    //リレーション
    public function kinyuusupporter(){
        return $this->belongsTo('App\Models\Supporter','KinyuuSupporterCd','SupporterCd');
    }

    //スコープ：承認済みのみ
    public function scopeApproved($query){
        //5承認済みに絞る
        return $query->where('ShouninStatus','5');
    }
    //対象期間を From ～ Toの文字で返します
    public function getTaishoukikanSTR(){
        //取得した値はすべてstringなので、datetimeに変換する
        $from = date_create($this->TaishoukikanFrom);
        $to = date_create($this->TaishoukikanTo);

        //年を跨がない場合
        if(date_format($from,'Y')===date_format($to,'Y')){
            return date_format($from,'Y年n月j日')."～".date_format($to,'n月j日');
        }
        else{
            return date_format($from,'Y年n月j日')."～".date_format($to,'Y年n月j日');
        }

    }
    //保護者が参照できるFB一覧を取得します。
    public static function getFBListByHogoshaCd(String $hogoshaCd){
        $param = ['hogoshaCd'=>$hogoshaCd];
        return DB::select("
        SELECT 
        FbNo, 
        MAIN.StudentCd, 
        mst.HyouziMei AS StudentName,
        `FbShurui`, 
        `TaishoukikanFrom`, 
        `TaishoukikanTo`, 
        MAIN.LearningRoomCd, 
        mlr.LearningRoomName AS LRName,
        `Title`, 
        `Detail`, 
        `KinyuuSupporterCd`, 
        msp_kinyuu.HyouziMei AS KinyuuSupporterName , 
        `KinyuuDate`, 
        `ShouninSupporterCd`, 
        msp_shounin.HyouziMei AS ShouninSupporterName , 
        `ShouninDate`, 
        `ShouninStatus`

        FROM r_fe_feedbackmeisai MAIN 
        LEFT OUTER JOIN m_student mst
        ON mst.StudentCd = MAIN.StudentCd
        LEFT OUTER JOIN m_learningroom mlr
        ON mlr.LearningRoomCd = MAIN.LearningRoomCd
        LEFT OUTER JOIN m_supporter msp_kinyuu
        ON msp_kinyuu.SupporterCd = MAIN.KinyuuSupporterCd
        LEFT OUTER JOIN m_supporter msp_shounin
        ON msp_shounin.SupporterCd = MAIN.ShouninSupporterCd
        WHERE mst.HogoshaCd = :hogoshaCd
        AND MAIN.ShouninStatus = '5'
        ORDER BY MAIN.StudentCd ,MAIN.TaishoukikanFrom DESC, MAIN.TaishoukikanTo DESC, MAIN.FbNo DESC
        "
        ,$param);

    }
}
