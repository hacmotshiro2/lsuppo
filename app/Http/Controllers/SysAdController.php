<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use App\Models\LR;
use App\Models\Student;
use App\Models\Supporter;


class SysAdController extends Controller
{
    //
    public function index(Request $request, Response $response){
        $user = Auth::user();
        $userName = IsSet($user)?$user->name:"システム管理者";
        $arg=[
            'userName'=>$userName,
        ];
        return view('SysAdmin.index',$arg);
    }

   

}
