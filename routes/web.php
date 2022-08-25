<?php

use Illuminate\Support\Facades\Route;

// app\Http\Controllers\;
use App\Http\Middleware\ControlSettings;
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

Route::get('/', function () {
    return view('debug');
    // return view('helloworld');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/error',function(){
    return view('error');
});

/*共通ページ*/
Route::get('/settings/', 'App\Http\Controllers\SettingsController@settings')->middleware('auth')->middleware(ControlSettings::class);//HogoshaControllerにするのはおかしい

/*保護者が参照するページ*/
Route::get('/mypage/', 'App\Http\Controllers\HogoshaController@mypage')->middleware('auth')->middleware(SessionControll::class);
Route::get('/fb/detail/{fbNo}', 'App\Http\Controllers\FBController@fbDetail')->middleware('auth')->middleware(SessionControll::class);
Route::get('/fb/', 'App\Http\Controllers\FBController@index')->middleware('auth')->middleware(SessionControll::class);
Route::get('/lc/', 'App\Http\Controllers\LCoinController@index')->middleware('auth')->middleware(SessionControll::class);
Route::post('/hogosha/edit/', 'App\Http\Controllers\HogoshaController@edit')->middleware('auth')->middleware(SessionControll::class);

/*サポーターが参照するページ*/
Route::get('/supporter-page/','App\Http\Controllers\SupporterController@index')->middleware(SessionControll::class);
Route::get('/fb/index_sp', 'App\Http\Controllers\FBController@index_sp')->middleware('auth')->middleware(SessionControll::class);
Route::get('/fb/add/', 'App\Http\Controllers\FBController@add')->middleware('auth')->middleware(SessionControll::class);
Route::post('/fb/add/', 'App\Http\Controllers\FBController@addpost')->middleware('auth')->middleware(SessionControll::class);
Route::get('/fb/edit/{fbNo}', 'App\Http\Controllers\FBController@edit')->middleware('auth')->middleware(SessionControll::class);
Route::post('/fb/edit/{fbNo}', 'App\Http\Controllers\FBController@editpost')->middleware('auth')->middleware(SessionControll::class);

/*権限レベルが高いサポーターが参照するページ*/
Route::get('/sysad/', 'App\Http\Controllers\SysAdController@index');

Route::get('/hogosha/add/', 'App\Http\Controllers\HogoshaController@add');
Route::post('/hogosha/add/', 'App\Http\Controllers\HogoshaController@create');

Route::get('/student/add/', 'App\Http\Controllers\StudentController@add');
Route::post('/student/add/', 'App\Http\Controllers\StudentController@create');

Route::get('/user2hogosha/add/', 'App\Http\Controllers\HogoshaController@u2hadd');
Route::post('/user2hogosha/add/', 'App\Http\Controllers\HogoshaController@u2hcreate');

Route::get('/lc/regist/', 'App\Http\Controllers\LCoinController@regist');
Route::post('/lc/regist/', 'App\Http\Controllers\LCoinController@registpost');


// Route::get('/fb/list/{id?}', 'App\Http\Controllers\FBController@list');

// Route::get('/helloworld/{addTxt}', function ($addTxt) {
//     $arg = [addTxt ->$addTxt];
//     return view('helloworld',$arg);
// });

