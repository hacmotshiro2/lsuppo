<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\LR;

class HogoshaCreate extends Component
{
    public $Sei;
    public $Mei;
    public $Hurigana;
    public $RiyouKaisiDate;
    public $RiyouShuuryouDate;
    public $lrs; //ViewComposerでセットさせる想定だったが、うまくいかないのでmount()で

    public function mount()
    {
        //oldのセット
        $this->Sei = old('Sei');
        $this->Mei = old('Mei');
        $this->Hurigana = old('Hurigana');
        $this->RiyouKaisiDate = old('RiyouKaisiDate');
        $this->RiyouShuuryouDate = old('RiyouShuuryouDate');

        $this->lrs = LR::all();
    }
    public function render()
    {
        return view('livewire.hogosha-create');
    }
}
