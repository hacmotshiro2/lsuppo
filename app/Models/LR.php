<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LR extends Model
{
    protected $table = 'm_learningroom';
    protected $primaryKey = 'LearningRoomCd';
    protected $keyType = 'string';

    use HasFactory;
    use SoftDeletes;

    public function getCdName(){
        return $this->LearningRoomCd.':'.$this->LearningRoomName;
    }
    //Update系項目のセット
    public function setUpdateColumn(){

        $this->UpdateDatetime=date("Y-m-d H:i:s");
        $this->UpdateGamen=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; //:現在のURL
        $this->UpdateSystem=DBConst::UPDATE_SYSTEM;
        
    }

}
