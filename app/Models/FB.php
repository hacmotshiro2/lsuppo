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


    //スコープ：承認済みのみ
    public function scopeApproved($query){
        //5承認済みに絞る
        return $query->where('ShouninStatus','5');
    }
}
