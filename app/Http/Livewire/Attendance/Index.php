<?php

namespace App\Http\Livewire\Attendance;

use App\Models\Account;
use Livewire\Component;
use App\Models\DayRecord;
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
    public $account;

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


       
      
        try{
            DB::beginTransaction();

            $this->account = Account::where('id_number', $this->idnumber)->where('password', $this->password)->first();
         
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
                    $this->recordDay = DayRecord::create();
                    $this->createDayLoginRecordWithLogout();
               }
                
            }else{
                $this->recordDay = DayRecord::create();
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

        



    public function createDayLoginRecordWithLogout(){
        $newLoginRecord = $this->recordDay->logins()->create(['account_id' => $this->account->id,]);
        $newLogoutRecord = $newLoginRecord->logout()->create(['status'=> 'Not Logout']);
        $this->account = Account::where('id_number', $this->idnumber)->where('password', $this->password)->first();
        $this->isSuccess = true;
    }

    
    public function updateLogoutRecordStatus($logoutRecord){
        $logoutRecord->update(['status' => 'Logged out']);
        $this->account = Account::where('id_number', $this->idnumber)->where('password', $this->password)->first();
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
        $this->account = Account::where('id_number', $this->idnumber)->where('password', $this->password)->first();
        $this->isSuccess = true;
    }


    // public function readBarCodeManually(): void
    // {
    //     $this->readBarCode();
    // }
}
