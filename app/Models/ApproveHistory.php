<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Consts\DBConst;

use App\Models\Supporter;


class ApproveHistory extends Model
{
    use HasFactory;

    protected $table = 'r_approvehistory'; 
    protected $fillable = [
        'TargetToken',
        'HasseiDate',
        'ShouninStatus',
        'Comment',
        'TourokuSupporterCd',
        'UpdateGamen',
        'UpdateSystem',
    ];


    //Update系項目のセット
    public function setUpdateColumn(){

        // $this->UpdateDatetime=date("Y-m-d H:i:s");テーブル変更によりなくなった
        $this->UpdateGamen=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; //:現在のURL
        $this->UpdateSystem=DBConst::UPDATE_SYSTEM;
        
    }
    //サポーターのコードと名前をコロン区切りで返します。
    public function getSupporterCdName(){
        $cd = $this->TourokuSupporterCd;
        //サポーターマスタから表示名を取得
        $supporter = Supporter::where('SupporterCd',$cd)->first();
        if(is_null($supporter)){
            return $cd;
        }
        return $cd.":".$supporter->HyouziMei;
    }
    //承認ステータス名を画面に表示するために
    public function getShouninStatusCdName(){

        return $this->ShouninStatus.":".self::stGetShouninStatusName($this->ShouninStatus);
    }
    public static function stGetShouninStatusName(string $shouninStatus){
        switch($shouninStatus){
        case DBConst:: SHOUNIN_STATUS_DRAFT :
            return '下書き中';
            break;
        case DBConst:: SHOUNIN_STATUS_DELETED :
            return '削除済み';
            break;
        case DBConst:: SHOUNIN_STATUS_APPROVING :
            return '承認中';
            break;
        case DBConst:: SHOUNIN_STATUS_RETURN :
            return '差し戻し';
            break;
        case DBConst:: SHOUNIN_STATUS_APPROVED :
            return '承認済み';
            break;
        default:
            return '';
            break;
        }
    }
    
}
