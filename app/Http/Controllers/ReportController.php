<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    //各種レポート機能を呼び出すコントローラ
    //基本的にはLivewireで作成するため、DBアクセス処理はLivewireに書かれる

    //メニュー
    public function index(){

        return view('reports.index');
    }
    //通知履歴一覧
    public function notificationLogs(){

        return view('reports.notificationlogs');
    }
}
