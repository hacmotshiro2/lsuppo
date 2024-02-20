<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class User2Supporter extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'user2supporter';

    protected $dates = ['deleted_at'];

    public static $rules = [
        'user_id' => ['required','exists:users,id'],
        'SupporterCd' => ['required','exists:m_supporter,SupporterCd'],
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
        ,u2s.id as u2s_id
        ,u2s.user_id
        ,u2s.SupporterCd
        from users u
        left outer join user2supporter u2s
        on u2s.user_id = u.id
        and u2s.deleted_at IS NULL 
        ORDER BY u.userType desc, u.id
        "
        );

    }
}
