<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// No. h.hashimoto 2022/08/26 ------>
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Consts\AuthConst;
// <------  No. h.hashimoto 2022/08/26 

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    // No. h.hashimoto 2022/08/26 ------>
    //　'/'にアクセスしたときに、ログイン状況やユーザータイプによりリダイレクト
    public function mypage(Request $request, Response $response){
        $user = Auth::user();

        if(is_null($user)){ 
            return redirect()->route('mypage')->withInput();
        }
        switch($user->userType){ 
            case AuthConst::USER_TYPE_HOGOSHA:
                return redirect()->route('mypage')->withInput();
                break;
            case AuthConst::USER_TYPE_SUPPORTER:
                return redirect()->route('supporter-page')->withInput();
                break;
            default:
                return abort(500);
                break;
        }

    }
    // <------  No. h.hashimoto 2022/08/26 
}
