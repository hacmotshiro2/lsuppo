<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Consts\SessionConst;

#TODO このクラス自体要らないかも
class SessionController extends Controller
{
    //
    //セッションの取得
      public function ses_get(Request $request){
        $sesdata = [
            SessionConst::SESKEY_USER_ID => $request->session()->get(SessionConst::SESKEY_USER_ID),
            SessionConst::SESKEY_USER_TYPE => $request->session()->get(SessionConst::SESKEY_USER_TYPE),
        ];
        return $sesdata;
    }
    //セッションのセット
    public function ses_set(Request $request){
        $userID = '';#TODO
        $userType = '';#TODO
        $request->session()->put(SessionConst::SESKEY_USER_ID,$userID);
        $request->session()->put(SessionConst::SESKEY_USER_TYPE,$userType);

    }
}
