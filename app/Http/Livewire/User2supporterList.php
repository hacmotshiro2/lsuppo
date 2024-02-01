<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User2Supporter;

class User2supporterList extends Component
{
    public $items;

    public function mount()
    {
        $this->items = User2Supporter::getu2sData();
    }

    public function render()
    {
        return view('livewire.user2supporter-list');
    }
}
