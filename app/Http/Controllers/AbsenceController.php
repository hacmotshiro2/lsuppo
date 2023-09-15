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
        //リダイレクト時には、セッションにalertが入ってくる可能性があるので拾う
        $alertComp='';
        if($request->session()->has('alertComp')){
            $alertComp = $request->session()->get('alertComp');
        }

        $args = [
            'alertComp' =>$alertComp,
        ];


        return view('Absence.list',$args);
    }

    // \absence\add
    public function regist(Request $request){

        $user = Auth::user();

        $mode = 'add';
        $item = new Absence;
        $id = -1;
        
        //クエリ文字列にidがついている場合は、編集モードで開く
        if(isset($request->id)){
            $id = $request->id;
            $item = Absence::find($id);
            $mode = 'edit';
        }

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
        

        $args = [
            'id'=>$id,
            'mode'=>$mode,
            'item'=>$item,
            'alertComp' =>$alertComp,
            'alertErr' =>$alertErr,
            'TourokuSupporterCd'=>$supporterCd,
            'students'=>$students,
            'ziyuus'=>$ziyuus,
        ];
        return view('Absence.regist',$args);

    }
    // \absence\add post
    // ValidationをAbsenceRequestで実装
    public function add(AbsenceRequest $request){
    
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
    // \absence\edit
    public function edit(AbsenceRequest $request){
        
        //クエリ文字列にidがついていない場合はエラー
        if(isset($request->id)){}

        $absence = Absence::find($request->id);
        $form = $request->all();
        unset($form['_token']);
        $absence->fill($form);

        //フォームにない項目をセット
        $absence->setUpdateColumn();

        //UPDATE処理
        $absence->save();

        //リダイレクト時にクエリ文字列として渡す
        $args = [
        ];

        return redirect()->route('absenceList',$args)->with('alertComp',MessageConst::EDIT_COMPLETED);
    }
    // \absence\delete
    public function delete(AbsenceRequest $request){

        #TODO 振替実績日が入っている場合はエラーにする。
        
        //クエリ文字列にidがついていない場合はエラー
        if(isset($request->id)){}

        $absence = Absence::find($request->id);

        //DELETE処理
        $absence->delete();

        //リダイレクト時にクエリ文字列として渡す
        $args = [
        ];

        return redirect()->route('absenceList',$args)->with('alertComp',MessageConst::DELETE_COMPLETED);
    }
    
}
