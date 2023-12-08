<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Consts\DBConst;

class MKoumoku extends Model
{
    use HasFactory;

    protected $table = 'm_koumoku'; 
    protected $primaryKey = ['Shubetu','Code'];
    public $incrementing = false;

}