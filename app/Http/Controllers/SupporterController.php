<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class SupporterController extends Controller
{
    public function index(Request $request, Response $response, $id='no name'){
    
        $arg = [
            'userName'=>'・・・',
            'msg'=>'',
        ];

        return view('Supporter.index',$arg);
    }
}
