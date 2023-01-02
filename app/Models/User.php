<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// No. h.hashimoto 2022/08/25 ------>
use App\Models\User2Hogosha;
use App\Models\Hogosha;
use App\Models\User2Supporter;
use App\Models\Supporter;

use App\Consts\AuthConst;
// <------  No. h.hashimoto 2022/08/25 

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // No. h.hashimoto 2022/08/18 ------>
        'userType',
        'studentName',
        // <------  No. h.hashimoto 2022/08/18 
        // No. h.hashimoto 2022/12/07 ------>
        'll_enabled',
        'line_user_id',
        'lnots_enabled',
        'notification_type',
        // <------  No. h.hashimoto 2022/12/07 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // No. h.hashimoto 2022/08/25 ------>
    public $userTypeStatus = '';
    public $isBinded=0;
    public $sp_authlevel=0;
    // No. h.hashimoto 2022/09/20 ------>
    //利用開始終了日をチェックして、利用不可であれば1
    public $isDisabled=0;
    // <------  No. h.hashimoto 2022/09/20 

    public function setUserTypeStatus(){
        //memo:コンストラクタで呼ぼうとしたが、その時点では、プロパティが出来上がっていない。
        //ユーザータイプ
        $userType=0;
        //m_hogosha,m_supporterとの紐づけがあるかどうか
        $isBinded=0;
        //サポーターの権限レベル
        $sp_authlevel=0;
        //利用不可かどうか
        $isDisabled=0;

        $user=$this;
        if(!is_null($user)){
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
                        // No. h.hashimoto 2022/09/20 ------>
                        //保護者マスタの利用開始終了日チェック
                        $h=Hogosha::find($u2h->HogoshaCd);
                        //利用開始日がnullではなく、かつ、利用開始日が、今日より後の場合
                        if(!is_null($h->RiyouKaisiDate) and $h->RiyouKaisiDate > date('Y-m-d') ){
                            $isDisabled = 1;
                        }
                        //利用終了日がnullではなく、かつ、利用終了日が、今日より後の場合
                        if(!is_null($h->RiyouShuuryouDate)and $h->RiyouShuuryouDate < date('Y-m-d')){
                            $isDisabled = 1;
                        }
                        // <------  No. h.hashimoto 2022/09/20 
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
                        // No. h.hashimoto 2022/09/20 ------>
                        //サポーターマスタの利用開始終了日チェック
                        //利用開始日がnullではなく、かつ、利用開始日が、今日より後の場合
                        if(!is_null($supporter->RiyouKaisiDate) and $supporter->RiyouKaisiDate > date('Y-m-d') ){
                            $isDisabled = 1;
                        }
                        //利用終了日がnullではなく、かつ、利用終了日が、今日より後の場合
                        if(!is_null($supporter->RiyouShuuryouDate)and $supporter->RiyouShuuryouDate < date('Y-m-d')){
                            $isDisabled = 1;
                        }
                        // <------  No. h.hashimoto 2022/09/20 
                    }
                    break;
                default:
                    break;
            }
        }
        $this->isBinded= $isBinded;
        $this->sp_authlevel = $sp_authlevel;
        $this->isDisabled = $isDisabled;
    }
    // <------  No. h.hashimoto 2022/08/25 
    
    // No. h.hashimoto 2022/12/31 ------>
    //このユーザーでラインが使えるかどうか
    //Notificationを作成する時に呼ばれる（RouteNotificationクラス）
    public function routeNotificationForLine(){

        if($this->lnots_enabled==1){
            //使える場合は、user_idを返す
            return $this->line_user_id;
        }
        return null;
    }
    // <------  No. h.hashimoto 2022/12/31 


}

