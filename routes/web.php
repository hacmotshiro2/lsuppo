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
    Route::get('/settings/', 'App\Http\Controllers\SettingsController@settings');
    Route::post('/settings/edit/', 'App\Http\Controllers\SettingsController@edit');

    /*保護者が参照するページ*/
    Route::get('/mypage/', 'App\Http\Controllers\HogoshaController@mypage')->name('mypage');
    Route::get('/fb/detail/', 'App\Http\Controllers\FBController@fbDetail')->name('fbDetail');
    Route::get('/fb/', 'App\Http\Controllers\FBController@index');
    Route::get('/lc/', 'App\Http\Controllers\LCoinController@index');

    /*サポーターが参照するページ*/
    Route::get('/supporter-page/','App\Http\Controllers\SupporterController@index')->name('supporter-page');
    Route::get('/fb/index_sp', 'App\Http\Controllers\FBController@index_sp');
    Route::get('/fb/add/', 'App\Http\Controllers\FBController@add')->name('fbAdd');
    Route::post('/fb/add/', 'App\Http\Controllers\FBController@addpost');
    Route::get('/fb/edit/', 'App\Http\Controllers\FBController@edit')->name('fbEdit');
    Route::post('/fb/edit/', 'App\Http\Controllers\FBController@editpost');

    /*権限レベルが高いサポーターが参照するページ*/
    Route::get('/sysad/', 'App\Http\Controllers\SysAdController@index');

    Route::post('/fb/approve/', 'App\Http\Controllers\FBController@approve');
    Route::post('/fb/decline/', 'App\Http\Controllers\FBController@decline');

    Route::get('/hogosha/add/', 'App\Http\Controllers\HogoshaController@add')->name('hogosha-add');
    Route::post('/hogosha/add/', 'App\Http\Controllers\HogoshaController@create');

    Route::get('/student/add/', 'App\Http\Controllers\StudentController@add')->name('student-add');
    Route::post('/student/add/', 'App\Http\Controllers\StudentController@create');

    Route::get('/user2hogosha/add/', 'App\Http\Controllers\HogoshaController@u2hadd')->name('u2h-add');
    Route::post('/user2hogosha/add/', 'App\Http\Controllers\HogoshaController@u2hcreate');

    Route::get('/supporter/add/', 'App\Http\Controllers\SupporterController@add')->name('supporter-add');
    Route::post('/supporter/add/', 'App\Http\Controllers\SupporterController@create');

    Route::get('/user2suppo/add/', 'App\Http\Controllers\SupporterController@u2sadd')->name('u2s-add');
    Route::post('/user2suppo/add/', 'App\Http\Controllers\SupporterController@u2screate');

    Route::get('/lc/add/', 'App\Http\Controllers\LCoinController@add')->name('lcAdd');
    Route::get('/lc/list/', 'App\Http\Controllers\LCoinController@list')->name('lcList');
    Route::post('/lc/add/', 'App\Http\Controllers\LCoinController@addpost');
    Route::post('/lc/delete/', 'App\Http\Controllers\LCoinController@deletepost');


});

    #DEBUG用
    Route::get('/mail/test/manabiail/','App\Http\Controllers\SettingsController@sendmailtest')->middleware('auth');


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
