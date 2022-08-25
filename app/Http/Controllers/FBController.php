<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\FB;
use App\Models\Hogosha;
use App\Models\Student;
use App\Models\Supporter;
use App\Models\LR;

use App\Http\Requests\FBRequest;
use App\Consts\DBConst;
use App\Consts\MessageConst;

use Illuminate\Support\Facades\Gate;

class FBController extends Controller
{
    //get fb\
    public function index(Request $request){
        //認証情報を取得し、保護者コードを取得する
        $user = Auth::user();
        $hogoshaCd = Hogosha::getHogoshaCd($user);

        $items = FB::getFBListByHogoshaCd($hogoshaCd);

        $arg = [
            'items' => $items,
            'sp'=>'0', //supporterかどうか
        ];

        return view('FB.index',$arg);
    }
    //get fb\splist
    public function index_sp(Request $request){
        #TODO 自LRに絞るかは要検討
        $items = FB::getAllFBList(); //通常のallでとると、indexの場合とプロパティが変わるので。（例StudentName）

        //権限チェック　だめならexception
        Gate::authorize('supporter-binded',FB::class);

        $arg = [
            'items' => $items,
            'sp'=>'1', //supporterかどうか
        ];

        return view('FB.index',$arg);

    }
    // /fb/detail/{fbNo} サポーターも参照する
    public function fbDetail(Request $request,$fbNo){

        $item=FB::where('FbNo',$fbNo)->first();

        //権限チェック　だめならexception
        Gate::authorize('view_fb_detail',$item);

        $arg=[
            'item'=>$item,
        ];

        return view('FB.detail',$arg);

    }
    //fb\add
    public function add(Request $request){
        
        //権限チェック　だめならexception ※第二引数は必須
        Gate::authorize('add_fb',new FB);

        $user = Auth::user();

        //ドロップダウンリスト用データ取得（#TODOキャッシュにしたい）
        $students = Student::all();
        $lrs = LR::all();

        //userとsupporterを紐づけて、セット
        $supporterCd = Supporter::getSupporterCd($user);

        $arg = [
            #TODO
            'mode' =>'add',
            'students'=>$students,
            'lrs'=>$lrs,
            'KinyuuSupporterCd'=>$supporterCd,
        ];
        return view('FB.regist',$arg);
    }
    // post fb\add
    public function addpost(FBRequest $request){

        //画面上で入力させるが、サポーターが所属するLRに所属する生徒のみにする必要あり→バリデーションへ

        $user = Auth::user();

        //ドロップダウンリスト用データ取得（#TODOキャッシュにしたい）
        $students = Student::all();
        $lrs = LR::all();

        #TODO userとsupporterを紐づけて、セット
        $supporterCd = $request->KinyuuSupporterCd;

        $arg = [
            #TODO
            'alertComp'=>MessageConst::ADD_COMPLETED,
            'mode' =>'add',
            'students'=>$students,
            'lrs'=>$lrs,
            'KinyuuSupporterCd'=>$supporterCd,
        ];

        // //Validation →フォームコントローラーに移行
        // $validate_rule = [
        //     'fbTitle' => 'required',
        //     'fbDetail' => 'required',
        //     'TaishoukikanFrom' => 'required',
        //     'TaishoukikanTo' => 'required',
        // ];
        // $this->validate($request,$validate_rule);

        $fb = new FB;
        $form = $request->all();
        unset($form['_token']);
        //フォームから値をセット
        $fb->fill($form);
        //フォームにはない値をセット
        $fb->FbShurui=1;
        $fb->FirstReadDate=null;
        $fb->LastReadDate=null;
        $fb->KinyuuDate=date("Y-m-d H:i:s");
        #TODO承認機能
        $fb->ShouninDate=date("Y-m-d H:i:s");
        $fb->ShouninStatus=DBConst::SHOUNIN_STATUS_APPROVED;
        $fb->ShouninSupporterCd=$request->KinyuuSupporterCd;

        //Update系のセット
        $fb->setUpdateColumn();

        //登録処理
        $fb->save();

        return view('FB.regist',$arg);


    }
    //get fb\edit
    public function edit(Request $request,$fbNo){
        $fb = FB::find($fbNo);
        
        //権限チェック　だめならexception
        Gate::authorize('edit_fb',$fb);

        $user = Auth::user();

        //ドロップダウンリスト用データ取得（#TODOキャッシュにしたい）
        //生徒の変更は行えないようにする
        $students = Student::where('StudentCd',$fb->StudentCd)->get();
        $lrs = LR::all();

        //userとsupporterを紐づけて、セット
        $supporterCd = Supporter::getSupporterCd($user);

        $arg = [
            #TODO
            'mode' =>'edit',
            'form' =>$fb,
            'students'=>$students,
            'lrs'=>$lrs,
            'KinyuuSupporterCd'=>$supporterCd,
        ];
        return view('FB.regist',$arg);
    }
    // post fb\edit
    public function editpost(FBRequest $request,$fbNo){

        //画面上で入力させるが、サポーターが所属するLRに所属する生徒のみにする必要あり→バリデーションへ


        $user = Auth::user();
       
        $fb = FB::where('FbNo',$fbNo)->first();
        $form = $request->all();
        unset($form['_token']);
        //フォームから値をセット
        $fb->fill($form);
        //フォームにはない値をセット
        $fb->KinyuuDate=date("Y-m-d H:i:s");
        #TODO承認機能
        $fb->ShouninDate=date("Y-m-d H:i:s");
        $fb->ShouninStatus=DBConst::SHOUNIN_STATUS_APPROVED;
        $fb->ShouninSupporterCd=$request->KinyuuSupporterCd;

        //Update系のセット
        $fb->setUpdateColumn();

        //ドロップダウンリスト用データ取得（#TODOキャッシュにしたい）
        //生徒の変更は行えないようにする
        $students = Student::where('StudentCd',$fb->StudentCd)->get();
        $lrs = LR::all();

        //userとsupporterを紐づけて、セット
        $supporterCd = $request->KinyuuSupporterCd;

        $arg = [
            #TODO
            'alertComp'=>MessageConst::EDIT_COMPLETED,
            'mode' =>'edit',
            'form' =>$fb,
            'students'=>$students,
            'lrs'=>$lrs,
            'KinyuuSupporterCd'=>$supporterCd,
        ];


        //登録処理
        $fb->save();

        return view('FB.regist',$arg);

    }
}
