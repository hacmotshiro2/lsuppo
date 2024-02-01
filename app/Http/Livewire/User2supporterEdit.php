<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Request;

use App\Models\User2Supporter;

class User2supporterEdit extends Component
{
    public $u2s_id; //Key
    public $user_id;
    public $SupporterCd;

    public function mount()
    {
        // クエリ文字列から値を取得してプロパティに代入
        // $this->u2h_id = session('u2h_id');
        $u2s_id = Request::query('u2s_id');
        if($u2s_id){
            $this->u2s_id = $u2s_id;
            $u2s = User2Supporter::find($u2s_id);
            if($u2s){
                $this->user_id = $u2s->user_id;
                $this->SupporterCd = $u2s->SupporterCd;
            }
        }
    }    
    public function render()
    {
        return view('livewire.user2supporter-edit');
    }
}
