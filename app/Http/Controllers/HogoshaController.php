<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Hogosha;
use Illuminate\Support\Facades\Auth;

use App\Consts\SessionConst;


class HogoshaController extends Controller
{
    /*保護者用画面*/
    //セッションの取得
    public function ses_get(Request $request){
        $sesdata = $request->session()->get(SessionConst::SESKEY_ID);
        return view ();#TODO
    }
    public function ses_set(Request $request){
        return redirect('');#TODO
    }
    //マイページ
    public function mypage(Request $request, Response $response, $id='no name'){
        
        $user = Auth::user();
        if(!is_null($user)){
            $id = is_null($user->name)?'':$user->name;
        }
        
        $arg = [
            'id'=>$id,
            'msg'=>'',
            'user'=>$user,
        ];
        return view('Hogosha.mypage',$arg);
    }

    /*システム管理者が使用する画面*/
    //登録画面へ
    public function add(Request $request, Response $response){
        $items = Hogosha::all();
        $arg=[
            'items'=>$items,
        ];

        return view('hogosha.add',$arg);

    }
    //登録画面のPOST
    public function create(Request $request){
        $this->validate($request, Hogosha::$rules);
        $hogosha = new Hogosha;
        $form = $request->all();
        unset($form['_token']);
        $hogosha->fill($form);

        //checkboxはそのままだと登録できないので
        $hogosha->IsLocked = ISSET($form->IsLocked)?1:0;
        $hogosha->IsNeedPWChange = ISSET($form->IsNeedPWChange)?1:0;

        //フォームにない項目をセット
        $hogosha->UpdateDatetime = date("Y-m-d H:i:s");
        $hogosha->UpdateGamen = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $hogosha->UpdateSystem = "lsuppo";

        $hogosha->save();

        

        //登録後の再取得
        $items = Hogosha::all();
        $arg=[
            'items'=>$items,
        ];

        // return redirect('hogosha-add',$arg);
        return view('hogosha.add',$arg);

    }
}
