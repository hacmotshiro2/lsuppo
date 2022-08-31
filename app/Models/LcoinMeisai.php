<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Consts\DBConst;



class LcoinMeisai extends Model
{
    use HasFactory;

    protected $table = 'r_lc_lcoinmeisai';
    protected $fillable = [
        'StudentCd',
        'HasseiDate',
        'ZiyuuCd',
        'ZiyuuHosoku',
        'Amount',
        'TourokuSupporterCd',
        'UpdateGamen',
        'UpdateSystem'

    ];

    //リレーション
    public function student(){
        return $this->belongsTo('App\Models\Student');
    }
    public function ziyuu(){
        return $this->belongsTo('App\Models\Ziyuu');
    }
    public function supporter(){
        return $this->belongsTo('App\Models\Supporter');
    }


    //Update系項目のセット
    public function setUpdateColumn(){

        $this->UpdateGamen=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; //:現在のURL
        $this->UpdateSystem=DBConst::UPDATE_SYSTEM;
        
    }
    //保護者コードを基にLCoinmeisaiを取得します。
    public static function getLCmeisaiByHogoshaCd(string $hogoshaCd){

        $param = ['hogoshaCd'=>$hogoshaCd];
        $items = DB::select("

        SELECT 
            lc.id,
            lc.StudentCd,
            MS.HyouziMei StudentName,
            MS.HogoshaCd,
            lc.HasseiDate,
            lc.ZiyuuCd,
            MZ.Ziyuu,
            MZ.amount m_amount,
            lc.ZiyuuHosoku,
            lc.TourokuSupporterCd,
            MSP.HyouziMei TourokuSupporterName,
            lc.Amount 
        FROM r_lc_lcoinmeisai lc
        LEFT OUTER JOIN m_student MS
        ON MS.StudentCd = lc.StudentCd
        LEFT OUTER JOIN m_lc_ziyuu MZ
        ON MZ.ZiyuuCd = lc.ZiyuuCd
        LEFT OUTER JOIN m_supporter MSP
        ON MSP.SupporterCd = lc.TourokuSupporterCd
        WHERE MS.HogoshaCd = :hogoshaCd
        ORDER BY lc.StudentCd,lc.HasseiDate DESC
        ",$param);

        return $items;
    }
    //生徒コードから、エルコイン残高を取得
    public static function getLCoinZandakaByStudentCd(string $studentCd){
        $zandaka=0;

        //データベースから該当の明細を取得
        $items = LCoinMeisai::where('studentCd',$studentCd);
        foreach($items as $item){
            $zandaka+=$item->Amount;
        }

        return $zandaka;
    }

    public function getStudentCdName(){
        return $this->StudentCd.":".$this->studnet->HyouziMei;

    }
}
