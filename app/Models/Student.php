<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'm_student';

    use HasFactory;

    public function getCdName(){
        return $this->StudentCd.':'.$this->HyouziMei;
    }

    //認証情報からStudentCdの情報を配列で返す。保護者：Studentは１対N
    public static function getStudentCdsByHogoshaCd(String $hogoshaCd){
    
        $students = self::where('hogoshaCd',$hogoshaCd)->get();

        //取得できないときは、空で返す。
        if(empty($students)){
            return [];
        }

        return array_column($students->toArray(),'StudentCd');
    }
}
