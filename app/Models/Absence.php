<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Consts\DBConst;

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
}
