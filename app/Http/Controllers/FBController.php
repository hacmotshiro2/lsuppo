<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\FB;
use App\Models\Student;
use App\Models\LR;

use App\Http\Requests\FBRequest;
use App\Http\Controllers\HogoshaController;
use App\Consts\DBConst;

class FBController extends Controller
{
    //fb\
    public function index(Request $request, Response $response){
        //認証情報を取得し、保護者コードを取得する
        $user = Auth::user();
        $hogoshaCd = HogoshaController::getHogoshaCd($user);

        $param = ['hogoshaCd'=>$hogoshaCd];
        $items = DB::select("
        SELECT 
        FbNo, 
        MAIN.StudentCd, 
        mst.HyouziMei AS StudentName,
        `FbShurui`, 
        `TaishoukikanFrom`, 
        `TaishoukikanTo`, 
        MAIN.LearningRoomCd, 
        mlr.LearningRoomName AS LRName,
        `Title`, 
        `Detail`, 
        `KinyuuSupporterCd`, 
        msp_kinyuu.HyouziMei AS KinyuuSupporterName , 
        `KinyuuDate`, 
        `ShouninSupporterCd`, 
        msp_shounin.HyouziMei AS ShouninSupporterName , 
        `ShouninDate`, 
        `ShouninStatus`

        FROM r_fe_feedbackmeisai MAIN 
        LEFT OUTER JOIN m_student mst
        ON mst.StudentCd = MAIN.StudentCd
        LEFT OUTER JOIN m_learningroom mlr
        ON mlr.LearningRoomCd = MAIN.LearningRoomCd
        LEFT OUTER JOIN m_supporter msp_kinyuu
        ON msp_kinyuu.SupporterCd = MAIN.KinyuuSupporterCd
        LEFT OUTER JOIN m_supporter msp_shounin
        ON msp_shounin.SupporterCd = MAIN.ShouninSupporterCd
        WHERE mst.HogoshaCd = :hogoshaCd
        AND MAIN.ShouninStatus = '5'
        ORDER BY MAIN.StudentCd ,MAIN.TaishoukikanFrom DESC, MAIN.TaishoukikanTo DESC, MAIN.FbNo DESC
        "
        ,$param);

        $arg = [
            'userName'=>$user->name,
            'msg'=>'',
            'items' => $items,
        ];

        return view('FB.index',$arg);
    }
     // /fb/detail/{fbNo}
     public function fbDetail(Request $request,$fbNo){
        #TODO 改めて保護者の認証は入れるべき
        $item=FB::where('FbNo',$fbNo)->first();
        $user=Auth::user();
        $arg=[
            'item'=>$item,
            'userName'=>$user->name,
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
            'userName'=>$user->name,
            'KinyuuSupporterCd'=>$supporterCd,
            'msg'=>'',
        ];
        return view('FB.regist',$arg);
    }
    // fb\regist
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
            'userName'=>$user->name,
            'KinyuuSupporterCd'=>$supporterCd,
            'msg'=>$m,
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

        // $param=[
        //     'StudentCd'=>$studentcd,
        //     'FbShurui'=>"1",
        //     'TaishoukikanFrom'=>$request->TaishoukikanFrom,
        //     'TaishoukikanTo'=>$request->TaishoukikanTo,
        //     'LearningRoomCd'=>"100001",
        //     'Title'=>$request->fbTitle,
        //     'Detail'=>$request->fbDetail,
        //     'KinyuuSupporterCd'=>"FDemo1",
        //     'KinyuuDate'=> date("Y-m-d H:i:s"),
        //     'ShouninSupporterCd'=>"FDemo1",
        //     'ShouninDate'=> date("Y-m-d H:i:s"),
        //     'ShouninStatus'=>"5",
        //     'UpdateDatetime'=> date("Y-m-d H:i:s"),
        //     'UpdateGamen'=>(empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], //:現在のURL
        //     'UpdateSystem'=>DBConst::UPDATE_SYSTEM,
        // ];
    
        // DB::insert("INSERT INTO `r_fe_feedbackmeisai`( `StudentCd`, `FbShurui`, `TaishoukikanFrom`, `TaishoukikanTo`, `LearningRoomCd`, `Title`, `Detail`, `KinyuuSupporterCd`, `KinyuuDate`, `ShouninSupporterCd`, `ShouninDate`, `ShouninStatus`, `UpdateDatetime`, `UpdateGamen`, `UpdateSystem`)   VALUES (:StudentCd, :FbShurui, :TaishoukikanFrom, :TaishoukikanTo,:LearningRoomCd, :Title, :Detail, :KinyuuSupporterCd, :KinyuuDate, :ShouninSupporterCd, :ShouninDate, :ShouninStatus,:UpdateDatetime, :UpdateGamen, :UpdateSystem) "
        // ,$param); //SQL文の骨子を準備

        return view('FB.regist',$arg);


    }
  
}
