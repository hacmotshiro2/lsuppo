<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Student;
use App\Models\Absence;
use App\Models\Hogosha;
use App\Models\LCZiyuu;
use App\Models\Supporter;
use App\Models\User2Hogosha;
use App\Http\Requests\AbsenceRequest;
use App\Consts\DBConst;
use App\Consts\MessageConst;

class AbsenceController extends Controller
{
    //\absence\list
    public function list(Request $request){
        return view('Absence.list');
    }

    // \absence\add
    public function add(Request $request){

        $user = Auth::user();

        //ドロップダウンリスト用データ取得（#TODOキャッシュにしたい）
        $students = Student::all();
        $ziyuus = LCZiyuu::all();

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
            'mode'=>'add',
            'alertComp' =>$alertComp,
            'alertErr' =>$alertErr,
            'TourokuSupporterCd'=>$supporterCd,
            'students'=>$students,
            'ziyuus'=>$ziyuus,
        ];
        return view('Absence.regist',$arg);

    }
    // \absence\add post
    // ValidationをAbsenceRequestで実装
    public function addpost(AbsenceRequest $request){
    
        $absence = new Absence;
        $form = $request->all();
        unset($form['_token']);
        $absence->fill($form);

        //フォームにない項目をセット
        $absence->setUpdateColumn();

        //INSERT処理
        $absence->save();
        
        //リダイレクト時にクエリ文字列として渡す
        $args = [
        ];

        return redirect()->route('absenceList',$args)->with('alertComp',MessageConst::ADD_COMPLETED);
    }
    
}
