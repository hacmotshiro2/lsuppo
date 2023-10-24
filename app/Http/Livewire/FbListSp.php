<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

use App\Models\FB;
use App\Models\LR;
use App\Consts\DBConst;
use App\Consts\MessageConst;

class FbListSp extends Component
{
    use WithPagination;

    //ページロード時の設定
    public $orderColumn = null;
    public $sortOrder = null;
    public $sortLink = '<i class="sorticon fa-solid fa-caret-up"></i>';
    //選択中のLearningRoomCd
    public $selectedLRCd = "999999";

    public function __construct()
    {
        //ページロード時のみ呼べばいい


        //LerarningRoomの一覧をつくる(Livewire変数にしたくないのでここで宣言、セットする)
        $this->lrs = LR::orderBy('LearningRoomCd','asc')->get();

        //一番最初のLearningRoomCdを選択
        $this->selectedLRCd = $this->lrs->first()->LearningRoomCd;

    }

    public function render()
    {
        $items = FB::getAllFBListByLRCode($this->selectedLRCd, $this->orderColumn, $this->sortOrder);

        $args = [
            'items' => $items,
        ];
        return view('livewire.fb-list-sp',$args);
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
}
