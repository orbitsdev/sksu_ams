<?php

namespace App\Http\Livewire\Manage;

use App\Models\Course;
use Livewire\Component;
use App\Models\Department;

class ManageReport extends Component
{

    public $departments=[];
    public $courses=[];
    public $department;
    public $course;
    public $student = false;
    public $staff = false;
    public $morning = false;
    public $noon = false;
    public $from ;
    public $to;
    public function print(){
        $this->emit('printDoc');    
    }

    
    public function updateddepartment(){

        $this->courses = Course::where('department_id', $this->department)->get();
        // dd($this->courses);
        if(count($this->courses) > 0){
            // dd($this->courses->first()->id);
            $this->course = $this->courses->first()->id;
        }
        
    }

    public function render()
    {   
    $this->departments = Department::select('name', 'id')->get();

    if($this->department != null){
        $this->courses = Course::where('department_id', $this->department)->get();
    }
    // $this->courses= Course::select('name', 'id')->get();
        // dd($this->departments);


        return view('livewire.manage.manage-report',);
    }

}
