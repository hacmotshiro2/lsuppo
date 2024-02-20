<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LsuppoSupermenu extends Component
{
    public $icOpenClose = '<i class="fa-solid fa-chevron-up"></i>';
    public $isMenuOpen = true;

    public function toggleMenu()
    {
        $this->isMenuOpen = !$this->isMenuOpen;

        //開いているときのアイコン
        if($this->isMenuOpen){
            $this->icOpenClose = '<i class="fa-solid fa-chevron-up"></i>';
        }
        //閉じているときのアイコン
        else{
            $this->icOpenClose = '<i class="fa-solid fa-chevron-down"></i>';
        }
    }

    public function render()
    {
        return view('livewire.lsuppo-supermenu');
    }
}
