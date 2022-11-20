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
Route::post('/getlrs','App\Http\Controllers\StudentController@getLRs');
Route::post('/getstudents','App\Http\Controllers\StudentController@getStudents');
