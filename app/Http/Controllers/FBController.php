<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\FB;
use App\Models\User;
use App\Models\Hogosha;
use App\Models\Student;
use App\Models\Supporter;
use App\Models\LR;
use App\Models\ApproveHistory;
use App\Models\User2Hogosha;

use App\Http\Requests\FBRequest;
use App\Consts\AuthConst;
use App\Consts\DBConst;
use App\Consts\MessageConst;

use Illuminate\Support\Facades\Gate;

use App\Notifications\FBApprovedNotification;


class FBController extends Controller
{
    //get fb\
    public function index(Request $request){
        //認証情報を取得し、保護者コードを取得する
        $user = Auth::user();
        $hogoshaCd = Hogosha::getHogoshaCd($user);

        $items = FB::getFBListByHogoshaCd($hogoshaCd);

        $arg = [
            'items' => $items,
        ];

        return view('FB.index',$arg);
    }
    //get fb\splist
    public function index_sp(Request $request){
        // No.Ph.2.2 h.hashimoto 2023/10/22 ------>
        // Livewire側に移管するため、本ControllerではDBアクセスしない
        // #TODO 自LRに絞るかは要検討
        // $items = FB::getAllFBList(); //通常のallでとると、indexの場合とプロパティが変わるので。（例StudentName）
        // <------  No.Ph.2.2 h.hashimoto 2023/10/22 

        //Deleteからのリダイレクト時には、セッションにalertが入ってくる可能性があるので拾う
        $alertComp='';
        if($request->session()->has('alertComp')){
            $alertComp = $request->session()->get('alertComp');
        }
        $alertErr='';
        if($request->session()->has('alertErr')){
            $alertErr = $request->session()->get('alertErr');
        }
   
        $arg = [
            'alertComp'=>$alertComp,
            'alertErr'=>$alertErr,
            // No.Ph.2.2 h.hashimoto 2023/10/22 ------>
            // 'items' => $items,
            // <------  No.Ph.2.2 h.hashimoto 2023/10/22 
        ];

        // No.Ph.2.2 h.hashimoto 2023/10/22 ------>
        // 保護者と共用だったが、サポーター用を作成する
        // return view('FB.index',$arg);
        return view('FB.list-sp',$arg);
        // <------  No.Ph.2.2 h.hashimoto 2023/10/22 

    }
    // /fb/detail/{fbNo} サポーターも参照する
    // public function fbDetail(Request $request,$fbNo){
    public function fbDetail(Request $request){

        $fbNo = $request->fbNo;

        $item=FB::where('FbNo',$fbNo)->first();

        //権限チェック　だめならexception
        Gate::authorize('view_fb_detail',$item);

        //リダイレクト時には、セッションにalertが入ってくる可能性があるので拾う
        $alertComp='';
        if($request->session()->has('alertComp')){
            $alertComp = $request->session()->get('alertComp');
        }
        $alertErr='';
        if($request->session()->has('alertErr')){
            $alertErr = $request->session()->get('alertErr');
        }

        //閲覧日の更新
        //保護者の時だけ
        $user = Auth::user();
        if($user->userType==AuthConst::USER_TYPE_HOGOSHA){
            //初回閲覧日がnullの場合
            if(is_null($item->FirstReadDate)){
                $item->FirstReadDate = date("Y-m-d H:i:s");
            }
            //最終閲覧日
            $item->LastReadDate =  date("Y-m-d H:i:s");

            //更新
            $item->setUpdateColumn();
            $item->save();
        }
        //承認履歴
        $lah = ApproveHistory::where('TargetToken',$item->ApprovalToken)->orderBy('HasseiDate','desc')->get();
       
        //テンプレートに渡す引数
        $args=[
            'item'=>$item,
            'alertComp'=>$alertComp,
            'alertErr'=>$alertErr,
            'lah'=>$lah,
        ];

        return view('FB.detail',$args);

    }
    //fb\add
    public function add(Request $request){

        $user = Auth::user();

        //ドロップダウンリスト用データ取得（#TODOキャッシュにしたい）
        $students = Student::all();
        $lrs = LR::all();

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


        //テンプレートに渡す変数
        $args = [
            'mode' =>'add',
            'students'=>$students,
            'lrs'=>$lrs,
            'ShoriSupporterCd'=>$supporterCd,
            'alertComp'=>$alertComp,
            'alertErr'=>$alertErr,
        ];
        return view('FB.regist',$args);
    }
    // post fb\add
    public function addpost(FBRequest $request){

        //画面上で入力させるが、サポーターが所属するLRに所属する生徒のみにする必要あり→バリデーションへ

        $user = Auth::user();


        $fb = new FB;
        $form = $request->all();
        unset($form['_token']);
        //フォームから値をセット
        $fb->fill($form);
        //フォームにはない値をセット
        $fb->FbShurui=1;
        $fb->FirstReadDate=null;
        $fb->LastReadDate=null;
        $fb->KinyuuDate=date("Y-m-d H:i:s");
        // $fb->ShouninDate=date("Y-m-d H:i:s");
        $fb->ShouninStatus=DBConst::SHOUNIN_STATUS_APPROVING;
        // $fb->ShouninSupporterCd=$request->KinyuuSupporterCd;
        $fb->ApprovalToken = uniqid('',true);

        //Update系のセット
        $fb->setUpdateColumn();

        //承認履歴
        $ah = new ApproveHistory;
        $ah->TargetToken = $fb->ApprovalToken;
        $ah->HasseiDate = date("Y-m-d H:i:s");
        $ah->ShouninStatus=DBConst::SHOUNIN_STATUS_APPROVING;
        #TODO
        $ah->Comment = "";
        $ah->TourokuSupporterCd = $request->ShoriSupporterCd;
        $ah->setUpdateColumn();

        //フィードバック明細及び承認履歴に更新
        DB::transaction(function() use($fb,$ah){
            $ah->save();//Insert
            $fb->save();//Insert

        });
        

        //クエリ文字列としてリダイレクト先に渡す
        $args = [
          //現状特になし
        ];

        return redirect()->route('fbAdd',$args)->with('alertComp',MessageConst::ADD_COMPLETED);
    }
    //get fb\edit
    // public function edit(Request $request,$fbNo){
    public function edit(Request $request){
        $fbNo = $request->fbNo;
        $fb = FB::find($fbNo);
        
        //ポリシーチェック　だめなら参照ページへリダイレクト
        $policyResponse = Gate::inspect('edit_fb',$fb);
        if($policyResponse->denied()){
            //メッセージはポリシーチェックの中身で区分け
            return redirect()->route('fbDetail',['fbNo'=>$fbNo])->with('alertErr',$policyResponse->message());
        }

        $user = Auth::user();

        //ドロップダウンリスト用データ取得（#TODOキャッシュにしたい）
        //生徒の変更は行えないようにする
        $students = Student::where('StudentCd',$fb->StudentCd)->get();
        $lrs = LR::all();

        //userとsupporterを紐づけて、セット
        $supporterCd = Supporter::getSupporterCd($user);

        //承認履歴
        $lah = ApproveHistory::where('TargetToken',$fb->ApprovalToken)->orderBy('HasseiDate','desc')->get();

        $arg = [
            'fbNo' =>$fbNo,
            'mode' =>'edit',
            'form' =>$fb,
            'students'=>$students,
            'lrs'=>$lrs,
            'ShoriSupporterCd'=>$supporterCd,
            'lah'=>$lah,
        ];
        return view('FB.regist',$arg);
    }
    // post fb\edit
    // public function editpost(FBRequest $request,$fbNo){
    public function editpost(FBRequest $request){

        $fbNo = $request->fbNo;

        //画面上で入力させるが、サポーターが所属するLRに所属する生徒のみにする必要あり→バリデーションへ


        $user = Auth::user();
       
        $fb = FB::where('FbNo',$fbNo)->first();
        $form = $request->all();
        unset($form['_token']);
        //フォームから値をセット
        $fb->fill($form);
        //フォームにはない値をセット
        $fb->KinyuuDate=date("Y-m-d H:i:s");
        #TODO承認機能
        // $fb->ShouninDate=date("Y-m-d H:i:s");
        $fb->ShouninStatus=DBConst::SHOUNIN_STATUS_APPROVING;
        // $fb->ShouninSupporterCd=$request->KinyuuSupporterCd;

        //Update系のセット
        $fb->setUpdateColumn();

        //承認履歴
        $ah = new ApproveHistory;
        $ah->TargetToken = $fb->ApprovalToken;
        $ah->HasseiDate = date("Y-m-d H:i:s");
        $ah->ShouninStatus=DBConst::SHOUNIN_STATUS_APPROVING;
        $ah->Comment = $request->Comment;
        $ah->TourokuSupporterCd = $request->ShoriSupporterCd;
        $ah->setUpdateColumn();

        //フィードバック明細及び承認履歴に更新
        DB::transaction(function() use($fb,$ah){
            $ah->save();//Insert
            $fb->save();//Update

        });
        

        //fbNoだけ渡して後は、リダイレクト先のGetコントローラに任せる
        $args = [
            'fbNo' => $fbNo,
        ];

        return redirect()->route('fbDetail',$args)->with('alertComp',MessageConst::EDIT_COMPLETED);//http://127.0.0.1:8000/fb/detail?fbNo=30

    }
    // post fb\delete
    public function deletepost(FBRequest $request){

        $fbNo = $request->fbNo;

        $user = Auth::user();
        
        $fb = FB::where('FbNo',$fbNo)->first();
     

        //承認履歴
        $ah = new ApproveHistory;
        $ah->TargetToken = $fb->ApprovalToken;
        $ah->HasseiDate = date("Y-m-d H:i:s");
        $ah->ShouninStatus=DBConst::SHOUNIN_STATUS_DELETED;
        #TODO
        $ah->Comment = $request->Comment;
        $ah->TourokuSupporterCd = $request->ShoriSupporterCd;
        $ah->setUpdateColumn();

        //フィードバック明細及び承認履歴に更新
        DB::transaction(function() use($fb,$ah){
            $ah->save();//Insert
            $fb->delete();//Delete

        });
        

        //fbNoだけ渡して後は、リダイレクト先のGetコントローラに任せる
        $args = [
        ];

        return redirect()->route('fbIndex_sp',$args)->with('alertComp',MessageConst::DELETE_COMPLETED);//http://127.0.0.1:8000/fb/detail?fbNo=30

    }
    //POST
    public function approve(Request $request){
        //hiddenからfbNo取得
        $fbNo = $request->fbNo;
        //FBテーブルから取得
        $fb = FB::where('FbNo',$fbNo)->first();

        //ポリシーチェック　だめならexception
        Gate::authorize('approve_fb',$fb);

        //ユーザーからサポーターコードを取得
        $user = Auth::user();
        $supporterCd = Supporter::getSupporterCd($user);

        //承認機能
        $fb->ShouninDate = date("Y-m-d H:i:s");
        $fb->ShouninStatus=DBConst::SHOUNIN_STATUS_APPROVED;
        $fb->ShouninSupporterCd=$supporterCd;

        //承認履歴
        $ah = new ApproveHistory;
        $ah->TargetToken = $fb->ApprovalToken;
        $ah->HasseiDate = date("Y-m-d H:i:s");
        $ah->ShouninStatus=DBConst::SHOUNIN_STATUS_APPROVED;
        $ah->Comment = $request->Comment;
        $ah->TourokuSupporterCd = $supporterCd;
        $ah->setUpdateColumn();

        //フィードバック明細及び承認履歴に更新
        DB::transaction(function() use($fb,$ah){
            $ah->save();//Update
            $fb->save();//Insert

        });


        //承認が完了したメールを送る
        //サポーターが登録するので、ログインユーザーではなく、フィードバックの保護者に送る
        $student = Student::where('StudentCd',$fb->StudentCd)->first();
        $u2hs = User2Hogosha::where('HogoshaCd',$student->HogoshaCd)->get();
        //一人の生徒に対して複数の保護者を登録できるので
        foreach($u2hs as $u2h){
            $user = User::find($u2h->user_id);
            if(!is_null($user)){
                // $user->notify(new FBApprovedNotification($user->name));
                $user->notify(new FBApprovedNotification($user->name,mb_substr($fb->Detail,0,140),$fbNo));
            }
        }
        //引数だけ渡して、後はリダイレクトした方がいい
        $args=[
            'fbNo'=>$fbNo,
        ];

        return redirect()->route('fbDetail',$args)->with('alertComp',MessageConst::APPLOVED);//http://127.0.0.1:8000/fb/detail?fbNo=30
    }
    //POST
    public function decline(Request $request){
        //hiddenからfbNo取得
        $fbNo = $request->fbNo;
        //FBテーブルから取得
        $fb = FB::where('FbNo',$fbNo)->first();

        //ポリシーチェック　だめならexception
        Gate::authorize('decline_fb',$fb);

        //ユーザーからサポーターコードを取得
        $user = Auth::user();
        $supporterCd = Supporter::getSupporterCd($user);

        //承認機能
        $fb->ShouninDate = date("Y-m-d H:i:s");
        $fb->ShouninStatus=DBConst::SHOUNIN_STATUS_RETURN;
        // No.不具合対応 h.hashimoto 2023/10/25 ------>
        // 取り下げのときはセットしない
        // $fb->ShouninSupporterCd=$supporterCd;
        // <------  No.不具合対応 h.hashimoto 2023/10/25 

        //承認履歴
        $ah = new ApproveHistory;
        $ah->TargetToken = $fb->ApprovalToken;
        $ah->HasseiDate = date("Y-m-d H:i:s");
        $ah->ShouninStatus=DBConst::SHOUNIN_STATUS_RETURN;
        $ah->Comment = "";
        $ah->Comment = $request->Comment;
        $ah->TourokuSupporterCd = $supporterCd;
        $ah->setUpdateColumn();

        //フィードバック明細及び承認履歴に更新
        DB::transaction(function() use($fb,$ah){
            $ah->save();//Update
            $fb->save();//Insert

        });

    
        //引数だけ渡して、後はリダイレクトした方がいい
        $args=[
            'fbNo'=>$fbNo,
        ];

        return redirect()->route('fbDetail',$args)->with('alertComp',MessageConst::DECLINED);//http://127.0.0.1:8000/fb/detail?fbNo=30

    }

}
