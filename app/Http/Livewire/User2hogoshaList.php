<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User2Hogosha;

class User2hogoshaList extends Component
{
    public $items;

    public function mount()
    {
        $this->items = User2Hogosha::getu2hData();
    }
    public function render()
    {
        return view('livewire.user2hogosha-list');
    }
}
