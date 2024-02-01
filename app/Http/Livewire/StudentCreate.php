<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\LR;

class StudentCreate extends Component
{
    public function mount()
    {
        //oldのセット
        $this->Sei = old('Sei');
        $this->Mei = old('Mei');
        $this->Hurigana = old('Hurigana');
        $this->HyouziMei = old('HyouziMei');
        $this->HogoshaCd = old('HogoshaCd');
        $this->ScratchID = old('ScratchID');
        $this->ScratchURL = old('ScratchURL');
        $this->RiyouKaisiDate = old('RiyouKaisiDate');
        $this->RiyouShuuryouDate = old('RiyouShuuryouDate');

        $this->lrs = LR::all();
    }
    public function render()
    {
        return view('livewire.student-create');
    }
}
