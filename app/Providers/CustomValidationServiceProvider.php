<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\Models\Absence;

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

             if($absence && is_null($absence->LCSwappedDatetime)){

                //欠席情報が取得できて、かつエルコイン変換日付がNULLであれば
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
    }
}
