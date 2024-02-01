<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Student;
use App\Models\LR;

use App\Consts\MessageConst;

use App\Http\Requests\StudentRequest;

class StudentController extends Controller
{
    //

    /*システム管理者が使用する画面*/
    //生徒マスタ一覧画面へ
    public function list(Request $request){

        $args=[
        ];

        return view('Student.list',$args)->with(parent::getAlertSessions());

    }

    //生徒マスタメンテナンス画面へ
    public function edit(Request $request){
        $mode = 'create';

        //studentCdがあれば、編集モード、なければ新規モード
        if($request->has('studentCd')){
            $mode='update';
        }
        
        $args=[
            'mode'=>$mode,
            'createAction' =>"/student/create",
            'updateAction' =>"/student/update",
            'deleteAction' =>"/student/delete",
            'backURL'=>"/student/list/",
        ];

        return view('Student.edit',$args)->with(parent::getAlertSessions());

    }

    //生徒登録画面のPOST
    public function create(StudentRequest $request){
        // $this->validate($request, Student::$rules_create);
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

        $args=[
        ];

        return redirect()->route('student-list',$args)->with('alertComp',MessageConst::ADD_COMPLETED);

    }
    //生徒編集画面のPOST
    public function update(StudentRequest $request){
        // $this->validate($request, Student::$rules_edit);
        $student = Student::find($request->StudentCd);
        $form = $request->all();
        unset($form['_token']);
        $student->fill($form);

        //フォームにない項目をセット
        //この項目はつかっていない
        $student->IsLocked = 0;
        $student->IsNeedPWChange = 0;
        $student->setUpdateColumn();

        $student->save();

        $args=[
        ];

        return redirect()->route('student-list',$args)->with('alertComp',MessageConst::EDIT_COMPLETED);
    }
    //生徒編集画面のPOST
    public function delete(Request $request){

        $student = Student::find($request->StudentCd);

        $student->delete();

        $args=[
        ];

        return redirect()->route('student-list',$args)->with('alertComp',MessageConst::DELETE_COMPLETED);
    }

    //API LR一覧を返す
    public function getLRs(Request $request){
        //シークレットトークンのチェックは、ミドルウェアで済み

        $lrs = LR::all();

        return response()->json($lrs);
        // return $lrs->toJson();        
    }

    //API LRに所属するStudentCd一覧を返す
    public function getStudents(Request $request){
        //シークレットトークンのチェックは、ミドルウェアで済み

        //lrcd（ラーニングルームコード）を渡してもらいます
        $lrcd = $request->lrcd;
  
        // No17. h.hashimoto 2023/03/12 ------>
        // //lrcdに所属するStudentだけを返します StudentCdだけ返す
        // $students = Student::where('LearningRoomCd',$lrcd)->get(['StudentCd']);

        //lrcdに所属するStudentだけを返します StudentCdだけ返す。退会した生徒は出ないようにする
        $students = Student::where('LearningRoomCd',$lrcd)->whereRaw('RiyouShuuryouDate IS NULL OR RiyouShuuryouDate > CURDATE()')->get(['StudentCd']);
        // <------  No17. h.hashimoto 2023/03/12 

        return response()->json($students);        
    }

}
