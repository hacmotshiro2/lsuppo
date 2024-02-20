<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;

use App\Models\Hogosha;

class LsuppoSbHogosha extends Component
{
    public $isRO = false; //readonly
    public $defaultValue;

    public $showresult = false; // – Using this toggle the suggestion list container.
    public $search = ""; //– For data binding.
    public $records; //– Store fetched records.
    public $hDetails;  //– Store clicked employee data.

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
        if(old('HogoshaCd')){
            $this->search = old('HogoshaCd');
        }
    }

    // Fetch records
    public function searchResult(){

        //UserDetailはクリアする
        $this->hDetails=null;

        if(!empty($this->search)){

            //もしIDが入力されて、レコードにヒットすれば、検索画面は出さない
            $record = Hogosha::find($this->search);
            if($record){
                $this->search = $record->HogoshaCd;
                $this->hDetails = $record;
                $this->showresult = false;
            }
            //有効なID以外が入力された場合
            else{

                $this->records = Hogosha::orderby('HogoshaCd','asc')
                        ->where('HogoshaCd','like',$this->search.'%')
                        ->orWhere('sei','like','%'.$this->search.'%')
                        ->orWhere('Mei','like','%'.$this->search.'%')
                        ->orWhere('Hurigana','like','%'.$this->search.'%')
                        ->get();

                $this->showresult = true;
            }
        }else{
            $this->showresult = false;
        }
    }

    // Fetch record by ID
    public function fetchDetail($HogoshaCd = ''){

        // Log::info('fetchHogoshaDetail',[]);
        $record = Hogosha::find($HogoshaCd);

        $this->search = $record->HogoshaCd;
        $this->hDetails = $record;
        $this->showresult = false;
    }


    public function render()
    {
        return view('livewire.lsuppo-sb-hogosha');
    }
}
