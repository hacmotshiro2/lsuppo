<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    //各種レポート機能を呼び出すコントローラ
    //基本的にはLivewireで作成するため、DBアクセス処理はLivewireに書かれる

    public function notificationLogs(){

        return view('reports.notificationlogs');
    }
}
