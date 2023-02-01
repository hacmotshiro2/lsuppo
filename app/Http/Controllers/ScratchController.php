<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Hogosha;
use App\Models\Student;

use App\Consts\MessageConst;

class ScratchController extends Controller
{
    //GET
    public function index_pj(Request $request){
        //スクラッチでユーザーごとの共有プロジェクトを取得します。

        //認証情報を取得し、ログイン情報を取得する
        $user = Auth::user();
        //ログイン情報から保護者情報を取得
        $hogoshaCd = Hogosha::getHogoshaCd($user);

        //保護者コードから、該当する生徒の一覧を取得　生徒コードASCで配列に
        $students = Student::where('hogoshaCd',$hogoshaCd)->orderBy('StudentCd','asc')->get();

        //api用
        // ストリームコンテキストのオプションを作成
        $options = array(
            // HTTPコンテキストオプションをセット
            'http' => array(
                'method'=> 'GET',
                'header'=> 'Content-type: application/json; charset=UTF-8' //JSON形式で表示
            )
        );
        // ストリームコンテキストの作成
        $context = stream_context_create($options);

        //生徒ひ紐づくプロジェクト一覧を取得する
        $itemset=[];
        foreach($students as $student){
           
            // 取得URL
            // GET https://api.scratch.mit.edu/users/ScratchCat/projects
            $url = "https://api.scratch.mit.edu/users/".$student->ScratchID."/projects";
            
            $raw_data = file_get_contents($url, false,$context);

            if($raw_data!=false){
                // json の内容を連想配列として $data に格納する
                $itemset[$student->StudentCd] = json_decode($raw_data,true);
            }
        }
        $args=[
            'students'=>$students,
            'itemset'=>$itemset,
        ];
        return view('Scratch.index',$args);

    }
}
