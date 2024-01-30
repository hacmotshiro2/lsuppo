<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // No.Ph.2.5 h.hashimoto 2024/01/29 ------>
    //アラート系のセッション値を配列化して返します。
    //リダイレクト先のControllerから呼ぶことを想定しています。
    // 例）return view('user2hogosha.edit',$args)->with(parent::getAlertSessions());
    public function getAlertSessions(){

        return [
            'alertComp'=>session('alertComp'),
            'alertErr'=>session('alertErr'),
            'alertInfo'=>session('alertInfo'),
            'alertWar'=>session('alertWar'),
        ];
    }
    // <------  No.Ph.2.5 h.hashimoto 2024/01/29 
}
