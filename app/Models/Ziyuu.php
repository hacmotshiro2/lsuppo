<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ziyuu extends Model
{
    use HasFactory;

    protected $table = 'm_lc_ziyuu';
    protected $fillable = [
        'ZiyuuCd',
        'Ziyuu',
        'UpdateGamen',
        'UpdateSystem',
        'amount'
    ];

    public function getCdName(){
        return $this->ZiyuuCd.':'.$this->Ziyuu;
    }
}
