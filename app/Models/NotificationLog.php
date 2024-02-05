<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Consts\DBConst;

class NotificationLog extends Model
{
    use HasFactory;

    protected $table = 'r_notificationlogs'; 
    protected $guarded = ['UpdateTimeStamp'];
    
    public function getNTCodeNameAttribute(){
        //通知タイプと通知タイプ名を返す
        $ret="";
        switch($this->notification_type){
            case DBConst::NT_MAIL:
                $ret = DBConst::NT_MAIL.":メール";
                break;
            case DBConst::NT_LINE:
                $ret = DBConst::NT_LINE.":LINE";
                break;
            default:
                break;
        }

        return $ret;
    }
}
