<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Consts\DBConst;

use App\Models\ApproveHistory;
use App\Models\Supporter;

class FB extends Model
{
    use HasFactory;

    protected $table = 'r_fe_feedbackmeisai'; 
    protected $primaryKey = 'FbNo';
    protected $guarded = ['UpdateTimeStamp'];

    //リレーション
    public function kinyuuSupporter(){
        return $this->belongsTo('App\Models\Supporter','KinyuuSupporterCd','SupporterCd');
    }
    public function student(){
        return $this->belongsTo('App\Models\Student','StudentCd','StudentCd');
    }
    public function learningRoom()
    {
        return $this->belongsTo('App\Models\LR', 'LearningRoomCd', 'LearningRoomCd');
    }
    public function shouninSupporter()
    {
        return $this->belongsTo('App\Models\Supporter', 'ShouninSupporterCd', 'SupporterCd')->withDefault(new Supporter);
    }
    public function shouninStatusName()
    {
        return $this->belongsTo('App\Models\MKoumoku', 'ShouninStatus', 'Code')
            ->where('Shubetu', 100);
    }

    //スコープ：承認済みのみ
    public function scopeApproved($query){
        //5承認済みに絞る
        return $query->where('ShouninStatus',DBConst::SHOUNIN_STATUS_APPROVED);
    }

