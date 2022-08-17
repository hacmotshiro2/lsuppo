<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\LCoinMeisai;
class LCoinController extends Controller
{
    //
    public function index(Request $request, Response $response, $id='no name'){

        $items=LCoinMeisai::all();

        //残高計算
        #TODO
        $lczandaka=100;

        $arg = [
            'id'=>$id,
            'msg'=>'',
            'lczandaka'=>$lczandaka,
            'items' => $items,
        ];

        return view('LCoin.index',$arg);

    }
}
