<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\LCZiyuu;

use App\Consts\MessageConst;

class LCZiyuuController extends Controller
{
    //
    
    //GET マスタメンテ画面へ
    public function add(Request $request){

        $mode = 'add';
        $item = new LCZiyuu;

        //クエリ文字列にZiyuuCdがついている場合は、編集モードで開く
        if(isset($request->ZiyuuCd)){
            $item = LCZiyuu::find($request->ZiyuuCd);
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

        //全件取得
        $items = LCZiyuu::all();


        $args=[
            'alertComp'=>$alertComp,
            'alertErr'=>$alertErr,
            'mode'=>$mode,
            'item'=>$item,
            'items'=>$items,
        ];

        return view('LCZiyuu.add',$args);
    }
    //POST 新規登録
    public function create(Request $request){
        //Validation
        $this->validate($request, LCZiyuu::$rules_create);
        
        //登録処理
        $lcz = new LCZiyuu;
        
        $form = $request->all();
        unset($form['_token']);
        $lcz->fill($form);

        $lcz->setUpdateColumn();

        $lcz->save();

        //リダイレクト
        return redirect()->route('lcziyuu-add',[])->with('alertComp',MessageConst::ADD_COMPLETED);
    }
    //POST 更新
    public function edit(Request $request){
        //Validation
        $this->validate($request, LCZiyuu::$rules_edit);

        //登録処理
        $lcz = LCZiyuu::find($request->ZiyuuCd);
        
        $form = $request->all();
        unset($form['_token']);
        $lcz->fill($form);

        $lcz->setUpdateColumn();

        $lcz->save();
        
        //リダイレクト
        return redirect()->route('lcziyuu-add',[])->with('alertComp',MessageConst::EDIT_COMPLETED);
    }
    //POST 削除
    public function delete(Request $request){

        $lcz = LCZiyuu::find($request->ZiyuuCd);
        $lcz->delete();

        //リダイレクト
        return redirect()->route('lcziyuu-add',[])->with('alertComp',MessageConst::DELETE_COMPLETED);
    }
}
