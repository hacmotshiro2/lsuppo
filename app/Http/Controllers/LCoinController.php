<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\LCoinMeisai;
use App\Models\Student;
use App\Models\Ziyuu;
use App\Models\Hogosha;
use App\Http\Requests\LCoinRequest;
use App\Consts\DBConst;


class LCoinController extends Controller
{
    // \lc\
    public function index(Request $request){

        //認証情報を取得し、ログイン情報を取得する
        $user = Auth::user();
        //ログイン情報から保護者情報を取得
        $hogoshaCd = Hogosha::getHogoshaCd($user);

        $param = ['hogoshaCd'=>$hogoshaCd];
        $items = DB::select("

        SELECT 
            lc.id,
            lc.StudentCd,
            MS.HyouziMei StudentName,
            MS.HogoshaCd,
            lc.HasseiDate,
            lc.ZiyuuCd,
            MZ.Ziyuu,
            MZ.amount,
            lc.ZiyuuHosoku,
            lc.TourokuSupporterCd,
            MSP.HyouziMei TourokuSupporterName,
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
        ",$param);
        //残高計算
        //生徒毎に配列を分ける為の準備
        $sliceset=[];//オフセット、長さの多次元配列
        $studentNameset=[];//生徒名、長さ
        $offset = 0; //切り取りを開始する位置までのオフセット。一つ前の生徒のCount
        $lentgh=0;
        for($i=0;$i < count($items);$i++){

            //最後か、当該生徒の最後のレコードの際
            if($i==count($items)-1 or $items[$i]->StudentCd!==$items[$i+1]->StudentCd)
            {
                /*
                例　2番目までがAさんで3番目から5番目がBさん6番目がCとすると
                i =0 A  
                i =1 A  lengthset=1-0+1=2  offsetset= 0  offset=0→1+1=2　
                i =2 B  
                i =3 B
                i =4 B  lengthset=4-2+1=3  offsetset= 2  offset=2→4+1=5　
                i =5 C
                */
                $sliceset[]=[
                    'length'=>$i-$offset+1,
                    'offset'=>$offset,
                ];
                $studentNameset[]=[
                    $items[$i],
                ];
                $offset=$i+1;
            }
        }
        //生徒毎に配列を分ける
        $itemset=[];//i,items(SELECT明細セット)
        for($i=0;$i<count($sliceset);$i++){
            $itemset[]= array_slice($items,$sliceset[$i]['offset'],$sliceset[$i]['length']);
        }
        //分けた配列ごとに残高を計算する
        //生徒毎に計算する
        $lczandaka=0;
        $studentName='';
        $lczandakas=[];//生徒名,額
        foreach($itemset as $items){
            $lczandaka=0;
            foreach($items as $item){
                $lczandaka+=intVal($item->amount);
                $studentName = $item->StudentName;
            }
            $lczandakas[$studentName]=$lczandaka;
        }

        $arg = [
            'userName'=>$user->name,
            'msg'=>'',
            'lczandakas'=>$lczandakas,
            'itemset' => $itemset,
        ];

        return view('LCoin.index',$arg);

    }
    // \lc\regist
    public function regist(Request $request){

        //ドロップダウンリストのための処理
        $students = Student::all();
        $ziyuus = Ziyuu::all();
        #TODO userとsupporterを紐づけて、セット
        $supporterCd = 'FDemo1';

        $arg = [
            #TODO
            'userName'=>'システム管理者',
            'TourokuSupporterCd'=>$supporterCd,
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
