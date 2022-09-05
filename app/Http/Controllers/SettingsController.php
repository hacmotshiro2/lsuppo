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

        //リダイレクト時には、セッションにalertが入ってくる可能性があるので拾う
        $alertComp='';
        if($request->session()->has('alertComp')){
            $alertComp = $request->session()->get('alertComp');
        }
        $alertErr='';
        if($request->session()->has('alertErr')){
            $alertErr = $request->session()->get('alertErr');
        }
        
        $args=[
            'mail'=>$user->email,
            'alertComp'=>$alertComp,
            'alertErr'=>$alertErr,
        ];
        return view('Settings.settings',$args);
    }

    //設定のPostページ
    public function edit(Request $request, Response $response){
        $user=Auth::user();
        //入力された名称で上書く
        $user->name = $request->username;
        $user->save();

        $args = [
        ];
        return redirect()->route('settings',$args)->with('alertComp',MessageConst::EDIT_COMPLETED);
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
