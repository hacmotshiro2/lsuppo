<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Hogosha;

class HogoshaList extends Component
{
    public function mount()
    {
        $this->items = Hogosha::orderBy('HogoshaCd','asc')->get();
    }
    public function render()
    {
        return view('livewire.hogosha-list');
    }
}
