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

    Route::get('/hogosha/add/{HogoshaCd?}', 'App\Http\Controllers\HogoshaController@add')->name('hogosha-add');
    Route::post('/hogosha/add/', 'App\Http\Controllers\HogoshaController@create');
    Route::post('/hogosha/edit/', 'App\Http\Controllers\HogoshaController@edit');
    Route::post('/hogosha/delete/', 'App\Http\Controllers\HogoshaController@delete');

    Route::get('/student/add/', 'App\Http\Controllers\StudentController@add')->name('student-add');
    Route::post('/student/add/', 'App\Http\Controllers\StudentController@create');
    Route::post('/student/edit/', 'App\Http\Controllers\StudentController@edit');
    Route::post('/student/delete/', 'App\Http\Controllers\StudentController@delete');

    Route::get('/user2hogosha/add/', 'App\Http\Controllers\HogoshaController@u2hadd')->name('u2h-add');
    Route::post('/user2hogosha/add/', 'App\Http\Controllers\HogoshaController@u2hcreate');
    Route::get('/user2hogosha/delete/', 'App\Http\Controllers\HogoshaController@u2hdelete');

    Route::get('/supporter/add/', 'App\Http\Controllers\SupporterController@add')->name('supporter-add');
    Route::post('/supporter/add/', 'App\Http\Controllers\SupporterController@create');
    Route::post('/supporter/edit/', 'App\Http\Controllers\SupporterController@edit');
    Route::post('/supporter/delete/', 'App\Http\Controllers\SupporterController@delete');

    Route::get('/user2suppo/add/', 'App\Http\Controllers\SupporterController@u2sadd')->name('u2s-add');
    Route::post('/user2suppo/add/', 'App\Http\Controllers\SupporterController@u2screate');
    Route::get('/user2suppo/delete/', 'App\Http\Controllers\SupporterController@u2sdelete');

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
    Route::get('/mv/presen/all/', 'App\Http\Controllers\MVController@index_admin')->name('mvpresen-all');
    Route::get('/mv/presen/add/', 'App\Http\Controllers\MVController@add')->name('mvpresen-add');
    Route::post('/mv/presen/confirm/', 'App\Http\Controllers\MVController@confirm');
    Route::post('/mv/presen/create/', 'App\Http\Controllers\MVController@create');
    Route::post('/mv/presen/edit/', 'App\Http\Controllers\MVController@edit');
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




// /*共通ページ*/
// Route::get('/settings/', 'App\Http\Controllers\SettingsController@settings')->middleware('auth');//
// Route::post('/settings/edit/', 'App\Http\Controllers\SettingsController@edit')->middleware('auth');//

// /*保護者が参照するページ*/
// Route::get('/mypage/', 'App\Http\Controllers\HogoshaController@mypage')->middleware('auth')->middleware(SessionControll::class)->name('mypage');
// Route::get('/fb/detail/{fbNo}', 'App\Http\Controllers\FBController@fbDetail')->middleware('auth')->middleware(SessionControll::class);
// Route::get('/fb/', 'App\Http\Controllers\FBController@index')->middleware('auth')->middleware(SessionControll::class);
// Route::get('/lc/', 'App\Http\Controllers\LCoinController@index')->middleware('auth')->middleware(SessionControll::class);
// // Route::post('/hogosha/edit/', 'App\Http\Controllers\HogoshaController@edit')->middleware('auth')->middleware(SessionControll::class);

// /*サポーターが参照するページ*/
// Route::get('/supporter-page/','App\Http\Controllers\SupporterController@index')->middleware(SessionControll::class)->name('supporter-page');
// Route::get('/fb/index_sp', 'App\Http\Controllers\FBController@index_sp')->middleware('auth')->middleware(SessionControll::class);
// Route::get('/fb/add/', 'App\Http\Controllers\FBController@add')->middleware('auth')->middleware(SessionControll::class);
// Route::post('/fb/add/', 'App\Http\Controllers\FBController@addpost')->middleware('auth')->middleware(SessionControll::class);
// Route::get('/fb/edit/{fbNo}', 'App\Http\Controllers\FBController@edit')->middleware('auth')->middleware(SessionControll::class);
// Route::post('/fb/edit/{fbNo}', 'App\Http\Controllers\FBController@editpost')->middleware('auth')->middleware(SessionControll::class);

// /*権限レベルが高いサポーターが参照するページ*/
// Route::get('/sysad/', 'App\Http\Controllers\SysAdController@index');

// Route::get('/hogosha/add/', 'App\Http\Controllers\HogoshaController@add');
// Route::post('/hogosha/add/', 'App\Http\Controllers\HogoshaController@create');

// Route::get('/student/add/', 'App\Http\Controllers\StudentController@add');
// Route::post('/student/add/', 'App\Http\Controllers\StudentController@create');

// Route::get('/user2hogosha/add/', 'App\Http\Controllers\HogoshaController@u2hadd');
// Route::post('/user2hogosha/add/', 'App\Http\Controllers\HogoshaController@u2hcreate');

// Route::get('/lc/regist/', 'App\Http\Controllers\LCoinController@regist');
// Route::post('/lc/regist/', 'App\Http\Controllers\LCoinController@registpost');


// // Route::get('/fb/list/{id?}', 'App\Http\Controllers\FBController@list');

// // Route::get('/helloworld/{addTxt}', function ($addTxt) {
// //     $arg = [addTxt ->$addTxt];
// //     return view('helloworld',$arg);
// // });
// #DEBUG用
// Route::get('/mail/test/manabiail/','App\Http\Controllers\SettingsController@sendmailtest');
