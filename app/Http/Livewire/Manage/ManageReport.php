<?php

namespace App\Http\Livewire\Manage;

use App\Models\Log;
use App\Models\Course;
use Livewire\Component;
use App\Models\DayRecord;
use App\Models\Department;
use App\Models\SchoolYear;

class ManageReport extends Component
{

    public $departments=[];
    public $courses=[];
    public $department;
    public $schoolYears=[];
    public $schoolYear;
    public $dayRecord;
    public $course;
    public $section;
    public $student = false;
    public $staff = false;
    public $morning = false;
    public $noon = false;
    public $from ;
    public $to;
    public $logs = [];
    public $samples = [1,23,4,5,6,44,234,23,423,4,234,234,234, 1,23,4,5,6,44,234,23,423,4,234,234,234, ];


    public function mount(){


        $this->departments = Department::latest()->get();
        if($this->departments){
            $this->department = Department::latest()->first()->id;
        }
      
        // $this->schoolYears = SchoolYear::select( 'from','to', 'id')->get();
        // $this->schoolYear = SchoolYear::where('status', true)->latest()->first()->id;

        // if(!empty($this->schoolYear)){
            
        // }

        // $this->dayRecord = DayRecord::latest()->first();
      

        // if ($this->dayRecord) {
        //     $this->logs = Log::whereHas('login', function ($query) {
        //         $query->where('day_record_id', $this->dayRecord->id);
        //     })->get();
            
            
        // } else {
        //     $this->logs = [];
        // }
        
    }



    public function updatedcourses(){
        dd('course');
    }
    public function updatedsection(){
        dd('section');
    }
    public function updatedstudent(){
      

        // if($this->student){
        //     $this->logs = Log::where('role_name', 'student')->get();
        // }
        
    }
    public function updatedstaff(){
        
        // if($this->staff){
        //     $this->logs = Log::where('role_name', 'staff')->get();
        // }
    }
    public function updatedmorning(){
        
        
        // if ($this->morning) {
        //     $this->logs = Log::whereHas('login', function($query) {
        //         $query->whereTime('created_at', '>=', '00:00:00')->whereTime('created_at', '<', '12:00:00');
        //     })->get();
        // }
        
    
    }
    public function updatednoon(){

        // if($this->noon){
        //     $this->logs = Log::whereHas('login', function($query){
        //         $query->whereTime('created_at', '>=' ,'12:00:00')->whereTime('created_at', '<', '24:00:00');
        //     })->get();
            
        // }
    }
    public function updatedfrom(){
        // $this->logs = Log::whereHas('login', function($query){
        //         $query->whereDate('created_at', $this->from);
        // })->get();
      
    }
    public function updatedto(){
    //     $this->logs = Log::whereHas('login', function($query){
    //         $query->whereDate('created_at', $this->to);
    // })->get();

       
    }

    public function print(){
        $this->emit('printRe');    
    }

    
    public function updateddepartment(){
       
        
        // $this->logs = Log::whereHas('login.account.department', function($query){
        //         $query->where('id', $this->department);
        // })->get();

        
        // $this->courses = Course::where('department_id', $this->department)->get();
        
    }

    public function updatedcourse(){
        dd('dasdasd');
    }

    public function render()
    {   
        $this->departments = Department::select('name','id')->get();

        
        if($this->department){
             
            $this->courses = Course::where('department_id', $this->department)->select('name','id')->get();
             
        }

        
         $this->dayRecord = DayRecord::latest()->first();
      

        $this->logs = Log::when($this->dayRecord, function($query){
                        $query->whereHas('login', function($query){
                            $query->where('day_record_id', $this->dayRecord->id);
                        });
                        })
                        ->when($this->department, function($query){
                            $query->whereHas('login.account.department', function($query){
                                $query->where('id', $this->department);
                            });
                        })
                        ->when($this->morning, function($query){
                            $query->whereHas('login', function($query){
                                $query->whereTime('created_at', '>=', '00:00:00')->whereTime('created_at', '<', '12:00:00');
                            });
                        })
                        ->when($this->noon, function($query){
                            $query->whereHas('login', function($query){
                                $query->whereTime('created_at', '>=' ,'12:00:00')->whereTime('created_at', '<', '24:00:00');
                            });
                        })
                        ->when($this->course, function($query){
                            $query->whereHas('login.account.course', function($query){
                                $query->where('id', $this->course);
                            });
                        })
                        ->when($this->staff, function($query){
                            $query->where('role_name', 'staff');
                        })

                        ->when($this->student, function($query){
                            $query->where('role_name', 'student');
                    
                        })
                        ->when($this->from || $this->to, function ($query) {
                           
                            $query->whereHas('login', function ($query) {
                                if ($this->from && $this->to) {
                                    $from = $this->from . ' 00:00:00'; // Start of selected day
                                    $to = $this->to . ' 23:59:59';    
                                    $query->whereBetween('created_at', [$from, $to]);
                                  
                                } elseif ($this->from) {
                                    
                                    $query->where('created_at', '>=', $this->from);
                                    
                                } elseif ($this->to) {
                                    $query->where('created_at', '<=', $this->to);
                                }
                            });
                        })
                        ->whereHas('login', function($query){
                            // $query->whereNotNull('noon_in')->whereNotNull('noon_out');
                            // $query->whereNotNull('morning_in');
                        })
                        ->latest()
                        ->get();
                       
        return view('livewire.manage.manage-report', [
            'departments'=> $this->departments,
            'courses'=> $this->courses,
            'logs'=> $this->logs,
        ]);
    }

}
