<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

use App\Consts\MessageConst;

use App\Models\User;
use App\Models\Supporter;
use App\Models\User2Supporter;
use App\Models\LR;

use App\Notifications\User2SupporterRegisteredNotification;

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

    /*システム管理者が使用する画面*/
    //サポーター登録画面へ
    public function add(Request $request){
        $mode = 'add';
        $item = new Supporter;

        //クエリ文字列にSupporterCdがついている場合は、編集モードで開く
        if(isset($request->SupporterCd)){
            $item = Supporter::where('SupporterCd',$request->SupporterCd)->first();
            $mode = 'edit';
        }

        $items = Supporter::all();
        $lrs = LR::all();

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
            'mode'=>$mode,
            'item'=>$item,
            'items'=>$items,
            'lrs' =>$lrs,
            'alertComp'=>$alertComp,
            'alertErr'=>$alertErr,
        ];

        return view('Supporter.add',$arg);

    }
    //サポーター登録画面のPOST
    public function create(Request $request){
        $this->validate($request, Supporter::$rules);
        $supporter = new Supporter;
        $form = $request->all();
        unset($form['_token']);
        unset($form['create']);
        $supporter->fill($form);

        // //checkboxはそのままだと登録できないので
        // $supporter->IsLocked = ISSET($form->IsLocked)?1:0;
        // $supporter->IsNeedPWChange = ISSET($form->IsNeedPWChange)?1:0;
        // この項目は使っていない
        $supporter->IsLocked = 0;
        $supporter->IsNeedPWChange = 0;

        //フォームにない項目をセット
        $supporter->setUpdateColumn();

        $supporter->save();

        //登録後の再取得
        $args=[
        ];

        return redirect()->route('supporter-add',$args)->with('alertComp',MessageConst::ADD_COMPLETED);

    }
    public function edit(Request $request){
        $this->validate($request, Supporter::$rules);
        $supporter = Supporter::where('SupporterCd',$request->SupporterCd)->first();
        $form = $request->all();
        unset($form['_token']);
        unset($form['create']);
        $supporter->fill($form);

        // //checkboxはそのままだと登録できないので
        // $supporter->IsLocked = ISSET($form->IsLocked)?1:0;
        // $supporter->IsNeedPWChange = ISSET($form->IsNeedPWChange)?1:0;
        // この項目は使っていない
        $supporter->IsLocked = 0;
        $supporter->IsNeedPWChange = 0;

        //フォームにない項目をセット
        $supporter->setUpdateColumn();

        $supporter->save();

        //登録後の再取得
        $args=[
        ];

        return redirect()->route('supporter-add',$args)->with('alertComp',MessageConst::EDIT_COMPLETED);

    }
    public function delete(Request $request){

    }
    //user2サポーター登録画面へ /user2suppo/add/
    public function u2sadd(Request $request, Response $response){
    
        $items = User2Supporter::getu2sData();

        $itemsSupporter = Supporter::all();

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
            'itemsSupporter' =>$itemsSupporter,
            'alertComp'=>$alertComp,
            'alertErr'=>$alertErr,
        ];
        return view('user2suppo.add',$args);

    }
    //user2サポーター登録画面のPOST
    public function u2screate(Request $request){
        $this->validate($request, User2Supporter::$rules);
        $u2s = new User2Supporter;
        $form = $request->all();
        unset($form['_token']);
        $u2s->fill($form);


        $u2s->save();

        //紐づけが完了したメールを送る
        //管理者が登録するので、ログインユーザーではなく、いま登録したユーザーに対して送る
        $user = User::find($u2s->user_id);
        if(!is_null($user)){
            $user->notify(new User2SupporterRegisteredNotification($user->name));
        }

        $args=[
        ];

        return redirect()->route('u2s-add',$args)->with('alertComp',MessageConst::ADD_COMPLETED);

    }
    //
    public function u2sdelete(Request $request){
        $u2s_id = $request->u2s_id;

        $u2s = User2Supporter::find($u2s_id);
        $u2s->delete();

        $args=[
        ];
        return redirect()->route('u2s-add',$args)->with('alertComp',MessageConst::DELETE_COMPLETED);
    }
    
}
