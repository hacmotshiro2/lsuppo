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

use App\Notifications\User2HogoshaRegisteredNotification;

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

        //リダイレクト時には、セッションにalertが入ってくる可能性があるので拾う
        $alertComp='';
        if($request->session()->has('alertComp')){
            $alertComp = $request->session()->get('alertComp');
        }
        $alertErr='';
        if($request->session()->has('alertErr')){
            $alertErr = $request->session()->get('alertErr');
        }
        
        $arg=[
            'items'=>$items,
            'alertComp'=>$alertComp,
            'alertErr'=>$alertErr,
        ];

        return view('Hogosha.add',$arg);

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

        $hogosha->setUpdateColumn();

        $hogosha->save();

        

        //登録後の再取得
        $args=[
        ];

        return redirect()->route('hogosha-add',$args)->with('alertComp',MessageConst::ADD_COMPLETED);


    }
    //user2保護者登録画面へ /user2hogosha/add/
    public function u2hadd(Request $request, Response $response){
        
        $items = User2Hogosha::getu2hData();

        $itemsHogosha = Hogosha::all();
        //リダイレクト時には、セッションにalertが入ってくる可能性があるので拾う
        $alertComp='';
        if($request->session()->has('alertComp')){
            $alertComp = $request->session()->get('alertComp');
        }
        $alertErr='';
        if($request->session()->has('alertErr')){
            $alertErr = $request->session()->get('alertErr');
        }
        
        $args=[
            'items'=>$items,
            'itemsHogosha' =>$itemsHogosha,
            'alertComp'=>$alertComp,
            'alertErr'=>$alertErr,
        ];

        return view('user2hogosha.add',$args);

    }
    //user2保護者登録画面のPOST
    public function u2hcreate(Request $request){
        $this->validate($request, User2Hogosha::$rules);
        $u2h = new User2Hogosha;
        $form = $request->all();
        unset($form['_token']);
        $u2h->fill($form);


        $u2h->save();

        //紐づけが完了したメールを送る
        //管理者が登録するので、ログインユーザーではなく、いま登録したユーザーに対して送る
        $user = User::find($u2h->user_id);
        if(!is_null($user)){
            $user->notify(new User2HogoshaRegisteredNotification($user->name));
        }

        $args=[
        ];

        return redirect()->route('u2h-add',$args)->with('alertComp',MessageConst::ADD_COMPLETED);

    }

}
