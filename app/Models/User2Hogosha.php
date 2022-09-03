<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class User2Hogosha extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'user2hogosha';

    protected $dates = ['deleted_at'];

    public static $rules = [
        'user_id' => 'required',
        'HogoshaCd' => 'required',
    ];
    protected $fillable = [
        'user_id',
        'HogoshaCd',
    ];

    public static function getu2hData(){
        return DB::select("
        select 
        u.id
        ,u.name
        ,u.email
        ,u.userType
        ,u.StudentName
        ,u2h.user_id
        ,u2h.HogoshaCd
        from users u
        left outer join user2hogosha u2h
        on u2h.user_id = u.id
        "
        );

    }
}
