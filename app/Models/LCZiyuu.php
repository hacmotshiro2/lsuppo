<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Consts\DBConst;

class LCZiyuu extends Model
{
    use HasFactory;

    protected $table = 'm_lc_ziyuu';
    protected $primaryKey = 'ZiyuuCd';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'ZiyuuCd',
        'Ziyuu',
        'DefaultAmount',
        'UpdateGamen',
        'UpdateSystem',
    ];
    public static $rules_edit = [
        
        //Ziyuu
        'Ziyuu' => ['required','max:40'],
        //DefaultAmount
        'DefaultAmount' =>['required','integer'],
    ];
    public static $rules_create = [
        //ZiyuuCd
        'ZiyuuCd' => ['required','unique:m_lc_ziyuu,ZiyuuCd'],
        //Ziyuu
        'Ziyuu' => ['required','max:40'],
        //DefaultAmount
        'DefaultAmount' =>['required','integer'],
    ];

    public function getCdName(){
        return $this->ZiyuuCd.':'.$this->Ziyuu;
    }
    //Update系項目のセット
    public function setUpdateColumn(){

        $this->UpdateGamen=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; //:現在のURL
        $this->UpdateSystem=DBConst::UPDATE_SYSTEM;
        
    }

}
