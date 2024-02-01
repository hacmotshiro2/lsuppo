<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\LR;

class SupporterCreate extends Component
{
   
    public function mount()
    {
        //oldのセット
        $this->Sei = old('Sei');
        $this->Mei = old('Mei');
        $this->Hurigana = old('Hurigana');
        $this->HyouziMei = old('HyouziMei');
        $this->RiyouKaisiDate = old('RiyouKaisiDate');
        $this->RiyouShuuryouDate = old('RiyouShuuryouDate');
        $this->authlevel = old('authlevel');

        $this->lrs = LR::all();
    }
    public function render()
    {
        return view('livewire.supporter-create');
    }


}
