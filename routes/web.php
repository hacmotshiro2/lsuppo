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
Route::get('/mypage/{id?}', 'App\Http\Controllers\HogoshaController@mypage')->middleware('auth');

Route::get('/supporter-page/{id?}','App\Http\Controllers\SupporterController@index');

Route::get('/fb/regist/{id?}', 'App\Http\Controllers\FBController@regist');
Route::post('/fb/regist/{id?}', 'App\Http\Controllers\FBController@registpost');
Route::get('/fb/detail/{fbNo}', 'App\Http\Controllers\FBController@fbDetail')->middleware('auth');
Route::get('/fb/{id?}', 'App\Http\Controllers\FBController@index')->middleware('auth');
Route::post('/fb/{id?}', 'App\Http\Controllers\FBController@post')->middleware('auth');

Route::get('/sysad/', 'App\Http\Controllers\SysAdController@index');

Route::get('/hogosha/add/', 'App\Http\Controllers\HogoshaController@add');
Route::post('/hogosha/add/', 'App\Http\Controllers\HogoshaController@create');

Route::get('/lc/{id?}', 'App\Http\Controllers\LCoinController@index')->middleware('auth');


// Route::get('/fb/list/{id?}', 'App\Http\Controllers\FBController@list');

// Route::get('/helloworld/{addTxt}', function ($addTxt) {
//     $arg = [addTxt ->$addTxt];
//     return view('helloworld',$arg);
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
