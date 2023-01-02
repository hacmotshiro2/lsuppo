<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

 
    return $request->user();
});

//API このルートファイルに書くと、prefix api/が勝手につく
#TODO きちんともろもろの認証を行う

/*入退室アプリ関連*/
Route::post('/getlrs','App\Http\Controllers\StudentController@getLRs');
Route::post('/getstudents','App\Http\Controllers\StudentController@getStudents');
// /*LINEログイン関連*/
Route::get('/line/callback','App\Http\Controllers\LINELoginController@callback');

/*LINE MessaggeAPI Webhook */
Route::post('/line/webhook',function(Request $request){
    //pushメッセージしか使わないので、何もせず返す
    return ;
});

