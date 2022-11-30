<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;


class SigninHistory extends Model
{
    use HasFactory;

    protected $table = 'r_signinhistory'; 
    protected $guarded = [];

    public static function getLastXXHistory(int $limit){

        $param = [
            'limit'=>$limit
        ];

        return DB::select("
        SELECT 
        MAIN.id
        ,MAIN.user_id
        ,USER.name
        ,MAIN.signin_datetime
        ,MAIN.ip
        ,MAIN.user_agent
        ,MAIN.os
        ,MAIN.device
        ,MAIN.browser
        FROM r_signinhistory MAIN
        LEFT OUTER JOIN users USER
        ON USER.id = MAIN.user_id

        ORDER BY MAIN.signin_datetime DESC
        
        LIMIT :limit;
        "
        ,$param);

    }
}
