<?php

use Illuminate\Support\Facades\Route;

// app\Http\Controllers\;

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

/*保護者が参照するページ*/
Route::get('/mypage', 'App\Http\Controllers\HogoshaController@mypage')->middleware('auth');
Route::get('/fb/detail/{fbNo}', 'App\Http\Controllers\FBController@fbDetail')->middleware('auth');
Route::get('/fb/', 'App\Http\Controllers\FBController@index')->middleware('auth');
Route::get('/lc/', 'App\Http\Controllers\LCoinController@index')->middleware('auth');


/*サポーターが参照するページ*/
Route::get('/supporter-page/{id?}','App\Http\Controllers\SupporterController@index');
Route::get('/fb/regist/', 'App\Http\Controllers\FBController@regist');
Route::post('/fb/regist/', 'App\Http\Controllers\FBController@registpost');


/*システム主管者が参照するページ*/
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

