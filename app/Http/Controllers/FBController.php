<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\FB;
use App\Models\Hogosha;
use App\Models\Student;
use App\Models\LR;

use App\Http\Requests\FBRequest;
use App\Consts\DBConst;

class FBController extends Controller
{
    //fb\
    public function index(Request $request, Response $response){
        //認証情報を取得し、保護者コードを取得する
        $user = Auth::user();
        $hogoshaCd = Hogosha::getHogoshaCd($user);

        $items = FB::getFBListByHogoshaCd($hogoshaCd);

        $arg = [
            'items' => $items,
        ];

        return view('FB.index',$arg);
    }
     // /fb/detail/{fbNo}
     public function fbDetail(Request $request,$fbNo){
        #TODO 改めて保護者の認証は入れるべき?サポーターが参照することもある
        $item=FB::where('FbNo',$fbNo)->first();
        $user=Auth::user();
        $arg=[
            'item'=>$item,
        ];

        return view('FB.detail',$arg);

    }
    //fb\regist
    public function regist(Request $request, Response $response){
        $user = Auth::user();
        $students = Student::all();
        $lrs = LR::all();
        #TODO userとsupporterを紐づけて、セット
        $supporterCd = 'FDemo1';

        $arg = [
            #TODO
            'students'=>$students,
            'lrs'=>$lrs,
            'KinyuuSupporterCd'=>$supporterCd,
        ];
        return view('FB.regist',$arg);
    }
    // get fb\regist
    public function registpost(FBRequest $request){

        //画面上で入力させるが、サポーターが所属するLRに所属する生徒のみにする必要あり→バリデーションへ


        // $m =$request->msg;
        $m ="正しく入力されました";

        $user = Auth::user();
        $students = Student::all();
        $lrs = LR::all();
        #TODO userとsupporterを紐づけて、セット
        $supporterCd = 'FDemo1';

        $arg = [
            #TODO
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

        $fb->UpdateDatetime=date("Y-m-d H:i:s");
        $fb->UpdateGamen=(empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; //:現在のURL
        $fb->UpdateSystem=DBConst::UPDATE_SYSTEM;


        //登録処理
        $fb->save();

        return view('FB.regist',$arg);


    }
  
}
