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
    public $errorMessage = '';
    public $errorHeader = '';
    public $recordDay;
    public $activeYear;
    public $account;

    public function mount()
    {
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

    public function login()
    {





        try {
            DB::beginTransaction();

            // $this->account = Account::where('id_number', $this->idnumber)->first();
            $this->account = Account::where('id_number', $this->idnumber)->first();

            if (!empty($this->account)) {

                $this->recordDay = DayRecord::latest()->first();

                if (!empty($this->recordDay)) {

                    $nowDate = now()->startOfDay();
                    $activeRecord = $this->recordDay->created_at->startOfDay();

                    if ($nowDate->equalTo($activeRecord)) {


                        if ($logrecord =  $this->account->logins()->latest()->first()) {


                            $ante_meridiem = now()->timezone('Asia/Manila')->format('A');

                            if ($ante_meridiem == "AM") {
                                if (empty($logrecord->morning_in)) {
                                    $logrecord->update(['morning_in' => now()]);
                                    $this->account = Account::where('id_number', $this->idnumber)->first();
                                    $this->isSuccess = true;
                                } elseif (empty($logrecord->morning_out)) {
                                    $logrecord->update(['morning_out' => now()]);
                                    $this->account = Account::where('id_number', $this->idnumber)->first();
                                    $this->isSuccess = true;
                                } else {
                                    $this->showError('Operation Failed', 'You have already logged out', 'exception');
                                }
                            } else {
                                if (empty($logrecord->noon_in)) {
                                    $logrecord->update(['noon_in' => now()]);
                                    $this->account = Account::where('id_number', $this->idnumber)->first();
                                    $this->isSuccess = true;
                                } else {
                                    if (empty($logrecord->noon_out) && !empty($logrecord->noon_in)) {
                                        $logrecord->update(['noon_out' => now()]);
                                        $this->account = Account::where('id_number', $this->idnumber)->first();
                                        $this->isSuccess = true;
                                    } else {
                                        $this->showError('Operation Failed', 'You have already logged out', 'exception');
                                    }
                                }
                            }


                            // if($logoutRecord = $studentLoginRecord->logout){


                            //     if($logoutRecord->status == 'Not Logout'){

                            //         $this->updateLogoutRecordStatus($logoutRecord);


                            //     }else{
                            //         $this->createDayLoginRecordWithLogout();

                            //     }

                            // }else{
                            //     $this->createLogoutRecord($studentLoginRecord);

                            // }



                        } else {

                            $this->createDayLoginRecordWithLogout();
                        }
                    } else {
                        $this->createDayRecord();
                        $this->createDayLoginRecordWithLogout();
                    }
                } else {

                    $this->createDayRecord();

                    $this->createDayLoginRecordWithLogout();
                }
            } else {
                $this->showError('Error', 'Account not found', 'not-found');
            }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            $this->showError($e->getCode(), $e->getMessage(), 'exception');
        }
    }




    public function createDayRecord()
    {
        $this->recordDay = DayRecord::create();

        //     $this->activeYear = SchoolYear::where('status', true)->first();

        //    if(!empty($this->activeYear)){

        //     $this->recordDay = DayRecord::create([
        //         'school_year_id' => $this->activeYear->id,
        //     ]);
        // }else{


        //     $this->showError(
        //         'No School Year Set for Recording',
        //         'The school year for recording has not been configured by the admin yet. Please set a valid school year to proceed.',
        //         'exception'
        //     );





        //    }


    }

    public function createDayLoginRecordWithLogout()
    {



        // $Ante Meridiem = $currentDateTime->format('A') === 'AM';
        $ante_meridiem = now()->format('A');

        if ($ante_meridiem == "AM") {

            $login_data = [
                'account_id' => $this->account->id,
                'morning_in' => now()->timezone('Asia/Manila'),
            ];
        } else {
            $login_data = [
                'account_id' => $this->account->id,
                'noon_in' => now()->timezone('Asia/Manila'),
            ];
        }


        $newLoginRecord = $this->recordDay->logins()->create($login_data);
        // $newLogoutRecord = $newLoginRecord->logout()->create(['status'=> 'Not Logout']);
        $this->account = Account::where('id_number', $this->idnumber)->first();

        if ($this->account->role->name == 'student') {
            $accountdata = [
                'login_id' => $newLoginRecord->id,
                'first_name' => $this->account->first_name,
                'last_name' => $this->account->last_name,
                'middle_name' => $this->account->middle_name,
                // 'campus_name'=> $this->account->campus->name,
                'department_name' => $this->account->department->name,
                'course_name' => $this->account->course->name,
                'section_name' => $this->account->section->name,
                'guardian_first_name' => $this->account->guardian->first_name,
                'guardian_last_name' => $this->account->guardian->last_name,
                'guardian_number' => $this->account->guardian->phone_number,
                'role_name' => $this->account->role->name,
            ];
        } else {
            $accountdata = [
                'login_id' => $newLoginRecord->id,
                'first_name' => $this->account->first_name,
                'last_name' => $this->account->last_name,
                'middle_name' => $this->account->middle_name,
                'department_name' => $this->account->department->name,
                'role_name' => $this->account->role->name,
            ];
        }
        $newLog = Log::create($accountdata);

        $this->isSuccess = true;
    }


    public function updateLogoutRecordStatus($logoutRecord)
    {
        $logoutRecord->update(['status' => 'Logged out']);
        $this->account = Account::where('id_number', $this->idnumber)->first();
        $this->isSuccess = true;
    }


    public function showError($header = 'Error', $message = "An Error Occur", $type = 'not-found')
    {
        $this->hasError = true;
        $this->errorType = $type;
        $this->errorMessage = $message;
        $this->errorHeader = $header;
    }

    public function createLogoutRecord($studentLoginRecord)
    {

        $newLogoutRecord = $studentLoginRecord->logout()->create(['status' => 'Logged out']);
        $this->account = Account::where('id_number', $this->idnumber)->first();
        $this->isSuccess = true;
    }


    // public function readBarCodeManually(): void
    // {
    //     $this->readBarCode();
    // }
}