    //対象期間を From ～ Toの文字で返します
    //getXXXAttributeに変更。こうすることで、$item->XXX指定で取得できるようになる
    // public function getTaishoukikanSTR(){
    public function getTaishoukikanStrAttribute(){
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
        $param = [
            'hogoshaCd'=>$hogoshaCd,
            'shouninStatus'=>DBConst::SHOUNIN_STATUS_APPROVED,
        ];
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
        `ShouninStatus`,
        mk.Value AS ShouninStatusName
        ,FirstReadDate
        ,LastReadDate

        FROM r_fe_feedbackmeisai MAIN 
        LEFT OUTER JOIN m_student mst
        ON mst.StudentCd = MAIN.StudentCd
        LEFT OUTER JOIN m_learningroom mlr
        ON mlr.LearningRoomCd = MAIN.LearningRoomCd
        LEFT OUTER JOIN m_supporter msp_kinyuu
        ON msp_kinyuu.SupporterCd = MAIN.KinyuuSupporterCd
        LEFT OUTER JOIN m_supporter msp_shounin
        ON msp_shounin.SupporterCd = MAIN.ShouninSupporterCd
        LEFT OUTER JOIN m_koumoku mk
        ON mk.Shubetu = 100
        AND mk.Code = MAIN.ShouninStatus
        WHERE mst.HogoshaCd = :hogoshaCd
        AND MAIN.ShouninStatus = :shouninStatus
        AND MAIN.deleted_at IS NULL
        ORDER BY MAIN.StudentCd ,MAIN.TaishoukikanFrom DESC, MAIN.TaishoukikanTo DESC, MAIN.FbNo DESC
        "
        ,$param);

    }
     //保護者が参照できるFB一覧の未読件数を取得します。
     public static function getFBUnreadCountByHogoshaCd(String $hogoshaCd){
        //保護者が参照できるFBリストを取得
        $lFB = self::getFBListByHogoshaCd($hogoshaCd);

        //未読件数
        $unreads = 0;

        foreach($lFB as $item){
            // FirstReadDate 初回閲覧日がNULLの場合カウントする
            if ($item->FirstReadDate === null){
                $unreads += 1;
            }
        }

        return $unreads;

     }
    //Ph2.2 Livewire化に伴ってEloquent化。廃止
    // //承認状態に関わらず取得 削除済みは除く
    // public static function getAllFBList(){
    //     return DB::select("
    //     SELECT 
    //     FbNo, 
    //     MAIN.StudentCd, 
    //     mst.HyouziMei AS StudentName,
    //     `FbShurui`, 
    //     `TaishoukikanFrom`, 
    //     `TaishoukikanTo`, 
    //     MAIN.LearningRoomCd, 
    //     mlr.LearningRoomName AS LRName,
    //     `Title`, 
    //     `Detail`, 
    //     `KinyuuSupporterCd`, 
    //     msp_kinyuu.HyouziMei AS KinyuuSupporterName , 
    //     `KinyuuDate`, 
    //     `ShouninSupporterCd`, 
    //     msp_shounin.HyouziMei AS ShouninSupporterName , 
    //     `ShouninDate`, 
    //     `ShouninStatus`,
    //     mk.Value AS ShouninStatusName
    //     ,FirstReadDate
    //     ,LastReadDate

    //     FROM r_fe_feedbackmeisai MAIN 
    //     LEFT OUTER JOIN m_student mst
    //     ON mst.StudentCd = MAIN.StudentCd
    //     LEFT OUTER JOIN m_learningroom mlr
    //     ON mlr.LearningRoomCd = MAIN.LearningRoomCd
    //     LEFT OUTER JOIN m_supporter msp_kinyuu
    //     ON msp_kinyuu.SupporterCd = MAIN.KinyuuSupporterCd
    //     LEFT OUTER JOIN m_supporter msp_shounin
    //     ON msp_shounin.SupporterCd = MAIN.ShouninSupporterCd
    //     LEFT OUTER JOIN m_koumoku mk
    //     ON mk.Shubetu = 100
    //     AND mk.Code = MAIN.ShouninStatus
    //     WHERE 1=1
    //     AND MAIN.deleted_at IS NULL
    //     ORDER BY MAIN.StudentCd ,MAIN.TaishoukikanFrom DESC, MAIN.TaishoukikanTo DESC, MAIN.FbNo DESC
    //     "
    //     );

    // }

    //サポーター用 LR別にすべての生徒のフィードバックを取得
    public static function getAllFBListByLRCode($lr = '999999', $orderColumn = null, $sortOrder = null){

        //指定されたソート列およびソート順に沿ってDBからフィードバック明細を取得
        switch($orderColumn){
            case "FbNo":
                //FbNoは主キーのため、他のorderは不要（意味がない）
                return self::with('student')
                ->where('deleted_at', null)
                ->where('LearningRoomCd', $lr)
                ->orderBy('FbNo', $sortOrder)
                ->get();
                break;
            case "StudentCd":
                return self::with('student')
                ->where('deleted_at', null)
                ->where('LearningRoomCd', $lr)
                ->orderBy('StudentCd', $sortOrder)
                ->orderBy('TaishoukikanFrom', 'DESC')
                ->orderBy('FbNo', 'DESC')
                ->get();
                break;
            case "TaishoukikanFrom":
                return self::with('student')
                ->where('deleted_at', null)
                ->where('LearningRoomCd', $lr)
                ->orderBy('TaishoukikanFrom', $sortOrder)
                ->orderBy('StudentCd', 'ASC')
                ->orderBy('FbNo', 'DESC')
                ->get();
                break;
            case "created_at":
                return self::with('student')
                ->where('deleted_at', null)
                ->where('LearningRoomCd', $lr)
                ->orderBy('created_at', $sortOrder)
                ->get();
                break;
            case "updated_at":
                return self::with('student')
                ->where('deleted_at', null)
                ->where('LearningRoomCd', $lr)
                ->orderBy('updated_at', $sortOrder)
                ->get();
                break;
            default:
                //これが基本形
                return self::with('student')
                ->where('deleted_at', null)
                ->where('LearningRoomCd', $lr)
                ->orderBy('StudentCd', 'ASC')
                ->orderBy('TaishoukikanFrom', 'DESC')
                ->orderBy('FbNo', 'DESC')
                ->get();
        }

    }
    //Update系項目のセット
    public function setUpdateColumn(){

        // $this->UpdateDatetime=date("Y-m-d H:i:s");テーブル変更によりなくなった
        $this->UpdateGamen=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; //:現在のURL
        $this->UpdateSystem=DBConst::UPDATE_SYSTEM;
        
    }
    //承認ステータス名を取得
    //getXXXAttributeに変更。こうすることで、$item->XXX指定で取得できるようになる
    public function getShouninStatusNameAttribute(){
        return ApproveHistory::stGetShouninStatusName($this->ShouninStatus);
    }
}
