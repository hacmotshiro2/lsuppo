<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Student;

class StudentList extends Component
{
    public function mount()
    {
        $this->items = Student::orderBy('StudentCd','asc')->get();
    }

    public function render()
    {
        return view('livewire.student-list');
    }
}
