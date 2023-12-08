<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Consts\DBConst;

class CoursePlan extends Model
{
    use HasFactory;

    protected $table = 'r_courseplan'; 
    protected $guarded = ['UpdateTimeStamp'];

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
    public function course(){
        return $this->belongsTo('App\Models\MKoumoku', 'CourseCd', 'Code')
        ->where('Shubetu', 110);
    }
    public function plan(){
        return $this->belongsTo('App\Models\MKoumoku', 'PlanCd', 'Code')
        ->where('Shubetu', 120);
    }

}
