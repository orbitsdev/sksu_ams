<?php

namespace App\Http\Livewire\Attendance;

use App\Models\Log;
use App\Models\Account;
use Livewire\Component;
use App\Models\DayRecord;
use App\Models\SchoolYear;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class Index extends Component
{   

    use Actions;

    public $idnumber;
    public $password;
    
    public $hasError = false;
    public $isSuccess = false;

    public $errorType = 'not-found';
    public $errorMessage='';
    public $errorHeader='';
    public $recordDay;
    public $activeYear;
    public $account;

    public function mount(){
    }


    // public function updatingidnumber(){
    //     if(!empty($this->idnumber)){
    //         $this->login();
    //     }
    // }


    public function render()
    {
        return view('livewire.attendance.index');
    }

    public function login(){
      


       
      
        try{
            DB::beginTransaction();

            // $this->account = Account::where('id_number', $this->idnumber)->first();
            $this->account = Account::where('id_number', $this->idnumber)->first();
         
            if(!empty($this->account)){

                $this->recordDay = DayRecord::latest()->first();

                if(!empty($this->recordDay)){

                    $nowDate = now()->startOfDay();
                    $activeRecord = $this->recordDay->created_at->startOfDay();

                    if($nowDate->equalTo($activeRecord)){
                        
                         
                        if( $studentLoginRecord =  $this->account->logins()->latest()->first()){    

                            if($logoutRecord = $studentLoginRecord->logout){
                                

                                if($logoutRecord->status == 'Not Logout'){

                                    $this->updateLogoutRecordStatus($logoutRecord);
                                  

                                }else{
                                    $this->createDayLoginRecordWithLogout();
                                    
                                }

                            }else{
                                $this->createLogoutRecord($studentLoginRecord);
                                
                            }
                          

                    }else{
                      
                        $this->createDayLoginRecordWithLogout();
                    }

                }else{
                   $this->createDayRecord();
                    $this->createDayLoginRecordWithLogout();
               }
                
            }else{
               
               $this->createDayRecord();
            
                $this->createDayLoginRecordWithLogout();
           }
        
        }else{
            $this->showError( 'Error', 'Account not found' ,'not-found' );
        }
        DB::commit(); 
    }
        catch(QueryException $e){
            DB::rollBack(); 
            $this->showError( $e->getCode(), $e->getMessage() ,'exception' );
        }

    }

        


    public function createDayRecord(){
            $this->activeYear = SchoolYear::where('status', true)->first();
         
           if(!empty($this->activeYear)){
          
            $this->recordDay = DayRecord::create([
                'school_year_id' => $this->activeYear->id,
            ]);
        }else{
                

            $this->showError(
                'No School Year Set for Recording',
                'The school year for recording has not been configured by the admin yet. Please set a valid school year to proceed.',
                'exception'
            );
            
           
            

              
           }

           
    }

    public function createDayLoginRecordWithLogout(){
        $newLoginRecord = $this->recordDay->logins()->create(['account_id' => $this->account->id,]);
        $newLogoutRecord = $newLoginRecord->logout()->create(['status'=> 'Not Logout']);
         $this->account = Account::where('id_number', $this->idnumber)->first();

    $newLog = Log::create([
        'login_id' => $newLoginRecord->id,
        'role_name' => $this->account->role->name,
        'school_year' => $this->recordDay->schoolYear,
        'account' => $this->account,
        'guardian' => $this->account->guardian,
    ]);

    $this->isSuccess = true;
        
    }

    
    public function updateLogoutRecordStatus($logoutRecord){
        $logoutRecord->update(['status' => 'Logged out']);
        $this->account = Account::where('id_number', $this->idnumber)->first();
        $this->isSuccess = true;
    }


    public function showError($header = 'Error', $message = "An Error Occur" , $type= 'not-found' ){
        $this->hasError = true;
        $this->errorType = $type;
        $this->errorMessage = $message;
        $this->errorHeader = $header;
    }

    public function createLogoutRecord($studentLoginRecord){
        $newLogoutRecord = $studentLoginRecord->logout()->create(['status'=> 'Logged out']);
        $this->account = Account::where('id_number', $this->idnumber)->first();
        $this->isSuccess = true;
    }


    // public function readBarCodeManually(): void
    // {
    //     $this->readBarCode();
    // }
}
