<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

use App\Consts\MessageConst;


class SupporterController extends Controller
{
    //サポーターページ
    public function index(Request $request){
    
        //サポーターかどうかのチェック
        Gate::authorize('supporter');

       //m_hogoshaが紐づけがない場合には、informationを表示
       $args=[];
       if(Gate::allows('supporter-nobind')){
            $args=['alertInfo'=>MessageConst::NOT_BINDED,];
        }        
        return view('Supporter.mypage',$args);
    }
}
