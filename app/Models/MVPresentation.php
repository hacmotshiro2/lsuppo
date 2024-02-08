<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Consts\DBConst;
use App\Models\Student;

class MVPresentation extends Model
{
    use HasFactory;

    protected $table = 'r_mv_presentation'; 
    protected $guarded = [];
    //編集時のバリデーションルール
    public static $rules_edit = [
        //StudentCd
        
        //ShootingDate
        'ShootingDate'=>['required'],
        //Title
        'Title'=>['required','max:40'],
        //Description
        'Description'=>['required','max:200'],
        //YouTubeId
        'YouTubeId'=>['required','max:128'],
    ];
    //新規登録時のバリデーションルール
    public static $rules_create = [
        //StudentCd
        'StudentCd' =>['required'],
        //ShootingDate
        'ShootingDate'=>['required'],
        //Title
        'Title'=>['required','max:40'],
        //Description
        'Description'=>['required','max:200'],
        //YouTubeId
        'YouTubeId'=>['required','max:128'],
    ];

    //Update系項目のセット
    public function setUpdateColumn(){

        // $this->UpdateDatetime=date("Y-m-d H:i:s");テーブル変更によりなくなった
        $this->UpdateGamen=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; //:現在のURL
        $this->UpdateSystem=DBConst::UPDATE_SYSTEM;
        
    }

    //リレーション
    public function student(){
        return $this->belongsTo('App\Models\Student');
    }
    //生徒名
    public function getStudentNameAttribute(){
        $studentName = "";
        $student = Student::find($this->StudentCd);
        if($student){
            $studentName = $student->HyouziMei;
        }
        return $studentName;
    }
}
