<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
