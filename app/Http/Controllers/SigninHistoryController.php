<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SigninHistory;

class SigninHistoryController extends Controller
{
    //

    public function index(Request $request){

        //直近200件の履歴を取得する
        $items =  SigninHistory::getLastXXHistory(200);

        $args = [
            'items' => $items,
        ];

        return view('Signinhistory.index',$args);
    }
}
