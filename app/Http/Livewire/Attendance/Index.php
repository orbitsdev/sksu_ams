<?php

namespace App\Http\Livewire\Attendance;

use Livewire\Component;
use WireUi\Traits\Actions;

class Index extends Component
{   

    use Actions;

    public $id_number;
    public $password;
    public function mount(){
    }


    public function render()
    {
        
        return view('livewire.attendance.index');
    }

    public function test(){
       
    }
}
