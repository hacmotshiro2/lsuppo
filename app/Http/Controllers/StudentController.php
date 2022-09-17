<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Student;
use App\Models\LR;

use App\Consts\MessageConst;

class StudentController extends Controller
{
    //

    /*システム管理者が使用する画面*/
    //生徒登録画面へ
    public function add(Request $request){
        //
        $mode = 'add';
        $item = new Student;

        //全件取得
        $items = Student::all();
        $lrs = LR::all();

        //クエリ文字列にStudentCdがついている場合は、編集モードで開く
        if(isset($request->StudentCd)){
            $item = Student::where('StudentCd',$request->StudentCd)->first();
            $mode = 'edit';
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
            'item'=>$item,
            'items'=>$items,
            'lrs' =>$lrs,
            'alertComp'=>$alertComp,
            'alertErr'=>$alertErr,
        ];

        return view('Student.add',$args);

    }

    //生徒登録画面のPOST
    public function create(Request $request){
        $this->validate($request, Student::$rules);
        $student = new Student;
        $form = $request->all();
        unset($form['_token']);
        $student->fill($form);

        //checkboxはそのままだと登録できないので
        $student->IsLocked = ISSET($form->IsLocked)?1:0;
        $student->IsNeedPWChange = ISSET($form->IsNeedPWChange)?1:0;

        //フォームにない項目をセット

        $student->setUpdateColumn();

        $student->save();

        

        //登録後の再取得
        $args=[
        ];

        return redirect()->route('student-add',$args)->with('alertComp',MessageConst::ADD_COMPLETED);

    }
    //生徒編集画面のPOST
    public function edit(Request $request){
        $this->validate($request, Student::$rules);
        $student = Student::where('StudentCd',$request->StudentCd)->first();
        $form = $request->all();
        unset($form['_token']);
        $student->fill($form);

        //フォームにない項目をセット
        //この項目はつかっていない
        $student->IsLocked = 0;
        $student->IsNeedPWChange = 0;
        $student->setUpdateColumn();

        $student->save();

        //登録後の再取得
        $args=[
        ];

        return redirect()->route('student-add',$args)->with('alertComp',MessageConst::EDIT_COMPLETED);
    }
    //保護者登録画面のPOST
    public function delete(Request $request){

        $student = Student::where('StudentCd',$request->StudentCd)->first();

        $student->delete();

        //登録後の再取得
        $args=[
        ];

        return redirect()->route('student-add',$args)->with('alertComp',MessageConst::DELETE_COMPLETED);
    }

}
