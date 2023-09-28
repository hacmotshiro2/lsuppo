<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

use App\Models\LCoinMeisai;
use App\Consts\DBConst;
use App\Consts\MessageConst;

class LcoinList extends Component
{
    //ページロード時の設定
    public $orderColumn = "updated_at";
    public $sortOrder = "desc";
    public $sortLink = '<i class="sorticon fa-solid fa-caret-up"></i>';

    public function render()
    {
        $items=LCoinMeisai::with('absence')->orderby($this->orderColumn,$this->sortOrder)->paginate(50);

        $args = [
            'items'=>$items,
        ];
        return view('livewire.lcoin-list',$args);
    }

    public function updated(){
        //リフレッシュ
        $this->resetPage();
    }

    public function sortOrder($columnName=""){
        $caretOrder = "up";
        //今がASCならDESC。DESCならASC
        if($this->sortOrder == 'asc'){
            $this->sortOrder = 'desc';
            $caretOrder = "down";
        }else{
            $this->sortOrder = 'asc';
            $caretOrder = "up";
        } 
        $this->sortLink = '<i class="sorticon fa-solid fa-caret-'.$caretOrder.'"></i>';

        $this->orderColumn = $columnName;

    }
    //削除ボタン押下時の処理
    public function delete($id=""){

        $lcmeisai = LCoinMeisai::find($id);
        //万が一LCoinMeisaiが取得できない場合は、処理しない
        if(empty($lcmeisai)){return;}

        // //LCoinMeisaiIdが欠席情報に紐づけられている場合、削除できない。
        // $validator = Validator::make($request->all(), [
        //     'id' => 'required|lcmeisai_exists',
        // ],
        // ['id.lcmeisai_exists' => '欠席情報と紐づいているため削除できません']
        // );

        // if ($validator->fails()) {
        //     // バリデーションに失敗した場合の処理
        //     return redirect()->route('lcList')
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        //欠席情報が紐づいている場合は欠席情報のLCoinMeisaiIdを除いてから
        $absence = $lcmeisai->absence;
        if(!empty($absence)){
            $absence->LCMeisaiId = null;
            $absence->HurikaeStatus = 0; //未振替

            DB::transaction(function() use($lcmeisai,$absence){
                //UPDATE処理
                $absence->save();
                //DELETE処理
                $lcmeisai->delete();
            });
        }
        //欠席情報が紐づかない場合
        else{
            //DELETE処理
            $lcmeisai->delete();
        }
        //リダイレクト時にクエリ文字列として渡す
        $args = [
        ];

        return redirect()->route('lcList',$args)->with('alertComp',MessageConst::DELETE_COMPLETED);
    }
}
