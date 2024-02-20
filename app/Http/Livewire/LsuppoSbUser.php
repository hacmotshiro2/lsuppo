<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

use App\Models\User;


class LsuppoSbUser extends Component
{

    public $isRO = false; //readonly
    public $defaultValue;

    public $showresult = false; // – Using this toggle the suggestion list container.
    public $search = ""; //– For data binding.
    public $records; //– Store fetched records.
    public $details;  //– Store clicked employee data.

    /* memo
    * RealTimeValidationを実装しようと思ったが、やめた
    * テキストボックスは、名前検索にも使うので、いちいちidでValidationされたくない
    * name属性を固定にしないといけない（nameに合わせたrulesの定義など）
    * ruleやmessageをFormRequest側と二重管理になってしまう
    * 以上のようなやっかいなことをしてまでリアルタイムにする便益が少ない。
    */

    public function mount(){
        $this->search = $this->defaultValue;

        //ここで指定してあげないと、空白になる。
        if(old('user_id')){
            $this->search = old('user_id');
        }
    }

    // Fetch records
    public function searchResult(){

        //UserDetailはクリアする
        $this->details=null;

        if(!empty($this->search)){

            //もしIDが入力されて、レコードにヒットすれば、検索画面は出さない
            $record = User::find($this->search);
            if($record){
                $this->search = $record->id;
                $this->details = $record;
                $this->showresult = false;
            }
            //有効なID以外が入力された場合
            else{

                $this->records = User::orderby('id','asc')
                        ->where('name','like','%'.$this->search.'%')
                        ->get();

                $this->showresult = true;
            }
        }else{
            $this->showresult = false;
        }
    }

    // Fetch record by ID
    public function fetchDetail($id = 0){

        $record = User::find($id);

        $this->search = $record->id;
        $this->details = $record;
        $this->showresult = false;
    }

    public function render()
    {
        return view('livewire.lsuppo-sb-user');
    }
}
