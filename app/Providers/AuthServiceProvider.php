<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
// No. h.hashimoto 2022/08/25 ------>
use App\Models\User;
use App\Models\User2Hogosha;
use App\Models\User2Supporter;

use App\Consts\AuthConst;

//<------ No. h.hashimoto 2022/08/25 

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        // No. h.hashimoto 2022/08/25 ------>
        'App\Models\FB' => 'App\Policies\FBPolicy',
        'App\Models\LCoin' => 'App\Policies\LCoinPolicy',
        // <------  No. h.hashimoto 2022/08/25 
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // No. h.hashimoto 2022/09/20 ------>
        //利用開始日終了日判定。利用不能の場合にtrue
        Gate::define('isDisabled',function(User $user){
            if(is_null($user)){return false;}
    
            //必要なプロパティに値をセット
            $user->setUserTypeStatus();
            if($user->isDisabled==1){return true;}
            return false;
        });
        // <------  No. h.hashimoto 2022/09/20 

        // No. h.hashimoto 2022/08/25 ------>
        //ログインユーザーのタイプを定義
        //m_hogoshaとの紐づけが済んでいる保護者
        Gate::define('hogosha-binded',function(User $user){

            if(is_null($user)){return false;}

            // if($user->userType==AuthConst::USER_TYPE_HOGOSHA){
            //     //usersのuserTypeが保護者の場合は、user2hogoshaの登録が済んでいるかをチェック
            //     //UserとHogoshaの紐づけテーブルからレコードを取得する。
            //     $u2h = User2Hogosha::where('user_id',$user->id)->first();
            
            //     if(!empty($u2h)){
            //         return true;
            //     }
            // }
            //必要なプロパティに値をセット
            $user->setUserTypeStatus();
            if($user->userType==AuthConst::USER_TYPE_HOGOSHA and $user->isBinded==1 ){
                return true;
            }
            return false;
        });
         //m_hogoshaとの紐づけが済んでいない保護者
        Gate::define('hogosha-nobind',function(User $user){

            if(is_null($user)){return false;}

            //必要なプロパティに値をセット
            $user->setUserTypeStatus();
            if($user->userType==AuthConst::USER_TYPE_HOGOSHA and $user->isBinded==0){
                //usersのuserTypeが保護者の場合は、user2hogoshaの登録が済んでいるかをチェック
                return true;
            }
            return false;
        });
        Gate::define('hogosha',function(User $user){
      
            if(is_null($user)){return false;}
            return $user->userType==AuthConst::USER_TYPE_HOGOSHA;

        });
        //m_supporterとの紐づけが済んでいるサポーター
        //メニュー制御につかわなくとも、画面制御などに使っているので、残す。
        Gate::define('supporter-binded',function(User $user){
      
            if(is_null($user)){return false;}

            //必要なプロパティに値をセット
            $user->setUserTypeStatus();
            if($user->userType==AuthConst::USER_TYPE_SUPPORTER and $user->isBinded==1){
                //usersのuserTypeがサポーターの場合は、user2supporterの登録が済んでいるかをチェック
                return true;
            }
            return false;
        
        });
        Gate::define('supporter-nobind',function(User $user){
      
            if(is_null($user)){return false;}
      
            //必要なプロパティに値をセット
            $user->setUserTypeStatus();
            if($user->userType==AuthConst::USER_TYPE_SUPPORTER and $user->isBinded==0){
                //usersのuserTypeがサポーターの場合は、user2supporterの登録が済んでいるかをチェック
                return true;
                  
            }
            return false;
        });
        Gate::define('supporter',function(User $user){
      
            if(is_null($user)){return false;}
            return $user->userType==AuthConst::USER_TYPE_SUPPORTER;

        });
        // <------  No. h.hashimoto 2022/08/25 
        Gate::define('supporter-auth-1',function(User $user){
            if(is_null($user)){return false;}
      
            //必要なプロパティに値をセット
            $user->setUserTypeStatus();
            if($user->userType==AuthConst::USER_TYPE_SUPPORTER and $user->isBinded==1 and $user->sp_authlevel==1){
                //usersのuserTypeがサポーターの場合は、user2supporterの登録が済んでいるかをチェック
                //authlevelをチェック
                return true;
                  
            }
            return false;

        });
        Gate::define('supporter-auth-5',function(User $user){
            if(is_null($user)){return false;}
      
            //必要なプロパティに値をセット
            $user->setUserTypeStatus();
            if($user->userType==AuthConst::USER_TYPE_SUPPORTER and $user->isBinded==1 and $user->sp_authlevel==5){
                //usersのuserTypeがサポーターの場合は、user2supporterの登録が済んでいるかをチェック
                //authlevelをチェック
                return true;
                  
            }
            return false;

        });
        Gate::define('supporter-auth-9',function(User $user){
            if(is_null($user)){return false;}
      
            //必要なプロパティに値をセット
            $user->setUserTypeStatus();
            if($user->userType==AuthConst::USER_TYPE_SUPPORTER and $user->isBinded==1 and $user->sp_authlevel==9){
                //usersのuserTypeがサポーターの場合は、user2supporterの登録が済んでいるかをチェック
                //authlevelをチェック
                return true;
                  
            }
            return false;

        });
    }
}
