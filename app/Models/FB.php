<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FB extends Model
{
    use HasFactory;

    protected $table = 'r_fe_feedbackmeisai'; 
    protected $primaryKey = 'FbNo';
    protected $guarded = ['UpdateTimeStamp'];

    //リレーション
    public function kinyuusupporter(){
        return $this->belongsTo('App\Models\Supporter','KinyuuSupporterCd','SupporterCd');
    }

    //スコープ：承認済みのみ
    public function scopeApproved($query){
        //5承認済みに絞る
        return $query->where('ShouninStatus','5');
    }
    //対象期間を From ～ Toの文字で返します
    public function getTaishoukikanSTR(){
        //取得した値はすべてstringなので、datetimeに変換する
        $from = date_create($this->TaishoukikanFrom);
        $to = date_create($this->TaishoukikanTo);

        //年を跨がない場合
        if(date_format($from,'Y')===date_format($to,'Y')){
            return date_format($from,'Y年n月j日')."～".date_format($to,'n月j日');
        }
        else{
            return date_format($from,'Y年n月j日')."～".date_format($to,'Y年n月j日');
        }

    }
}
