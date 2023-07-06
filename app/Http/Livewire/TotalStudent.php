<?php

namespace App\Http\Livewire;

use App\Models\Account;
use Livewire\Component;

class TotalStudent extends Component
{   

    public $totalStudents;
    public function render()
    {   
        $this->totalStudents = Account::whereHas('role', function($query){
            $query->where('name', 'student');
        })->count();
        return view('livewire.total-student');
    }
}
