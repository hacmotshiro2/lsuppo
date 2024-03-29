<?php

use Illuminate\Support\Facades\Route;

// app\Http\Controllers\;
use App\Http\Middleware\SessionControll;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//      return view('debug');
// });
//保護者かサポーターによって分岐し、それぞれのTOPページにリダイレクトする。
Route::get('/','App\Http\Controllers\HomeController@mypage')->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/error',function(){
    return view('error');
});


Route::middleware('lsuppo')->group(function () {

    /*
    * middleware lsuppo では、m_gateauthorizationテーブルを参照して
    * 権限チェックを行っています。
    * こちらに追加した場合には、当該テーブルへの更新が必要です。
    */

    /*共通ページ*/
    Route::get('/settings/', 'App\Http\Controllers\SettingsController@settings')->name('settings');
    Route::post('/settings/edit/', 'App\Http\Controllers\SettingsController@edit');
    Route::post('/settings/editNotification/', 'App\Http\Controllers\SettingsController@editNotification');
    Route::get('/line/bind','App\Http\Controllers\LINELoginController@bind');
    Route::get('/line/binding/', 'App\Http\Controllers\LINELoginController@binding')->name('line-binding');

    /*保護者が参照するページ*/
    Route::get('/mypage/', 'App\Http\Controllers\HogoshaController@mypage')->name('mypage');
    Route::get('/fb/detail/', 'App\Http\Controllers\FBController@fbDetail')->name('fbDetail');
    Route::get('/fb/', 'App\Http\Controllers\FBController@index')->name('fbIndex');
    Route::get('/lc/', 'App\Http\Controllers\LCoinController@index');
    Route::get('/mv/presen/watch/','App\Http\Controllers\MVController@index');
    Route::get('/scratch/index_pj/','App\Http\Controllers\ScratchController@index_pj');

    /*サポーターが参照するページ*/
    Route::get('/supporter-page/','App\Http\Controllers\SupporterController@index')->name('supporter-page');
    Route::get('/fb/index_sp', 'App\Http\Controllers\FBController@index_sp')->name('fbIndex_sp');
    Route::get('/fb/add/', 'App\Http\Controllers\FBController@add')->name('fbAdd');
    Route::post('/fb/add/', 'App\Http\Controllers\FBController@addpost');
    Route::get('/fb/edit/', 'App\Http\Controllers\FBController@edit')->name('fbEdit');
    Route::post('/fb/edit/', 'App\Http\Controllers\FBController@editpost');
    // Route::post('/fb/delete/', 'App\Http\Controllers\FBController@deletepost');//削除する想定ない。

    /*権限レベルが高いサポーターが参照するページ*/
    Route::get('/sysad/', function(){return view('SysAdmin.index');});

    Route::post('/fb/approve/', 'App\Http\Controllers\FBController@approve');
    Route::post('/fb/decline/', 'App\Http\Controllers\FBController@decline');

    // Route::get('/hogosha/add/{HogoshaCd?}', 'App\Http\Controllers\HogoshaController@add')->name('hogosha-add');
    Route::get('/hogosha/list', 'App\Http\Controllers\HogoshaController@list')->name('hogosha-list');
    Route::get('/hogosha/edit/', 'App\Http\Controllers\HogoshaController@edit');
    Route::post('/hogosha/create/', 'App\Http\Controllers\HogoshaController@create');
    Route::post('/hogosha/update/', 'App\Http\Controllers\HogoshaController@update');
    Route::post('/hogosha/delete/', 'App\Http\Controllers\HogoshaController@delete');

    Route::get('/student/list/', 'App\Http\Controllers\StudentController@list')->name('student-list');
    Route::get('/student/edit/', 'App\Http\Controllers\StudentController@edit')->name('student-edit');
    Route::post('/student/create/', 'App\Http\Controllers\StudentController@create');
    Route::post('/student/update/', 'App\Http\Controllers\StudentController@update');
    Route::post('/student/delete/', 'App\Http\Controllers\StudentController@delete');

    Route::get('/user2hogosha/list/', 'App\Http\Controllers\HogoshaController@u2hlist')->name('u2h-list');
    Route::get('/user2hogosha/edit/', 'App\Http\Controllers\HogoshaController@u2hedit')->name('u2h-edit');
    Route::post('/user2hogosha/create/', 'App\Http\Controllers\HogoshaController@u2hcreate');
    Route::post('/user2hogosha/delete/', 'App\Http\Controllers\HogoshaController@u2hdelete');

    Route::get('/supporter/list', 'App\Http\Controllers\SupporterController@list')->name('supporter-list');
    Route::get('/supporter/edit/', 'App\Http\Controllers\SupporterController@edit');
    Route::post('/supporter/create/', 'App\Http\Controllers\SupporterController@create');
    Route::post('/supporter/update/', 'App\Http\Controllers\SupporterController@update');
    Route::post('/supporter/delete/', 'App\Http\Controllers\SupporterController@delete');

    Route::get('/user2suppo/list/', 'App\Http\Controllers\SupporterController@u2slist')->name('u2s-list');
    Route::get('/user2suppo/edit/', 'App\Http\Controllers\SupporterController@u2sedit')->name('u2s-edit');
    Route::post('/user2suppo/create/', 'App\Http\Controllers\SupporterController@u2screate');
    Route::post('/user2suppo/delete/', 'App\Http\Controllers\SupporterController@u2sdelete');

    /* エルコイン */
    Route::get('/lc/add/', 'App\Http\Controllers\LCoinController@add')->name('lcAdd');
    Route::get('/lc/addnoab/', 'App\Http\Controllers\LCoinController@addnoab');
    Route::get('/lc/list/', 'App\Http\Controllers\LCoinController@list')->name('lcList');
    Route::post('/lc/add/', 'App\Http\Controllers\LCoinController@addpost');
    Route::post('/lc/addnoab/', 'App\Http\Controllers\LCoinController@addpostnoab');//エルコイン単独で登録する画面（欠席情報(ab)との紐づけなし）
    Route::post('/lc/delete/', 'App\Http\Controllers\LCoinController@deletepost');

    Route::get('/lcziyuu/add/','App\Http\Controllers\LCZiyuuController@add')->name('lcziyuu-add');
    Route::post('/lcziyuu/create','App\Http\Controllers\LCZiyuuController@create');
    Route::post('/lcziyuu/edit','App\Http\Controllers\LCZiyuuController@edit');
    Route::post('/lcziyuu/delete','App\Http\Controllers\LCZiyuuController@delete');

    /* CLOVA */
    Route::get('/conv/', 'App\Http\Controllers\ConvController@index')->name('conv-index');
    Route::get('/conv/detail/', 'App\Http\Controllers\ConvController@detail')->name('convDetail');
    Route::post('/conv/detail/', 'App\Http\Controllers\ConvController@filter');
    Route::get('/conv/editMeisai/', 'App\Http\Controllers\ConvController@editMeisai')->name('editMeisai');
    Route::post('/conv/updateMeisai/', 'App\Http\Controllers\ConvController@updateMeisai');
    Route::post('/conv/replace/', 'App\Http\Controllers\ConvController@replace');
    Route::get('/conv/upload/', 'App\Http\Controllers\ConvController@upload')->name('conv-upload');
    Route::post('/conv/confirm/', 'App\Http\Controllers\ConvController@confirm');
    Route::post('/conv/upload/', 'App\Http\Controllers\ConvController@uploadpost');
    /*発表動画*/
    // Route::get('/mv/presen/all/', 'App\Http\Controllers\MVController@index_admin')->name('mvpresen-all');
    Route::get('/mv/presen/list/', 'App\Http\Controllers\MVController@list')->name('mvpresen-list');
    // Route::get('/mv/presen/add/', 'App\Http\Controllers\MVController@add')->name('mvpresen-add');
    Route::get('/mv/presen/edit/', 'App\Http\Controllers\MVController@edit');
    Route::get('/mv/presen/index_student/', 'App\Http\Controllers\MVController@index_student');//必ずstudentCdを渡す
    Route::post('/mv/presen/confirm/', 'App\Http\Controllers\MVController@confirm');
    Route::post('/mv/presen/create/', 'App\Http\Controllers\MVController@create');
    Route::post('/mv/presen/update/', 'App\Http\Controllers\MVController@update');
    Route::post('/mv/presen/delete/', 'App\Http\Controllers\MVController@delete');
    /* サインイン履歴 */
    Route::get('/signinhistory/index/','App\Http\Controllers\SigninHistoryController@index');
    /* フォトギャラリー */
    Route::get('/photos/index/', 'App\Http\Controllers\GooglePhotoController@index')->name('gphoto-index');
    /* 欠席情報 */
    Route::get('/absence/list_sp', 'App\Http\Controllers\AbsenceController@list_sp')->name('absenceList-sp');
    Route::get('/absence/list', 'App\Http\Controllers\AbsenceController@list_hogosha')->name('absenceList-hogosha');
    Route::get('/absence/add', 'App\Http\Controllers\AbsenceController@regist')->name('absenceAdd');
    Route::post('/absence/edit', 'App\Http\Controllers\AbsenceController@edit');
    Route::post('/absence/delete', 'App\Http\Controllers\AbsenceController@delete');
    Route::post('/absence/add', 'App\Http\Controllers\AbsenceController@add');
    /* コース・プラン */
    Route::get('/cp/add/', 'App\Http\Controllers\CoursePlanController@add')->name('cpadd');
    Route::post('/cp/add/', 'App\Http\Controllers\CoursePlanController@addpost');
    Route::get('/cp/detail/', 'App\Http\Controllers\CoursePlanController@detail')->name('cpdetail');

    /* 各種レポート */
    Route::get('/reports/index/','App\Http\Controllers\ReportController@index')->name('report-index');
    Route::get('/reports/notificationLogs/','App\Http\Controllers\ReportController@notificationLogs')->name('report-nl');

});

/*LINEログイン関連*/
// Route::get('/line/callback','App\Http\Controllers\LINELoginController@callback');
//ログイン画面＞callback＞user_idがusersに紐づいているとき 
Route::get('/line/attemptLogin/', 'App\Http\Controllers\LINELoginController@attemptLogin');//まだログインしていないのでここ
//ログイン画面＞callback＞user_idがusersに紐づいていないとき 
Route::get('/line/selectregistration','App\Http\Controllers\LINELoginController@selectRegistration');
//設定画面＞callback＞
Route::get('/line/binding/', 'App\Http\Controllers\LINELoginController@binding')->name('line-binding');




#DEBUG用
// Route::get('/mail/test/manabiail/','App\Http\Controllers\SettingsController@sendmailtest')->middleware('auth');
// Route::get('/line-push/','App\Http\Controllers\SettingsController@linePushtest');
// Route::get('/mail/test/manabiail/','App\Http\Controllers\SettingsController@sendmailtest');
