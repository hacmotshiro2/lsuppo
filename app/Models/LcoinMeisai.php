<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LcoinMeisai extends Model
{
    use HasFactory;

    protected $table = 'r_lc_lcoinmeisai';
    protected $guarded = ['UpdateTimeStamp'];

}
