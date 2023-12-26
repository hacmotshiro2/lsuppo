<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\MKoumoku;


class MMonthlyFee extends Model
{
    use HasFactory;

    protected $table = 'm_monthlyfee';
    protected $primaryKey = 'CPCd';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $guarded = ['UpdateTimeStamp'];

    //更新画面を作る想定はないので、このモデルで更新することもない。

    //複合主キーのリレーションうまくいかない
    public function course(){
        return $this->belongsTo('App\Models\MKoumoku', 'CourseCd', 'Code')
        ->where('Shubetu', 110);
    }
    public function plan(){
        return $this->belongsTo('App\Models\MKoumoku', 'PlanCd', 'Code')
        ->where('Shubetu', 120);
    }

    //このマスタの主キーと照合するために、ルールに従って主キーの形にして返してあげる
    public static function getCPCd($courseCd, $planCd){

        return $courseCd."_".$planCd;
    }

    //コース名
    public function getCourseNameAttribute(){

        $mkoumoku = MKoumoku::where('Shubetu', 110)->where('Code',$this->CourseCd)->first();
        if($mkoumoku){
            return $mkoumoku->Value;
        }
        else{
            return "";
        }
    }
    //プラン名
    public function getPlanNameAttribute(){
        $mkoumoku = MKoumoku::where('Shubetu', 120)->where('Code',$this->PlanCd)->first();
        if($mkoumoku){
            return $mkoumoku->Value;
        }
        else{
            return "";
        }

    }

    
}
