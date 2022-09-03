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
        $items = Student::all();
        $lrs = LR::all();

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
            'items'=>$items,
            'lrs' =>$lrs,
            'alertComp'=>$alertComp,
            'alertErr'=>$alertErr,
        ];

        return view('Student.add',$args);

    }

    //保護者登録画面のPOST
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
}
