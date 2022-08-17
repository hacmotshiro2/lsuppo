<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Menubar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

     public String $id;

    public function __construct(String $id)
    {
        //View側で使用する変数をセット
        $this->id = $id; 
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.menubar');
    }
}
