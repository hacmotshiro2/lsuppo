<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Consts\DBConst;

class ConvTXTHead extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'r_convtxthead'; 
    protected $guarded = [];

    //Update系項目のセット
    public function setUpdateColumn(){

        // $this->UpdateDatetime=date("Y-m-d H:i:s");テーブル変更によりなくなった
        $this->UpdateGamen=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; //:現在のURL
        $this->UpdateSystem=DBConst::UPDATE_SYSTEM;
        
    }
    
}
