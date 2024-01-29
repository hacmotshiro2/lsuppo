<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\Models\Absence;
use App\Models\CoursePlan;
use App\Models\User;

use App\Consts\AuthConst;

class CustomValidationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //独自のValidation
        

        /*LCoinRequest（エルコイン登録時）で使用*/

        //紐づけようとしている欠席情報が、登録可能かどうかをチェックする。
        Validator::extend('absence_available', function($attribute,$value,$parameters,$validator){

            // パラメータの欠席情報idを数値型に変換し、エラーチェック
            $absence_id = intval($value); 
            if ($absence_id === 0 || is_null($absence_id)) {
                // エラー処理を行う
                return false;
            } 

            //欠席情報idから欠席情報を取得
            $absence = Absence::find($absence_id);

            $allow = [0,9]; //0未振替　9期限超過
            //  if($absence && is_null($absence->LCSwappedDatetime)){
             if($absence && in_array(intval($absence->HurikaeStatus),$allow)){

                //欠席情報が取得できて、振替ステータスが、未振替または期限超過であれば
                return true;

             }
            
            return false;

        });

        //エルコインを登録する際に、欠席情報のStudentCdと同一かどうかをチェックする。異なればエラー。パラメータに欠席情報のIdをセット
        Validator::extend('absence_student',function($attribute,$value,$parameters,$validator){

            // Log::info('validating absence_student  parameters are ',$parameters);
            
            // パラメータの欠席情報idを数値型に変換し、エラーチェック
            $absence_id = intval($parameters[0]); // intval()関数を使用して文字型を数値型に変換

            if ($absence_id === 0 || is_null($absence_id)) {
                // エラー処理を行う
                return false;
            } 

            //欠席情報idから欠席情報を取得
            $absence = Absence::find($absence_id);

            //欠席情報の生徒と登録しようとしている生徒コードが一致すればOK
            if($absence && $value == $absence->StudentCd){
                return true;
            }

            return false;
        });

        //エルコインを削除しようとする際に、欠席情報に紐づけがされている明細は削除できないようにする
        //$valueにはLCoinMeisaiのidを渡す
        Validator::extend('lcmeisai_exists', function ($attribute, $value, $parameters, $validator) {
            // $value は削除しようとするLCoinMeisaiのIDです
            // Absenceテーブル内で指定のLCMeisaiIdが存在するかを確認します
            return !Absence::where('LCMeisaiId', $value)->exists();
        });

        //コース・プランを登録しようとする際に、同じ生徒で同じ日にすでに登録がある場合にエラーとする
        Validator::extend('appdate_exists', function($attribute,$value,$parameters, $validator){
            //parameters[0]には、StudentCdがセットされている（CoursePlanRequestで指定）

            //StudentCdとapplicationDateで検索する
            $cp = CoursePlan::where('StudentCd',$parameters[0])->where('ApplicationDate', $value)->first();
            if($cp){
                return false;
            }

            return true;

        });

        //ユーザータイプが保護者以外ならエラー
        Validator::extend('user_is_hogosha', function($attribute, $value, $parameters, $validator){
            //$value user_idがセットされる想定

            $usr = User::find($value);
            if($usr){
                if($usr->userType == AuthConst::USER_TYPE_HOGOSHA){
                    return true;
                }
            }
        
            return false;
        });

    }
}
