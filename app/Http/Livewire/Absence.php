<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Absence as AbModel;


class Absence extends Component
{
    
    //ページロード時の設定
    public $orderColumn = "created_at";
    public $sortOrder = "desc";
    public $sortLink = '<i class="sorticon fa-solid fa-caret-up"></i>';

    public function render()
    {
        //student という名前のリレーションシップを eager loading 
        $items = AbModel::with('student')->with('supporter')->orderby($this->orderColumn,$this->sortOrder)->paginate(30);
        $args=[
            'absences' => $items,
        ];
  
        return view('livewire.absence',$args);
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
