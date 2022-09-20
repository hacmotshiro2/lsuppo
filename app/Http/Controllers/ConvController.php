<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Consts\MessageConst;

use App\Models\ConvTXTHead;
use App\Models\ConvTXTMeisai;
use App\Models\LR;
use App\Models\Student;
use App\Models\Supporter;
use App\Models\DdlItem;

class ConvController extends Controller
{
    //GET /conv/
    public function index(Request $request){

        $lH = ConvTXTHead::orderBy('SessionDate','desc')->get();
        $args=[
            'lConvH' => $lH,
        ];
        return view('Conv.index',$args);
    }
    //GET /conv/
    //一つの会話記録ファイルの中身を一覧で表示する
    public function detail(Request $request){

        //クエリ文字列から、ヘッダーID、オリジナルスピーカーを取得する
        $headerId = $request->headerId;
        $orgSpeaker = isset($request->orgSpeaker)?$request->orgSpeaker:null;//リダイレクト時のみ

        //参加者の一覧を取得する
        $speakers = ConvTXTMeisai::where('Header_id',$headerId)->distinct()->select('OriginalSpeaker')->get();

        //ドロップダウンリストを作る
        //発言者
        $ddlOriginals = [];
        foreach($speakers as $speaker){
            //名称、名称でDDLItemをつくる（コードがないため）
            array_push($ddlOriginals,new DdlItem($speaker->OriginalSpeaker,$speaker->OriginalSpeaker));
        }
        //候補者
        $ddlCandidates=[];
        foreach(Student::all() as $student){
            array_push($ddlCandidates,new DdlItem($student->StudentCd,$student->HyouziMei));
        }
        foreach(Supporter::all() as $supporter){
            array_push($ddlCandidates,new DdlItem($supporter->SupporterCd,$supporter->HyouziMei));
        }

        //データベースから明細を取得
        //クエリ文字列に、orgSpeakerがセットされていれば、絞り込む
        $lines;
        if(isset($orgSpeaker)){
            $lines = ConvTXTMeisai::where('Header_id',$headerId)->where('OriginalSpeaker',$orgSpeaker)->orderBy('LineCount','asc')->paginate(100);
        }
        else{
            $lines = ConvTXTMeisai::where('Header_id',$headerId)->orderBy('LineCount','asc')->paginate(100);
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
   
        //idが連携されてきた場合（editMeisaiからのリダイレクト）は、#id999をURLにつける。（アンカー）
        $id=null;
        if(!empty($request->id)){
            $id=$request->id;
        }
        $args=[
            'headerId'=>$headerId,
            'id'=>$id,
            'speakers' => $speakers,
            'lines' => $lines,
            'mode' => 'add',
            'ddlOriginals' => $ddlOriginals,
            'ddlCandidates' => $ddlCandidates,
            'item' => '',
            'alertComp'=>$alertComp,
            'alertErr'=>$alertErr,
        ];
        return view('Conv.detail',$args);
    }
    //Conv/Detail/
    public function filter(Request $request){
        //クエリ文字列から値を取得
        $headerId = $request->headerId;
        $orgSpeaker = $request->orgSpeaker;

          //そのままリダイレクトGetコントローラに任せる
          $args = [
            'headerId' => $headerId,
            'orgSpeaker' => $orgSpeaker,
        ];
    
        return redirect()->route('convDetail',$args);
    }
 
    //POST /conv/replace
    public function replace(Request $request){
        $headerId = $request->headerId;

        //チェックボックスの値を取得
        $isForce = $request->chkForce;

        //オリジナル発言者で更新対象を取得
        $lines;
        if(isset($isForce)){
            //すでに更新されているものも含めて置き換える場合
            $lines=ConvTXTMeisai::where([
                ['header_id',$headerId],
                ['OriginalSpeaker',$request->ddlOr]
                ])->get();
        }
        else{
            //未更新に限って更新する
            $lines=ConvTXTMeisai::where([
                ['header_id',$headerId],
                ['OriginalSpeaker',$request->ddlOr],
                ])
                ->whereNull('SpeakerCd')
                ->whereNull('Speaker')
                ->get();
        }
        
        //変換先ドロップダウンリストから、コードと名前を取得する
        $updateCdName =DdlItem::separate($request->ddlCan);

        //更新処理
        foreach($lines as $line){
            $line->SpeakerCd = $updateCdName[0];
            $line->Speaker = $updateCdName[1];

            $line->setUpdateColumn();
        }

        DB::transaction(function() use($lines){
            foreach($lines as $line){
                $line->save();//Update
            }
        });


        //headerIdだけ渡して後は、リダイレクト先のGetコントローラに任せる
        $args = [
            'headerId' => $headerId,
        ];
    
        return redirect()->route('convDetail',$args)->with('alertComp',MessageConst::SPEAKER_EDITED);
    }
    //GET Conv/editMeisai/
    public function editMeisai(Request $request){
        //クエリ文字列から値を取得
        $id = $request->id;
        //データベースから該当行を取得
        $line = ConvTXTMeisai::find($id);

        //ドロップダウンリストを作る
        //候補者
        $ddlCandidates=[];
        foreach(Student::all() as $student){
            array_push($ddlCandidates,new DdlItem($student->StudentCd,$student->HyouziMei));
        }
        foreach(Supporter::all() as $supporter){
            array_push($ddlCandidates,new DdlItem($supporter->SupporterCd,$supporter->HyouziMei));
        }


        $args = [
            'item'=>$line,
            'ddlCandidates'=>$ddlCandidates
        ];

        return view('Conv.editmeisai',$args);

    }
    //POST conv/updateMeisai
    public function updateMeisai(Request $request){
        //hiddenからidを取得
        $id = $request->id;
        //データベースから該当行を取得
        $line = ConvTXTMeisai::find($id);

        //発言者コードがnone「この中にない」の場合は特殊処理
        if($request->ddlSpeakerCd=='none'){
            //発言者コードはNULL
            $line->SpeakerCd = null;
            //発言者
            if(!empty($request->Speaker)){
                //発言者　セットされていれば更新
                $line->Speaker = $request->Speaker;
            }
        }
        else{
            //発言者コード
            if(!empty($request->ddlSpeakerCd)){
                //変換先ドロップダウンリストから、コードと名前を取得する
                $updateCdName =DdlItem::separate($request->ddlSpeakerCd);
                $line->SpeakerCd = $updateCdName[0];
                $line->Speaker = $updateCdName[1];
            }
        }
        //会話
        if(!empty($request->Conversation)){
            $line->Conversation = $request->Conversation;
        }
        //コメント
        if(!empty($request->Comment)){
            $line->Comment = $request->Comment;
        }
        //更新系のカラムをセット
        $line->setUpdateColumn();
        //更新処理
        $line->save();

        $args = [
            'headerId' => $line->Header_id,
            'id' => $id,
        ];
    
        return redirect()->route('convDetail',$args)->with('alertComp',MessageConst::EDIT_COMPLETED);
    }
    /***************************
    * ファイルアップロード系
    ****************************/

    //GET /conv/upload/
    public function upload(Request $request){

         //リダイレクト時には、セッションにalertが入ってくる可能性があるので拾う
         $alertComp='';
         if($request->session()->has('alertComp')){
             $alertComp = $request->session()->get('alertComp');
         }
         $alertErr='';
         if($request->session()->has('alertErr')){
             $alertErr = $request->session()->get('alertErr');
         }
         
         $lrs = LR::all();

         $args=[
             'alertComp'=>$alertComp,
             'alertErr'=>$alertErr,
             'lrs'=>$lrs,
         ];
 
        return view('Conv.upload',$args);
    }
    //POST /conv/confirm/
    public function confirm(Request $request){

        //ヘッダー情報の作成
        $cth = new ConvTXTHead();

        $cth->FileName = $request->file('uploadTXT')->getClientOriginalName();
        $cth->UploadedDatetime = date("Y/m/d H:i:s");
        $cth->SessionDate = $request->SessionDate;
        $cth->FileID = 1;//#TODO
        $cth->Comment = $request->Comment;
        $cth->LearningRoomCd = $request->LearningRoomCd;

        // ファイルを読み込みモードで開く
        // $fp = fopen($request->uploadTXT, "r");
        $file = $request->file('uploadTXT');
        $file_path = $file->path($file);
        $contents=file_get_contents($file_path,'r');

        $args=[
            'cth'=>$cth,
            'contents'=>$contents
        ];

        return view('Conv.confirm',$args);

    }
    //POST /conv/upload/
    public function uploadpost(Request $request){

        //ヘッダー情報の作成
        $cth = new ConvTXTHead();

        $form = $request->all();
        unset($form['_token']);
        unset($form['contents']);
        $cth->fill($form);

        $cth->UploadedDatetime = date("Y/m/d H:i:s");

        //update系セット
        $cth->setUpdateColumn();


        //明細情報の作成
        $ctms=[];
        $ctm=new ConvTXTMeisai();

        //複数行のコンテンツを1行ずつに分ける
        //改行コードを1種に揃えた上で、配列に分ける
        $contents = explode("\n",str_replace(array("\r\n","\r","\n"),"\n",$request->contents));
        // print count($contents);

        // ファイルを1行ずつ取得する
        $lineCount=0;
        $originalSpeaker="";
        $originalTime=null;
        $canInsert=false;

        foreach($contents as $line){
            /**************** 
            * ファイルイメージ
            * 参加者 1 0:00:00
            * 電車だよ自転車
            * 参加者 2 0:00:01
            * あ、大変や、
            * 参加者 1 0:00:03
            * 持ってるわけねえだろ、
            *****************/
            // print $line;
            // print '<br>';
            // print preg_match('/^参加者.*/u',$line);
            // print '<br>';
            if(preg_match('/^参加者.*/u',$line)){
                //参加者～で始まる行の時
                $lineCount+=1;

                //半角スペースで　参加者と時間がわかれるので　例）参加者 4 1:32:26
                $v= explode(" ",$line);
                $originalSpeaker = $v[0].$v[1];
                $originalTime = $v[2];

                $canInsert=true;
            }
            else{
                if($canInsert){
                    //会話行の時
                    $ctm = new ConvTXTMeisai();
                    $ctm->LineCount = $lineCount;
                    $ctm->OriginalSpeaker = $originalSpeaker;
                    $ctm->OriginalTime = $originalTime;
                    $ctm->OriginalConversation = is_null($line)?"":$line;
                    $ctm->Conversation =  is_null($line)?"":$line;
                    $ctm->setUpdateColumn();

                    //配列にためていく
                    array_push($ctms,$ctm);

                    //変数を初期化
                    $ctm = null;
                    $canInsert=false;
                }
            }
        }

        //会話ヘッダ及び明細に更新
        DB::transaction(function() use($cth,$ctms){
            //ヘッダーの更新
            $cth->save();//Insert
            
            //明細の更新
            // $ctms[0]->save();
            foreach($ctms as $ctm){
                $ctm->Header_id= $cth->id;//今更新したヘッダーのIDをセット
                $ctm->save();//Insert
            }
        });
                
        
        $args=[
        ];

    //    return view('Conv.upload',$args);
        return redirect()->route('conv-upload')->with('alertComp',MessageConst::UPLOAD_COMPLETED);
    }
}
