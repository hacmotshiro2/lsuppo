<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Hogosha;
use App\Models\User2Hogosha;
use Illuminate\Support\Facades\Auth;

use App\Consts\MessageConst;
use App\Consts\AuthConst;
use App\Consts\SessionConst;

class MyPageController extends Controller
{
    //

 
    //設定ページ
    public function settings(Request $request){
        return view('Hogosha.settings');
    }

  

}
