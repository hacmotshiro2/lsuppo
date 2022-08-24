<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Consts\AuthConst;

use App\Models\User2Hogosha;
use App\Models\User2Supporter;
use App\Models\Supporter;
use App\Models\User;

class UserInfoComposer
{

    private $request;

    public function __construct(Request $request){
        // $this->request = $request;
    }
    public function compose(View $view){

        //ユーザーネーム
        $userName='';
        //ユーザータイプ
        $userType=0;
        //m_hogosha,m_supporterとの紐づけがあるかどうか
        $isBinded=0;
        //サポーターの権限レベル
        $sp_authlevel=0;

        // //セッションから取得するように変更。リクエストを取得できない
        // $userType=$request->session()->get(SessionConst::SESKEY_USER_TYPE);
        // $isBinded=$request->session()->get(SessionConst::SESKEY_IS_BINDED);
        // $sp_authlevel=$request->session()->get(SessionConst::SESKEY_SP_AUTHLEVEL);

        $user=Auth::user();
    
        if(!is_null($user)){
            $userName = $user->name;
            $userType=$user->userType;

            switch($userType){
                case AuthConst::USER_TYPE_HOGOSHA:
                    //usersのuserTypeが保護者の場合は、user2hogoshaの登録が済んでいるかをチェック
                    //UserとHogoshaの紐づけテーブルからレコードを取得する。
                    $u2h = User2Hogosha::where('user_id',$user->id)->first();
                
                    //取得できないときは、管理者の処理がまだなので、メニューの制御を変える
                    if(empty($u2h)){
                        $isBinded=0;
                    }
                    else{
                        $isBinded=1;
                    }
                    break;
                case AuthConst::USER_TYPE_SUPPORTER:
                    //usersのuserTypeがサポーターの場合は、user2supporterの登録が済んでいるかをチェック
                    //UserとSupporterの紐づけテーブルからレコードを取得する。
                    $u2s = User2Supporter::where('user_id',$user->id)->first();
                
                    //取得できないときは、管理者の処理がまだなので、メニューの制御を変える
                    if(empty($u2s)){
                        $isBinded=0;
                    }
                    else{
                        $isBinded=1;
                        //authlevelの取得
                        $supporter=Supporter::where('SupporterCd',$u2s->SupporterCd)->first();
                        $sp_authlevel = $supporter->authlevel;
                    }
                    break;
                default:
                    break;
            }
        }

        $view->with('userName',$userName)->with('userType',$userType)->with('isBinded',$isBinded)->with('sp_authlevel',$sp_authlevel);
    }

}