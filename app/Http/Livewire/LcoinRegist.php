<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

use App\Models\Absence as AbModel;
use App\Models\User;
use App\Models\Student;
use App\Models\LCZiyuu;
use App\Models\Supporter;


class LcoinRegist extends Component
{
    
    //ページロード時の設定
    public $orderColumn = "created_at";
    public $sortOrder = "desc";
    public $sortLink = '<i class="sorticon fa-solid fa-caret-up"></i>';
    public $selected_id = 0;
    public $mode = "add";
    public $isReadOnly = true;

    public function render()
    {
        //student という名前のリレーションシップを eager loading 
        $items = AbModel::with('student')->with('supporter')
        ->whereNull('LCSwappedDatetime')
        ->orderby($this->orderColumn,$this->sortOrder)
        ->paginate(5);

        $user = Auth::user();

        //ドロップダウンリスト用データ取得（#TODOキャッシュにしたい）
        $students = Student::all();
        $ziyuus = LCZiyuu::all();

        //userとsupporterを紐づけて、セット
        $supporterCd = Supporter::getSupporterCd($user);

        $args=[
            'absences' => $items,
            'students' => $students,
            'ziyuus' => $ziyuus,
            'TourokuSupporterCd' => $supporterCd,
        ];

        return view('livewire.lcoin-regist',$args);
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

    public function selectAb($id=0){
        $this->selected_id = $id;

        if($id==0){
            $this->isReadOnly = true;
        }
        else{
            $this->isReadOnly = false;
        }

    }

    /* #TODO
    LCコイン情報や欠席情報への遷移ボタンを追加
    選択ボタンの色見を制御　選択中のときに見え方が変わるように
    事由とコインのJSロジックをLivewireに移管
    */
}
