<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\LCoinMeisai;
use App\Models\Student;
use App\Models\Ziyuu;
use App\Http\Controllers\HogoshaController;
use App\Http\Requests\LCoinRequest;
use App\Consts\DBConst;


class LCoinController extends Controller
{
    // \lc\
    public function index(Request $request){

        //認証情報を取得し、ログイン情報を取得する
        $user = Auth::user();
        //ログイン情報から保護者情報を取得
        $hogoshaCd = HogoshaController::getHogoshaCd($user);

        $param = ['hogoshaCd'=>$hogoshaCd];
        $items = DB::select("

        SELECT 
            lc.id,
            lc.StudentCd,
            MS.HyouziMei,
            MS.HogoshaCd,
            lc.HasseiDate,
            lc.ZiyuuCd,
            MZ.amount,
            lc.ZiyuuHosoku,
            lc.TourokuSupporterCd,
            MSP.HyouziMei,
            lc.amount
        FROM r_lc_lcoinmeisai lc
        LEFT OUTER JOIN m_student MS
        ON MS.StudentCd = lc.StudentCd
        LEFT OUTER JOIN m_lc_ziyuu MZ
        ON MZ.ZiyuuCd = lc.ZiyuuCd
        LEFT OUTER JOIN m_supporter MSP
        ON MSP.SupporterCd = lc.TourokuSupporterCd
        WHERE MS.HogoshaCd = :hogoshaCd
        ORDER BY lc.StudentCd,lc.HasseiDate DESC
        ;");
        //残高計算
        #TODO
        $lczandaka=100;

        $arg = [
            'userName'=>$user->name,
            'msg'=>'',
            'lczandaka'=>$lczandaka,
            'items' => $items,
        ];

        return view('LCoin.index',$arg);

    }
    // \lc\regist
    public function regist(Request $request){

        //ドロップダウンリストのための処理
        $students = Student::all();
        $ziyuus = Ziyuu::all();

        $arg = [
            #TODO
            'userName'=>'システム管理者',
            'TourokuSupporterCd'=>'FDemo1',
            'msg'=>'',
            'students'=>$students,
            'ziyuus'=>$ziyuus,
        ];
        return view('LCoin.regist',$arg);

    }
    // \lc\regist post
    public function registpost(LCoinRequest $request){

    
            $lcmeisai = new LCoinMeisai;
            $form = $request->all();
            unset($form['_token']);
            $lcmeisai->fill($form);


            //フォームにない項目をセット
            $lcmeisai->UpdateDatetime = date("Y-m-d H:i:s");
            $lcmeisai->UpdateGamen = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $lcmeisai->UpdateSystem = DBConst::UPDATE_SYSTEM;

            $lcmeisai->save();
    
            // $m =$request->msg;
            $m ="正しく入力されました";

            //ドロップダウンリストのための処理
            $students = Student::all();
            $ziyuus = Ziyuu::all();
    
            $arg = [
                'userName'=>'システム管理者',
                'TourokuSupporterCd'=>'FDemo1',
                'msg'=>$m,
                'students'=>$students,
                'ziyuus'=>$ziyuus,
    
            ];
    
            return view('LCoin.regist',$arg);
    
        //     $param=[
        //         'StudentCd'=>$request->StudentCd,
        //         'HasseiDate'=>$request->HasseiDate,
              
        //         'UpdateDatetime'=> date("Y-m-d H:i:s"),
        //         'UpdateGamen'=>(empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], //:現在のURL
        //         'UpdateSystem'=>DBConst::UPDATE_SYSTEM,
        //     ];
        
        //     DB::insert("
        //     INSERT INTO `r_lc_lcoinmeisai`
        //     ( 
        //         StudentCd,
        //         HasseiDate,
        //         ZiyuuCd,
        //         ZiyuuHosoku,
        //         TourokuSupporterCd,
        //         UpdateDatetime,
        //         UpdateGamen,
        //         UpdateSystem,
        //         amount
        //     ) 
        //    VALUES 
        //    (
        //         :StudentCd,
        //         :HasseiDate,
        //         :ZiyuuCd,
        //         :ZiyuuHosoku,
        //         :TourokuSupporterCd,
        //         :UpdateDatetime,
        //         :UpdateGamen,
        //         :UpdateSystem,
        //         :amount
        //    )
        //    "
        //     ,$param); //SQL文の骨子を準備
    
    
        }
}
