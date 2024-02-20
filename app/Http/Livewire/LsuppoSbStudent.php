<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Student;

class LsuppoSbStudent extends Component
{
    public $isRO = false; //readonly
    public $defaultValue;

    public $showresult = false; // – Using this toggle the suggestion list container.
    public $search = ""; //– For data binding.
    public $records; //– Store fetched records.
    public $sDetails;  //– Store clicked employee data.

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
        if(old('StudentCd')){
            $this->search = old('StudentCd');
        }
    }

    // Fetch records
    public function searchResult(){

        //UserDetailはクリアする
        $this->sDetails=null;

        if(!empty($this->search)){

            //もしIDが入力されて、レコードにヒットすれば、検索画面は出さない
            $record = Student::find($this->search);
            if($record){
                $this->search = $record->StudentCd;
                $this->sDetails = $record;
                $this->showresult = false;
            }
            //有効なID以外が入力された場合
            else{

                $this->records = Student::orderby('StudentCd','asc')
                        ->where('StudentCd','like',$this->search.'%')
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
    public function fetchDetail($StudentCd = ''){

        // Log::info('fetchHogoshaDetail',[]);
        $record = Student::find($StudentCd);

        $this->search = $record->StudentCd;
        $this->sDetails = $record;
        $this->showresult = false;
    }

    public function render()
    {
        return view('livewire.lsuppo-sb-student');
    }
}
