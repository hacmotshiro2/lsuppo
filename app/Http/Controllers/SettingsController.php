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

use App\Notifications\User2HogoshaRegisteredNotification;


class SettingsController extends Controller
{
    /*
        あくまで　usersの設定をする画面として整理
        m_supporterなどの設定をさせるなら別画面とする
    */

 
    //設定ページ
    public function settings(Request $request){
        $user=Auth::user();
        $args=[
            'mail'=>$user->email,
        ];
        return view('hogosha.settings',$args);
    }

    //設定のPostページ
    public function edit(Request $request, Response $response){
        $user=Auth::user();
        //入力された名称で上書く
        $user->name = $request->username;
        $user->save();

        $args = [
            'mail'=>$user->email,
            'alertComp'=>'変更が完了しました',
        ];
        // return redirect()->route('home')->with($args);//上手く引き継げず
        return view('hogosha.settings',$args);

    }
    //デバッグ用
    public function sendmailtest(Request $request){
        #forDEBUG
        if(!env('APP_DEBUG')){
            abort(404);
        }
        $user = User::find(14);

        if(is_null($user)){
            abort(500);

        }

        $user->notify(new User2HogoshaRegisteredNotification($user->name));
    }

}
