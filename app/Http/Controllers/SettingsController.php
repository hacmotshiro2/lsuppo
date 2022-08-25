<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Hogosha;
use App\Models\User2Hogosha;
use Illuminate\Support\Facades\Auth;

use App\Consts\MessageConst;
use App\Consts\AuthConst;
use App\Consts\SessionConst;

class SettingsController extends Controller
{
    /*
        あくまで　usersの設定をする画面として整理
        m_supporterなどの設定をさせるなら別画面とする
    */

 
    //設定ページ
    public function settings(Request $request){
        return view('hogosha.settings');
    }

    //設定のPostページ
    public function edit(Request $request, Response $response){
        $user=Auth::user();
        //入力された名称で上書く
        $user->name = $request->username;
        $user->save();

        $arg = [
            'alertComp'=>'変更が完了しました',
        ];
        return redirect('hogosha.settings',302)->with($arg);

    }

}
