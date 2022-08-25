<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;



class SupporterController extends Controller
{
    //サポーターページ
    public function index(Request $request){
    
        Gate::authorize('supporter');

        return view('Supporter.mypage');
    }
}
