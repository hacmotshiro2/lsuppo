<?php

namespace App\Http\Livewire;
use Illuminate\Support\Facades\Request;

use Livewire\Component;
use App\Models\LR;
use App\Models\Supporter;

class SupporterEdit extends Component
{
    public $SupporterCd; //Key
    public $Sei;
    public $Mei;
    public $Hurigana;
    public $HyouziMei;
    public $RiyouKaisiDate;
    public $RiyouShuuryouDate;
    public $authlevel;
    public $lrs; //ViewComposerでセットさせる想定だったが、うまくいかないのでmount()で

    public function mount()
    {
        $this->lrs = LR::all();

        //oldがある場合はoldからセット
        if(old('SupporterCd'))
        {
            //oldのセット
            $this->Sei = old('Sei');
            $this->Mei = old('Mei');
            $this->Hurigana = old('Hurigana');
            $this->HyouziMei = old('HyouziMei');
            $this->RiyouKaisiDate = old('RiyouKaisiDate');
            $this->RiyouShuuryouDate = old('RiyouShuuryouDate');
            $this->authlevel = old('authlevel');
        }
        //oldがない場合はDBの値をセット
        else{
        
            // クエリ文字列から値を取得してプロパティに代入
            $key = Request::query('supporterCd');
            if($key){
                $this->SupporterCd = $key;
                $record = Supporter::find($key);
                if($record){
                    $this->Sei = $record->Sei;
                    $this->Mei = $record->Mei;
                    $this->Hurigana = $record->Hurigana;
                    $this->HyouziMei = $record->HyouziMei;
                    $this->RiyouKaisiDate = $record->RiyouKaisiDate;
                    $this->RiyouShuuryouDate = $record->RiyouShuuryouDate;
                    $this->authlevel = $record->authlevel;
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.supporter-edit');
    }
}
