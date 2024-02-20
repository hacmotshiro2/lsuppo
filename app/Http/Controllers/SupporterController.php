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

use App\Http\Requests\SupporterRequest;
use App\Http\Requests\User2SupporterRequest;

class SupporterController extends Controller
{
    //サポーターマイページ
    public function index(Request $request){
    
        //サポーターかどうかのチェック
        Gate::authorize('supporter');

       //m_supporterが紐づけがない場合には、informationを表示
       $args=[];
       if(Gate::allows('supporter-nobind')){
            $args=['alertInfo'=>MessageConst::NOT_BINDED,];
        }        
        return view('Supporter.mypage',$args);
    }

    /*システム管理者が使用する画面*/

    //GET マスタ一覧画面へ
    public function list(Request $request){
        
        $args=[
        ];

        return view('Supporter.list',$args)->with(parent::getAlertSessions());

    }
    //GET マスタ編集画面へ
    public function edit(Request $request){
        $mode = 'create';

        //supporterCdがあれば、編集モード、なければ新規モード
        if($request->has('supporterCd')){
            $mode='update';
        }
        
        $args=[
            'mode'=>$mode,
            'createAction' =>"/supporter/create",
            'updateAction' =>"/supporter/update",
            'deleteAction' =>"/supporter/delete",
            'backURL'=>"/supporter/list/",
        ];

        return view('Supporter.edit',$args)->with(parent::getAlertSessions());

    }
    
    //POST Create処理
    public function create(SupporterRequest $request){
        // $this->validate($request, Supporter::$rules_create);
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

        return redirect()->route('supporter-list',$args)->with('alertComp',MessageConst::ADD_COMPLETED);

    }
    // POST Update処理
    public function update(SupporterRequest $request){
        // $this->validate($request, Supporter::$rules_edit);
        $supporter = Supporter::find($request->SupporterCd);
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

        return redirect()->route('supporter-list',$args)->with('alertComp',MessageConst::EDIT_COMPLETED);

    }
    // POST Delete処理
    public function delete(Request $request){

        $supporter = Supporter::find($request->SupporterCd);

        $supporter->delete();

        //登録後の再取得
        $args=[
        ];

        return redirect()->route('supporter-list',$args)->with('alertComp',MessageConst::DELETE_COMPLETED);
    }

    /* ここからUser2Hogosha */
    
    //user2サポーター登録第一画面へ /user2suppo/list/
    public function u2slist(Request $request){

        $args=[
        ];

        return view('user2suppo.list',$args)->with(parent::getAlertSessions());

    }
    //user2サポーター登録第二画面へ /user2suppo/edit/ GET
    public function u2sedit(Request $request){
        $mode = 'create';

        //u2h_idがあれば、編集モード、なければ新規モード
        if($request->has('u2s_id')){
            //当マスタは編集モード非対応のため
            $mode='delete';
        }
        
        $args=[
            'mode'=>$mode,
            'createAction' =>"/user2suppo/create",
            'updateAction' =>"",
            'deleteAction' =>"/user2suppo/delete",
            'backURL'=>"/user2suppo/list/",
        ];

        return view('user2suppo.edit',$args)->with(parent::getAlertSessions());
    }
    //user2サポーター登録画面のPOST
    public function u2screate(User2SupporterRequest $request){
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

        return redirect()->route('u2s-list',$args)->with('alertComp',MessageConst::ADD_COMPLETED);

    }
    //user2サポーター削除のPOST
    public function u2sdelete(Request $request){
        $u2s_id = $request->u2s_id;

        $u2s = User2Supporter::find($u2s_id);
        if($u2s){
            $u2s->delete();
        }

        $args=[
        ];

        return redirect()->route('u2s-list',$args)
        ->with('alertComp',MessageConst::DELETE_COMPLETED);
    }

}
