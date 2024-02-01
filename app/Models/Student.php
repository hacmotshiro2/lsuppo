<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Consts\DBConst;

use App\Models\Hogosha;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'm_student';
    protected $primaryKey = 'StudentCd';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'StudentCd',
        'Sei',
        'Mei',
        'Hurigana',
        'HyouziMei',
        'HogoshaCd',
        'ScratchID',
        'ScratchURL',
        'RiyouKaisiDate',
        'RiyouShuuryouDate',
        'LearningRoomCd',
        'IsLocked',
        'IsNeedPWChange',
        'UpdateGamen',
        'UpdateSystem',

    ];
    public function getCdName(){
        return $this->StudentCd.':'.$this->HyouziMei;
    }
    //Update系項目のセット
    public function setUpdateColumn(){

        $this->UpdateGamen=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; //:現在のURL
        $this->UpdateSystem=DBConst::UPDATE_SYSTEM;
        
    }

    //保護者コードからStudentCdの情報を配列で返す。StudentCdの昇順。保護者：Studentは１対N
    public static function getStudentCdsByHogoshaCd(String $hogoshaCd){
    
        $students = self::where('hogoshaCd',$hogoshaCd)->orderBy('StudentCd','asc')->get();

        //取得できないときは、空で返す。
        if(empty($students)){
            return [''];
        }

        return array_column($students->toArray(),'StudentCd');
    }

    //保護者姓名を取得
    public function getHogoshaSeiMeiAttribute(){
        $seimei="";
        $hogosha = Hogosha::find($this->HogoshaCd);

        if($hogosha){
            $seimei = $hogosha->Sei." ".$hogosha->Mei;
        }
        return $seimei;
    }
}
