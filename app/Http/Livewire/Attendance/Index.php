<?php

namespace App\Http\Livewire\Attendance;

use Livewire\Component;
use WireUi\Traits\Actions;

class Index extends Component
{   

    use Actions;

    public $idnumber;
    public $password;
    
    public $hasError = false;
    public $isSuccess = true;

    public $errorType = 'not-found';

    public function mount(){
    }

    // public function showSuccess($header ='Data saved', $content="Your data was successfully save"){
       
    //     $this->dialog()->success(

    //         $title = $header,
    //         $description = $content

    //     );
       
    // }


    public function render()
    {
        
        return view('livewire.attendance.index');
    }

    public function login(){
        $this->isSuccess = true;
    }


    public function showDialog(){

    }
}
