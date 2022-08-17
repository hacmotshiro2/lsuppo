<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hogosha extends Model
{
    use HasFactory;

    protected $table = 'm_hogosha';
    // protected $primaryKey = 'HogoshaCd';//これ使うと表示が0になった
    protected $guarded = ['UpdateTimeStamp'];

    public static $rules = [
        'HogoshaCd' => 'required'
    ];

    public function lr(){
        return $this->belongsTo('App\Models\LR');

    }

}

