<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Models\Hogosha;
use App\Models\User2Hogosha;
use App\Models\LR;
use App\Models\FB;
use Illuminate\Support\Facades\Auth;
use App\Models\Absence as AbModel;
use App\Models\CoursePlan;

use App\Consts\MessageConst;
use App\Consts\AuthConst;

use App\Notifications\User2HogoshaRegisteredNotification;

use App\Http\Requests\User2HogoshaRequest;

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
        // 紐づけがされている場合には未読件数の表示
        else{
            //認証情報を取得し、保護者コードを取得する
            $user = Auth::user();
            $hogoshaCd = Hogosha::getHogoshaCd($user);

            //フィードバック未読件数の取得
            $unreads = FB::getFBUnreadCountByHogoshaCd($hogoshaCd);

            //未振替件数の取得
            $unabsences = AbModel::getUnAbsenceCountByHogoshaCd($hogoshaCd);

            //コース・プラン情報の取得
            $cps = CoursePlan::getCoursePlansByHogoshaCd($hogoshaCd);

            $args=[
                'unreads' => $unreads,
                'unabsences' => $unabsences,
                'courseplans' => $cps,
            ];
        }

        return view('Hogosha.mypage',$args);
    }
   
    
    
    /*システム管理者が使用する画面*/
    //保護者登録画面へ
    public function add(Request $request){
        $mode = 'add';
        $item = new Hogosha;

        //クエリ文字列にHogoshaCdがついている場合は、編集モードで開く
        if(isset($request->HogoshaCd)){
            $item = Hogosha::where('HogoshaCd',$request->HogoshaCd)->first();
            $mode = 'edit';
        }
        //全件を取得
        $items = Hogosha::all();
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

        return view('Hogosha.add',$arg);

    }
    //保護者登録画面のPOST
    public function create(Request $request){
        $this->validate($request, Hogosha::$rules_create);
        $hogosha = new Hogosha;
        $form = $request->all();
        unset($form['_token']);
        $hogosha->fill($form);

        //checkboxはそのままだと登録できないので
        // $hogosha->IsLocked = ISSET($form->IsLocked)?1:0;
        // $hogosha->IsNeedPWChange = ISSET($form->IsNeedPWChange)?1:0;
        //この項目はつかっていない
        $hogosha->IsLocked = 0;
        $hogosha->IsNeedPWChange = 0;

        //フォームにない項目をセット
        $hogosha->setUpdateColumn();

        $hogosha->save();

        //登録後の再取得
        $args=[
        ];

        return redirect()->route('hogosha-add',$args)->with('alertComp',MessageConst::ADD_COMPLETED);
    }
    //保護者登録画面のPOST
    public function edit(Request $request){
        $this->validate($request, Hogosha::$rules_edit);
        $hogosha = Hogosha::where('HogoshaCd',$request->HogoshaCd)->first();
        $form = $request->all();
        unset($form['_token']);
        $hogosha->fill($form);

        //フォームにない項目をセット
        //この項目はつかっていない
        $hogosha->IsLocked = 0;
        $hogosha->IsNeedPWChange = 0;
        $hogosha->setUpdateColumn();

        $hogosha->save();

        //登録後の再取得
        $args=[
        ];

        return redirect()->route('hogosha-add',$args)->with('alertComp',MessageConst::EDIT_COMPLETED);
    }
    //保護者登録画面のPOST
    public function delete(Request $request){

        $hogosha = Hogosha::where('HogoshaCd',$request->HogoshaCd)->first();

        $hogosha->delete();

        //登録後の再取得
        $args=[
        ];

        return redirect()->route('hogosha-add',$args)->with('alertComp',MessageConst::DELETE_COMPLETED);
    }
    //user2保護者登録第一画面へ /user2hogosha/list/
    public function u2hlist(Request $request, Response $response){

        return view('user2hogosha.list',$args)
            ->with([
            'alertComp'=>session('alertComp'),
            'alertErr'=>session('alertErr'),
            'alertInfo'=>session('alertInfo'),
            'alertWar'=>session('alertWar'),
        ]);

    }
    //user2保護者登録第二画面へ /user2hogosha/edit/ GET
    public function u2hedit(Request $request, Response $response){
        $mode = 'create';

        //u2h_idがあれば、編集モード、なければ新規モード
        if($request->has('u2h_id')){
            //当マスタは編集モード非対応のため
            $mode='delete';
        }
        
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
            'mode'=>$mode,
            'createAction' =>"/user2hogosha/create",
            'updateAction' =>"",
            'deleteAction' =>"/user2hogosha/delete",
            'backURL'=>"/user2hogosha/list/",
            'alertComp'=>$alertComp,
            'alertErr'=>$alertErr,
        ];

        return view('user2hogosha.edit',$args);

    }
    //user2保護者登録画面のPOST
    public function u2hcreate(User2HogoshaRequest $request){
        // $this->validate($request, User2Hogosha::$rules);
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

        return redirect()->route('u2h-list',$args)->with('alertComp',MessageConst::ADD_COMPLETED);

    }
    //user2保護者削除のPOST
    public function u2hdelete(Request $request){
        $u2h_id = $request->u2h_id;

        $u2h = User2Hogosha::find($u2h_id);
        if($u2h){
            $u2h->delete();
        }

        $args=[
        ];
        return redirect()->route('u2h-list',$args)->with('alertComp',MessageConst::DELETE_COMPLETED);
    }

}
