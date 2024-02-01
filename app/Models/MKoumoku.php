<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Consts\DBConst;

class MKoumoku extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'm_koumoku'; 
    protected $primaryKey = ['Shubetu','Code'];
    public $incrementing = false;

}