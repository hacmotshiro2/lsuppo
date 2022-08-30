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
use App\Models\Supporter;
use App\Http\Requests\LCoinRequest;
use App\Consts\DBConst;
use App\Consts\MessageConst;


class LCoinController extends Controller
{
    /*
    // \lc\
    public function index(Request $request){

                //認証情報を取得し、ログイン情報を取得する
                $user = Auth::user();
                //ログイン情報から保護者情報を取得
                $hogoshaCd = Hogosha::getHogoshaCd($user);
        
                //保護者コードから、該当する生徒の一覧を取得　生徒コードASCで配列に

                //生徒毎のエルコイン残高を取得　生徒コードASCで配列に

                //生徒毎の、該当のLCoinMeisaiを取得　生徒コードASCで配列に
                $items = LCoinMeisai::getLCmeisaiByHogosha($hogoshaCd);

                //

    }
    */
    // \lc\
    public function index(Request $request){

        //認証情報を取得し、ログイン情報を取得する
        $user = Auth::user();
        //ログイン情報から保護者情報を取得
        $hogoshaCd = Hogosha::getHogoshaCd($user);

        //保護者コードから、該当のLCoinMeisaiを取得
        $items = LCoinMeisai::getLCmeisaiByHogoshaCd($hogoshaCd);
     
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
                $lczandaka+=intVal($item->Amount);
                $studentName = $item->StudentName;
            }
            $lczandakas[$studentName]=$lczandaka;
        }

        $args = [
            'lczandakas'=>$lczandakas,
            'itemset' => $itemset,
        ];

        return view('LCoin.index',$args);

    }
    //get 管理者用の一覧確認ページ
    public function list(Request $request){

        $items=LCoinMeisai::All();

        //リダイレクト時には、セッションにalertが入ってくる可能性があるので拾う
        $alertComp='';
        if($request->session()->has('alertComp')){
            $alertComp = $request->session()->get('alertComp');
        }
        $alertErr='';
        if($request->session()->has('alertErr')){
            $alertErr = $request->session()->get('alertErr');
        }
        
        
        $args = [
            'items'=>$items,
            'alertComp' =>$alertComp,
            'alertErr' =>$alertErr,

        ];

        return view('LCoin.list', $args);

    }

    // \lc\add
    public function add(Request $request){

        $user = Auth::user();

        //ドロップダウンリスト用データ取得（#TODOキャッシュにしたい）
        $students = Student::all();
        $ziyuus = Ziyuu::all();

        //userとsupporterを紐づけて、セット
        $supporterCd = Supporter::getSupporterCd($user);

        //リダイレクト時には、セッションにalertが入ってくる可能性があるので拾う
        $alertComp='';
        if($request->session()->has('alertComp')){
            $alertComp = $request->session()->get('alertComp');
        }
        $alertErr='';
        if($request->session()->has('alertErr')){
            $alertErr = $request->session()->get('alertErr');
        }
        

        $arg = [
            #TODO
            'mode'=>'add',
            'alertComp' =>$alertComp,
            'alertErr' =>$alertErr,
            'TourokuSupporterCd'=>$supporterCd,
            'students'=>$students,
            'ziyuus'=>$ziyuus,
        ];
        return view('LCoin.regist',$arg);

    }
    // \lc\regist post
    public function addpost(LCoinRequest $request){

    
            $lcmeisai = new LCoinMeisai;
            $form = $request->all();
            unset($form['_token']);
            $lcmeisai->fill($form);

            //フォームにない項目をセット
            $lcmeisai->setUpdateColumn();
            //INSERT処理
            $lcmeisai->save();
    
            //リダイレクト時にクエリ文字列として渡す
            $args = [
            ];
    
            return redirect()->route('lcList',$args)->with('alertComp',MessageConst::ADD_COMPLETED);
    }

    // \lc\delete post
    public function deletepost(Request $request){

        $id = $request->id;
        $lcmeisai = LCoinMeisai::find($id);
       
        //DELETE処理
        $lcmeisai->delete();

        //リダイレクト時にクエリ文字列として渡す
        $args = [
        ];

        return redirect()->route('lcList',$args)->with('alertComp',MessageConst::DELETE_COMPLETED);
    }
}
