<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FB;
use App\Models\Hogosha;
use App\Models\Student;
use App\Models\Supporter;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

use App\Consts\AuthConst;
use App\Consts\DBConst;
use App\Consts\MessageConst;

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

    // public function add_fb(User $user){
    //これはポリシーではなく画面遷移制御で
     
    //     if(is_null($user)){
    //         return false;
    //     }
    //     //この処理をしないと必要なプロパティにセットされない
    //     $user->setUserTypeStatus();
    //     //サポーターの場合
    //     if($user->userType==AuthConst::USER_TYPE_SUPPORTER and $user->isBinded==1){
    //         //サポーターであれば新規登録は誰でもできる
    //         return true;
    //     }
    //     else{
    //         return false;
    //     }
    // }
    public function edit_fb(User $user,FB $fb){
        //チェック内容によってメッセージを変えて、返す
        //途中でエラーになったらその時点でfalseを返す。

        //check1.承認状態チェック　承認中、取り下げの場合はTRUE。そうでなければFALSE
        if(!in_array($fb->ShouninStatus,[DBConst::SHOUNIN_STATUS_APPROVING,DBConst::SHOUNIN_STATUS_RETURN])){
            //承認中、取り下げじゃなければ
            return Response::deny(MessageConst::SHOUNIN_STATUS_ERROR);
        }

        //この処理をしないと必要なプロパティにセットされない
        $user->setUserTypeStatus();

        //check2.サポーターの権限が9なら、記入者に関係なく編集可能
        if($user->sp_authlevel==9){
            return Response::allow();
        }

        //check3.サポーターかどうかのチェック
        if(!($user->userType==AuthConst::USER_TYPE_SUPPORTER and $user->isBinded==1)){
            //サポーターじゃない
            return Response::deny(MessageConst::DENIED_EDIT);
        }
        else{
            //自分が登録したFBのみ編集できる
            $supporterCd = Supporter::getSupporterCd($user);

            //check4.記入者と同じサポーターかどうか
            if($fb->KinyuuSupporterCd != $supporterCd){
                //異なる
                return Response::deny(MessageConst::DENIED_EDIT);
            }
            else{
                //承認状態がOKで、サポーターで、自分が起票したFBであれば、
                return Response::allow();
            }
        }
    }
    public function approve_fb(User $user,FB $fb){
        if(is_null($user)){
            return false;
        }
        //この処理をしないと必要なプロパティにセットされない
        $user->setUserTypeStatus();

        //今のところ制限なし
        return true;
    }
    public function decline_fb(User $user,FB $fb){
        if(is_null($user)){
            return false;
        }
        //この処理をしないと必要なプロパティにセットされない
        $user->setUserTypeStatus();

        //今のところ制限なし
        return true;
    }
}
