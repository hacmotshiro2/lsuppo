<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FB;
use App\Models\Hogosha;
use App\Models\Student;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Consts\AuthConst;

class FBPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view_fb_detail(User $user,FB $fb){
        if(is_null($user)){
            return false;
        }
        //この処理をしないと必要なプロパティにセットされない
        $user->setUserTypeStatus();
        //保護者の場合
        if($user->userType==AuthConst::USER_TYPE_HOGOSHA and $user->isBinded==1){
            //自分の子どものフィードバックしか見ることができない
            
            //認証情報から保護者コードを取得する
            $hogoshaCd = Hogosha::getHogoshaCd($user);
            //保護者コードからStudentCdの一覧を取得する
            $studentCds = Student::getStudentCdsByHogoshaCd($hogoshaCd);

            //fbテーブルのStudentCdが、上で取得した保護者に紐づくStudentCd一覧にあるかどうか。
            return in_array($fb->StudentCd,$studentCds);


        }
        //サポーターの場合
        elseif($user->userType==AuthConst::USER_TYPE_SUPPORTER and $user->isBinded==1){
            #TODO 自分のラーニングルームのを見れる　にするか 一旦全量OK
            return true;
        }
        else{
            return false;
        }
    }
}
