<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Consts\DBConst;

class Student extends Model
{
    protected $table = 'm_student';

    use HasFactory;

    public static $rules = [
        'StudentCd' => 'required'
    ];
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
}
