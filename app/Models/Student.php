<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'm_student';

    use HasFactory;

    public function getCdName(){
        return $this->StudentCd.':'.$this->HyouziMei;
    }
}
