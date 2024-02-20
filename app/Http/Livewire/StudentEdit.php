<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Request;

use App\Models\Student;
use App\Models\LR;

class StudentEdit extends Component
{
    public function mount()
    {
        $this->lrs = LR::all();

        //oldがある場合はoldからセット
        if(old('StudentCd'))
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
        }
        //oldがない場合はDBの値をセット
        else{
        
            // クエリ文字列から値を取得してプロパティに代入
            $key = Request::query('studentCd');
            if($key){
                $this->StudentCd = $key;
                $record = Student::find($key);
                if($record){
                    $this->Sei = $record->Sei;
                    $this->Mei = $record->Mei;
                    $this->Hurigana = $record->Hurigana;
                    $this->HyouziMei = $record->HyouziMei;
                    $this->HogoshaCd = $record->HogoshaCd;
                    $this->ScratchID = $record->ScratchID;
                    $this->ScratchURL = $record->ScratchURL;
                    $this->RiyouKaisiDate = $record->RiyouKaisiDate;
                    $this->RiyouShuuryouDate = $record->RiyouShuuryouDate;
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.student-edit');
    }
}
