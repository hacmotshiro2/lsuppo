<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\MVPresentation;
use App\Models\Hogosha;
use App\Models\Student;

use App\Consts\MessageConst;

class MVController extends Controller
{
    //GET
    public function index(Request $request){
        //認証情報を取得し、ログイン情報を取得する
        $user = Auth::user();
        //ログイン情報から保護者情報を取得
        $hogoshaCd = Hogosha::getHogoshaCd($user);

        //保護者コードから、該当する生徒の一覧を取得　生徒コードASCで配列に
        $students = Student::where('hogoshaCd',$hogoshaCd)->orderBy('StudentCd','asc')->get();

        return $this->mvPresenWatch($students);
    }
    //GET サポーターが保護者と同じ画面を見る（生徒単位）
    public function index_student(Request $request){
        
        //クエリ文字列にStudentCdがついている場合のみ次に進む
        if(!$request->has('studentCd')){
            abort(500,MessageConst::INVALID_TRANSITION); 
        }
        $studentCd = $request->studentCd;
        $students = Student::where('StudentCd',$studentCd)->get();

        return $this->mvPresenWatch($students);
    }
    //保護者が見たとき、サポーターが見たとき、の共通部分
    private function mvPresenWatch($students){
        //生徒ひ紐づく発表動画を取得する
        $itemset=[];
        foreach($students as $student){
            $itemset[$student->StudentCd] = MVPresentation::where('StudentCd',$student->StudentCd)->orderBy('ShootingDate','desc')->get();
        }
        $args=[
            'students'=>$students,
            'itemset'=>$itemset,
        ];
        return view('mv.presen.watch',$args);
    }

    // //GET
    // public function index_admin(Request $request){

    //     //全ての生徒分を取得　生徒コードASCで配列に
    //     $students = Student::orderBy('StudentCd','asc')->get();

    //     //生徒ひ紐づく発表動画を取得する
    //     $itemset=[];
    //     foreach($students as $student){
    //         $itemset[$student->StudentCd] = MVPresentation::where('StudentCd',$student->StudentCd)->orderBy('ShootingDate','desc')->get();
    //     }
    //     //リダイレクト時には、セッションにalertが入ってくる可能性があるので拾う
    //     $alertComp='';
    //     if($request->session()->has('alertComp')){
    //         $alertComp = $request->session()->get('alertComp');
    //     }
    //     $alertErr='';
    //     if($request->session()->has('alertErr')){
    //         $alertErr = $request->session()->get('alertErr');
    //     }

    //     $args=[
    //         'students'=>$students,
    //         'itemset'=>$itemset,
    //         'alertComp'=>$alertComp,
    //         'alertErr'=>$alertErr,
    //     ];
    //     return view('mv.mvPresenList',$args);

    // }
    //GET　一覧画面へ
    public function list(Request $request){

        $args=[];
        return view('mv.presen.list',$args)->with(parent::getAlertSessions());
    }
    //GET　登録画面へ
    public function edit(Request $request){
        $mode = 'create';
        $item = null;

        //クエリ文字列にidがついている場合は、編集モードで開く
        if(isset($request->id)){
            $mode = 'update';
            $item = MVPresentation::find($request->id);
        }

        //ドロップダウンリスト用データ取得（#TODOキャッシュにしたい）
        $students = Student::all();
        
        $args=[
            'id'=>$request->id,
            'mode'=>$mode,
            'item'=>$item,
            'students'=>$students,
            'createAction' =>"/mv/presen/confirm?mode=create",
            'updateAction' =>"/mv/presen/confirm?mode=update",
            'deleteAction' =>"/mv/presen/delete",
            'backURL'=>"/mv/presen/list/",
        ];

        return view('mv.presen.edit',$args)->with(parent::getAlertSessions());
    }
    // //GET
    // public function add(Request $request){

    //     $mode = 'add';
    //     $item = null;

    //     //クエリ文字列にidがついている場合は、編集モードで開く
    //     if(isset($request->id)){
    //         $mode = 'edit';
    //         $item = MVPresentation::find($request->id);
    //     }

    //     //ドロップダウンリスト用データ取得（#TODOキャッシュにしたい）
    //     $students = Student::all();

    //     //リダイレクト時には、セッションにalertが入ってくる可能性があるので拾う
    //     $alertComp='';
    //     if($request->session()->has('alertComp')){
    //         $alertComp = $request->session()->get('alertComp');
    //     }
    //     $alertErr='';
    //     if($request->session()->has('alertErr')){
    //         $alertErr = $request->session()->get('alertErr');
    //     }

    //     $args=[
    //         'id'=>$request->id,
    //         'mode'=>$mode,
    //         'item'=>$item,
    //         'students'=>$students,
    //         'alertComp'=>$alertComp,
    //         'alertErr'=>$alertErr,
            
    //     ];

    //     return view('mv.mvPresenRegist',$args);
    // }
    //POST
    public function confirm(Request $request){
        //クエリ文字列でmodeを受け取る
        $mode=$request->mode;
        
        if($mode=='create'){
            //Validate
            $this->validate($request, MVPresentation::$rules_create);
        }
        else if($mode=='update'){
            $this->validate($request, MVPresentation::$rules_edit);
        }

        $mvpre = new MVPresentation;
        $form = $request->all();
        unset($form['_token']);
        $mvpre->fill($form);

        $students = [Student::find($mvpre->StudentCd)];

        $args=[
            'mode' => $mode,
            'id'=>$request->id,
            'item'=>$mvpre,
            'students' => $students,
        ];
        return view('mv.presen.confirm',$args);
    }
    //POST
    public function create(Request $request){
        //validationはConfirmで実施済み

        $mvpre = new MVPresentation;
        $form = $request->all();
        unset($form['_token']);
        $mvpre->fill($form);

        //フォームにない項目をセット
        $mvpre->setUpdateColumn();

        $mvpre->save();

        //登録後の再取得
        $args=[
        ];

        return redirect()->route('mvpresen-list',$args)->with('alertComp',MessageConst::ADD_COMPLETED);
    }
    //POST
    public function update(Request $request){
        //validationはConfirmで実施済み

        $mvpre = MVPresentation::find($request->id);
        $form = $request->all();
        unset($form['_token']);
        $mvpre->fill($form);

        //フォームにない項目をセット
        $mvpre->setUpdateColumn();

        $mvpre->save();

        //登録後の再取得
        $args=[
        ];

        return redirect()->route('mvpresen-list',$args)->with('alertComp',MessageConst::EDIT_COMPLETED);
    }
    //POST
    public function delete(Request $request){
        $mvpre = MVPresentation::find($request->id);
        $mvpre->delete();

        //登録後の再取得
        $args=[
        ];

        return redirect()->route('mvpresen-list',$args)->with('alertComp',MessageConst::DELETE_COMPLETED);
    }
}
