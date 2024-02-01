<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Consts\DBConst;
use App\Models\MKoumoku;
use Illuminate\Support\Carbon; // Carbonクラスを使うために追加

class CoursePlan extends Model
{
    use HasFactory;
    use SoftDeletes;

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
    

    //保護者が参照できる生徒のコース・プラン情報を取得します。
    public static function getCoursePlansByHogoshaCd(String $hogoshaCd){

        //保護者が選択できる生徒
        $students = Student::where('hogoshaCd',$hogoshaCd)->get();
        if(count($students)<=0){return null;}

        $items = [];
        
        foreach($students as $student){
            $item = self::where('StudentCd',$student->StudentCd)->where('ApplicationDate',"<=",Carbon::now())->orderBy('ApplicationDate','desc')->first();
            if($item){
                $items[]=$item;
            }
        }

        return $items;
    }
}
