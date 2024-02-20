<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Hogosha;

class User2hogoshaCreate extends Component
{

    public function updated()
    {
    }

    public function render()
    {
        return view('livewire.user2hogosha-create');
    }
}
