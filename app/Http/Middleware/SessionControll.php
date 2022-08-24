<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Hogosha;
use App\Models\Supporter;
use App\Models\User2Hogosha;
use App\Models\User2Supporter;
use Illuminate\Support\Facades\Auth;

use App\Consts\MessageConst;
use App\Consts\AuthConst;
use App\Consts\SessionConst;

class SessionControll
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user=Auth::user();
        //確認
        $userType=$request->session()->get(SessionConst::SESKEY_USER_TYPE);
        //セットされていなければ
        if(empty($userType)){
            //認証済みしか来ない想定だが念のため
            if(!empty($user)){
                $userType=$user->userType;
                $request->session()->put(SessionConst::SESKEY_USER_TYPE,$userType);
            }
        }
        //確認
        $isBinded=$request->session()->get(SessionConst::SESKEY_IS_BINDED);
        $sp_authlevel=$request->session()->get(SessionConst::SESKEY_SP_AUTHLEVEL);

        //セットされていなければ
        if(empty($isBinded) or empty($sp_authlevel)){
            switch($userType){
                case AuthConst::USER_TYPE_HOGOSHA:
                    //usersのuserTypeが保護者の場合は、user2hogoshaの登録が済んでいるかをチェック
                    //UserとHogoshaの紐づけテーブルからレコードを取得する。
                    $u2h = User2Hogosha::where('user_id',$user->id)->first();
                
                    //取得できないときは、管理者の処理がまだなので、メニューの制御を変える
                    if(empty($u2h)){
                        $isBinded=0;
                    #TODO
                    // abort('500',$message=MessageConst::U2H_ERROR);
                    // // return view('error',['errors'=>['管理者の登録が未済です']]);
                    }
                    else{
                        $isBinded=1;
                    }
                    $sp_authlevel=0;
                    break;
                case AuthConst::USER_TYPE_SUPPORTER:
                    //usersのuserTypeがサポーターの場合は、user2supporterの登録が済んでいるかをチェック
                    //UserとSupporterの紐づけテーブルからレコードを取得する。
                    $u2s = User2Supporter::where('user_id',$user->id)->first();
                
                    //取得できないときは、管理者の処理がまだなので、メニューの制御を変える
                    if(empty($u2s)){
                        $isBinded=0;
                    #TODO
                    // abort('500',$message=MessageConst::U2H_ERROR);
                    // // return view('error',['errors'=>['管理者の登録が未済です']]);
                    }
                    else{
                        $isBinded=1;
                        //authlevelの取得
                        $supporter = Supporter::where('SupporterCd',$u2s->SupporterCd)->first();
                        $sp_authlevel = $supporter->authlevel;
                    }
                    break;
                default:
                    $isBinded=0;
                    $sp_authlevel=0;
                    break;
            }
            $request->session()->put(SessionConst::SESKEY_IS_BINDED,$isBinded);
            $request->session()->put(SessionConst::SESKEY_SP_AUTHLEVEL,$sp_authlevel);
        }
           
        return $next($request);
    }
      
}
