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

use App\Notifications\Channels\LineChannel;

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

        //LINEログイン情報の取得
        $llsettei=false;
        if($user->ll_enabled==1){
            $llsettei = true;
        }

        //usersにline_user_idが登録されている場合のみ、通知先設定変更エリアを表示する
        $canEditNoti = !empty($user->line_user_id);
        
        //友だち追加済みかチェック
        $isFriend =$this->checkIsFriend();
        
        //通知タイプ
        $notiType = 'mail';
        if($user->notification_type==1){
            $notiType = 'line';
        }

        $args=[
            'mail'=>$user->email,
            'alertComp'=>$alertComp,
            'alertErr'=>$alertErr,
            'llsettei'=>$llsettei,
            'canEditNoti'=>$canEditNoti,
            'isFriend'=>$isFriend,
            'notiType'=>$notiType,

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
    //通知関連の更新用Postページ
    public function editNotification(Request $request){
        $user=Auth::user();

        if($this->checkIsFriend()){
            $user->lnots_enabled = 1;
        }
        if($request->notiType=='line'){
            $user->notification_type=1;
        }
        else{
            $user->notification_type=0;
        }
        //入力された名称で上書く
        $user->save();

        $args = [
        ];
        return redirect()->route('settings',$args)->with('alertComp',MessageConst::EDIT_COMPLETED);
    }
    
    //userが友だち追加しているかチェックする
    public function checkIsFriend(){

        //エルサポ公式アカウントを友だち追加で来ているかチェック
        return (new LineChannel())->checkIsFriend(Auth::user());
    }


}
