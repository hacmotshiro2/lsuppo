<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class User2Supporter extends Model
{
    use HasFactory;
    protected $table = 'user2supporter';

    protected $dates = ['deleted_at'];

    public static $rules = [
        'user_id' => 'required',
        'SupporterCd' => 'required',
    ];
    protected $fillable = [
        'user_id',
        'SupporterCd',
    ];
    public static function getu2sData(){
        return DB::select("
        select 
        u.id
        ,u.name
        ,u.email
        ,u.userType
        ,u.StudentName
        ,u2s.user_id
        ,u2s.SupporterCd
        from users u
        left outer join user2supporter u2s
        on u2s.user_id = u.id
        "
        );

    }
}
