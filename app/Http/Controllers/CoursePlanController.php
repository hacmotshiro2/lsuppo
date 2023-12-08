<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Student;
use App\Models\Supporter;
use App\Models\MKoumoku;
use App\Models\CoursePlan;
use App\Http\Requests\CoursePlanRequest;
use App\Consts\DBConst;
use App\Consts\MessageConst;

class CoursePlanController extends Controller
{
    //
    // \lc\add
    public function add(Request $request){

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
            'alertComp' =>$alertComp,
            'alertErr' =>$alertErr,
        ];
        return view('CoursePlan.regist',$arg);

    }

    public function addpost(CoursePlanRequest $request){

        $cp = new CoursePlan;
        $form = $request->all();
        unset($form['_token']);
        $cp->fill($form);

        //フォームにない項目をセット
        $cp->setUpdateColumn();

        //INSERT処理
        $cp->save();

        #TODO
        // //保護者へ通知を行う
        // //管理者が登録するので、ログインユーザーではなく、いま登録したユーザーに対して送る
        // //エルコイン明細のStudentCd＞スチューデントマスタのHogoshaCd＞User2HogoshaのUserId
        // $student = Student::find($lcmeisai->StudentCd);
        // $u2hs = User2Hogosha::where('HogoshaCd', $student->HogoshaCd)->get();

        // //1つの保護者コードに対して、複数のユーザーがいる可能性があるので
        // foreach($u2hs as $u2h){
        //     $user = User::find($u2h->user_id);
        //     if(!is_null($user)){
        //         $user->notify(new LCoinAddedNotification($user->name,$lcmeisai->Amount,$lcziyuu->Ziyuu."  ".$lcmeisai->ZiyuuHosoku));
        //     }
        // }
        //リダイレクト時にクエリ文字列として渡す
        $args = [
        ];

        return redirect()->route('cpadd',$args)->with('alertComp',MessageConst::ADD_COMPLETED);

    }
}
