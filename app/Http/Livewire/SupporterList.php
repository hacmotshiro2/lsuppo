<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Supporter;

class SupporterList extends Component
{
    public function mount()
    {
        $this->items = Supporter::orderBy('SupporterCd','asc')->get();
    }

    public function render()
    {
        return view('livewire.supporter-list');
    }
}
