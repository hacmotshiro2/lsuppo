<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

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

}
