<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Request;

use App\Models\LR;
use App\Models\Hogosha;


class HogoshaEdit extends Component
{
    public $HogoshaCd; //Key
    public $Sei;
    public $Mei;
    public $Hurigana;
    public $RiyouKaisiDate;
    public $RiyouShuuryouDate;
    public $lrs; //ViewComposerでセットさせる想定だったが、うまくいかないのでmount()で

    public function mount()
    {
        $this->lrs = LR::all();

        //oldがある場合はoldからセット
        if(old('HogoshaCd'))
        {
            //oldのセット
            $this->Sei = old('Sei');
            $this->Mei = old('Mei');
            $this->Hurigana = old('Hurigana');
            $this->RiyouKaisiDate = old('RiyouKaisiDate');
            $this->RiyouShuuryouDate = old('RiyouShuuryouDate');
        }
        //oldがない場合はDBの値をセット
        else{
        
            // クエリ文字列から値を取得してプロパティに代入
            $key = Request::query('hogoshaCd');
            if($key){
                $this->HogoshaCd = $key;
                $hogosha = Hogosha::find($key);
                if($hogosha){
                    $this->Sei = $hogosha->Sei;
                    $this->Mei = $hogosha->Mei;
                    $this->Hurigana = $hogosha->Hurigana;
                    $this->RiyouKaisiDate = $hogosha->RiyouKaisiDate;
                    $this->RiyouShuuryouDate = $hogosha->RiyouShuuryouDate;
                }
            }
        }
    }
    public function render()
    {
        return view('livewire.hogosha-edit');
    }
}
