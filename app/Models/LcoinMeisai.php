<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class LcoinMeisai extends Model
{
    use HasFactory;

    protected $table = 'r_lc_lcoinmeisai';
    protected $guarded = ['UpdateTimeStamp'];

    //リレーション
    public function student(){
        return $this->belongsTo('App\Models\Student');
    }
    public function ziyuu(){
        return $this->belongsTo('App\Models\Ziyuu');
    }
    public function supporter(){
        return $this->belongsTo('App\Models\Supporter');
    }


    //Update系項目のセット
    public function setUpdateColumn(){

        $this->UpdateDatetime=date("Y-m-d H:i:s");
        $this->UpdateGamen=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; //:現在のURL
        $this->UpdateSystem=DBConst::UPDATE_SYSTEM;
        
    }

}
