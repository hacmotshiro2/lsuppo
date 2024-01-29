<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Request;

use App\Models\User2Hogosha;

class User2hogoshaEdit extends Component
{
    public $u2h_id; //Key
    public $user_id;
    public $HogoshaCd;

    public function mount()
    {
        // クエリ文字列から値を取得してプロパティに代入
        // $this->u2h_id = session('u2h_id');
        $u2h_id = Request::query('u2h_id');
        if($u2h_id){
            $this->u2h_id = $u2h_id;
            $u2h = User2Hogosha::find($u2h_id);
            if($u2h){
                $this->user_id = $u2h->user_id;
                $this->HogoshaCd = $u2h->HogoshaCd;
            }
        }
    }
    public function render()
    {
        return view('livewire.user2hogosha-edit');
    }
}
