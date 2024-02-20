<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;

use App\Models\Supporter;

class LsuppoSbSupporter extends Component
{
    public $isRO = false; //readonly
    public $defaultValue;

    public $showresult = false; // – Using this toggle the suggestion list container.
    public $search = ""; //– For data binding.
    public $records; //– Store fetched records.
    public $fDetails;  //– Store clicked employee data.

    /* memo
    * RealTimeValidationを実装しようと思ったが、やめた
    * テキストボックスは、名前検索にも使うので、いちいちidでValidationされたくない
    * name属性を固定にしないといけない（nameに合わせたrulesの定義など）
    * ruleやmessageをFormRequest側と二重管理になってしまう
    * 以上のようなやっかいなことをしてまでリアルタイムにする便益が少ない。
    */

    /* memo2
    * nameを上位から指定させる（汎用的にする）ことを試みたが、
    * いろんなとこに影響するのでやめた。
    */

    public function mount(){
        $this->search = $this->defaultValue;

        //ここで指定してあげないと、空白になる。
        if(old('SupporterCd')){
            $this->search = old('SupporterCd');
        }
    }

    // Fetch records
    public function searchResult(){

        //UserDetailはクリアする
        $this->fDetails=null;

        if(!empty($this->search)){

            //もしIDが入力されて、レコードにヒットすれば、検索画面は出さない
            $record = Supporter::find($this->search);
            if($record){
                $this->search = $record->SupporterCd;
                $this->fDetails = $record;
                $this->showresult = false;
            }
            //有効なID以外が入力された場合
            else{

                $this->records = Supporter::orderby('SupporterCd','asc')
                        ->where('SupporterCd','like',$this->search.'%')
                        ->orWhere('sei','like','%'.$this->search.'%')
                        ->orWhere('Mei','like','%'.$this->search.'%')
                        ->orWhere('HyouziMei','like','%'.$this->search.'%')
                        ->orWhere('Hurigana','like','%'.$this->search.'%')
                        ->get();

                $this->showresult = true;
            }
        }else{
            $this->showresult = false;
        }
    }

    // Fetch record by ID
    public function fetchDetail($SupporterCd = ''){

        // Log::info('fetchHogoshaDetail',[]);
        $record = Supporter::find($SupporterCd);

        $this->search = $record->SupporterCd;
        $this->fDetails = $record;
        $this->showresult = false;
    }


    public function render()
    {
        return view('livewire.lsuppo-sb-supporter');
    }


}
