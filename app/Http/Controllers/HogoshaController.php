<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Models\Hogosha;
use App\Models\User2Hogosha;
use Illuminate\Support\Facades\Auth;

use App\Consts\MessageConst;
use App\Consts\AuthConst;


class HogoshaController extends Controller
{
  
    

    /*保護者用画面*/
    //マイページ　get
    public function mypage(Request $request){
        $args=[];

        //保護者かどうかのチェック
        Gate::authorize('hogosha');

        //m_hogoshaが紐づけがない場合には、informationを表示
        if(Gate::allows('hogosha-nobind')){
            $args=['alertInfo'=>MessageConst::NOT_BINDED,];
        }

        return view('Hogosha.mypage',$args);
    }
   
    
    
    /*システム管理者が使用する画面*/
    //保護者登録画面へ
    public function add(Request $request, Response $response){
        $items = Hogosha::all();


        $arg=[
            'items'=>$items,
        ];

        return view('hogosha.add',$arg);

    }
    //保護者登録画面のPOST
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
    //user2保護者登録画面へ /user2hogosha/add/
    public function u2hadd(Request $request, Response $response){
        
        $items = $this->getu2hData();

        $itemsHogosha = Hogosha::all();

        $arg=[
            'items'=>$items,
            'itemsHogosha' =>$itemsHogosha,
        ];

        return view('user2hogosha.add',$arg);

    }
    //保護者登録画面のPOST
    public function u2hcreate(Request $request){
        $this->validate($request, User2Hogosha::$rules);
        $u2h = new User2Hogosha;
        $form = $request->all();
        unset($form['_token']);
        $u2h->fill($form);


        $u2h->save();

        

        //登録後の再取得
        $items = $this->getu2hData();

        $itemsHogosha = Hogosha::all();

        $arg=[
            'items'=>$items,
            'itemsHogosha' =>$itemsHogosha,
        ];

        return redirect('user2hogosha.add',302,$arg);

    }
    private function getu2hData(){
        return DB::select("
        select 
        u.id
        ,u.name
        ,u.email
        ,u.userType
        ,u.StudentName
        ,u2h.user_id
        ,u2h.HogoshaCd
        from users u
        left outer join user2hogosha u2h
        on u2h.user_id = u.id
        "
        );

    }
}
