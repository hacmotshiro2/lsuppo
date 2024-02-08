<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

use App\Models\MVPresentation;
use App\Consts\DBConst;
use App\Consts\MessageConst;


class MvList extends Component
{
    use WithPagination;
 
    //ページロード時の設定
    public $orderColumn = "created_at";
    public $sortOrder = "desc";
    public $sortLink = '<i class="sorticon fa-solid fa-caret-up"></i>';

    public function render()
    {
        $items=MVPresentation::orderby($this->orderColumn,$this->sortOrder)->paginate(50);

        $args = [
            'items'=>$items,
        ];

        return view('livewire.mv-list',$args);
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
