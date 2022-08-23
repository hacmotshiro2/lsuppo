<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\FB;
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
        $arg = [
            #TODO
            'userName'=>'サポーターサンプル',
            'msg'=>'',
        ];
        return view('FB.regist',$arg);
    }
    // public function registpost($id='no name',Request $request){
    public function registpost(FBRequest $request){

        $studentcd= "SDemo1";//画面上で入力させるが、サポーターが所属するLRに所属する生徒のみにする必要あり


        // $m =$request->msg;
        $m ="正しく入力されました";

        $arg = [
            'userName'=>'システム管理者',
            // 'msg'=>$request->msg,
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


        $param=[
            'StudentCd'=>$studentcd,
            'FbShurui'=>"1",
            'TaishoukikanFrom'=>$request->TaishoukikanFrom,
            'TaishoukikanTo'=>$request->TaishoukikanTo,
            'LearningRoomCd'=>"100001",
            'Title'=>$request->fbTitle,
            'Detail'=>$request->fbDetail,
            'KinyuuSupporterCd'=>"FDemo1",
            'KinyuuDate'=> date("Y-m-d H:i:s"),
            'ShouninSupporterCd'=>"FDemo1",
            'ShouninDate'=> date("Y-m-d H:i:s"),
            'ShouninStatus'=>"5",
            'UpdateDatetime'=> date("Y-m-d H:i:s"),
            'UpdateGamen'=>(empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], //:現在のURL
            'UpdateSystem'=>DBConst::UPDATE_SYSTEM,
        ];
    
        DB::insert("INSERT INTO `r_fe_feedbackmeisai`( `StudentCd`, `FbShurui`, `TaishoukikanFrom`, `TaishoukikanTo`, `LearningRoomCd`, `Title`, `Detail`, `KinyuuSupporterCd`, `KinyuuDate`, `ShouninSupporterCd`, `ShouninDate`, `ShouninStatus`, `UpdateDatetime`, `UpdateGamen`, `UpdateSystem`)   VALUES (:StudentCd, :FbShurui, :TaishoukikanFrom, :TaishoukikanTo,:LearningRoomCd, :Title, :Detail, :KinyuuSupporterCd, :KinyuuDate, :ShouninSupporterCd, :ShouninDate, :ShouninStatus,:UpdateDatetime, :UpdateGamen, :UpdateSystem) "
        ,$param); //SQL文の骨子を準備

        return view('FB.regist',$arg);


    }
    
  


    /*以下練習コード*/
    // public function index(Request $request, Response $response, $id='no name'){
    //     return  <<<EOF
    //     <html>
    //     <body><p>{$id}</p>
    //         <pre>{$request}</pre>
    //         <pre>{$response}</pre>
    //     </body>

    //     </html>
    //     EOF;
    // }

    // public function list($id='no name'){
    //     return  <<<EOF
    //     <html>
    //     <body>
    //     <li>{$id}</li>
    //     <li>{$id}</li>
    //     <li>{$id}</li>
    //     </body>
    //     </html>
    //     EOF;
    // }
}
