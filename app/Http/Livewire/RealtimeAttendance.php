<?php

namespace App\Http\Livewire;

use Filament\Tables;
use App\Models\Login;
use App\Models\Account;
use Livewire\Component;
use App\Models\DayRecord;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;

class RealtimeAttendance extends Component implements Tables\Contracts\HasTable 
{

    use Tables\Concerns\InteractsWithTable; 


    public $todayRecord;

    public function mount(){
           $this->todayRecord = DayRecord::latest()->first();
    }
    protected function getTablePollingInterval(): ?string
{
    return '3s';
}

    protected function getTableQuery(): Builder 
    {   
       
        $latestDay = DayRecord::latest()->first();
        // dd($latestDay);

        if($latestDay){
            return Login::query()->where('day_record_id', $latestDay->id)->whereHas('logout', function($query){
                $query->where('status','!=', 'Did Not Logout');
            })->latest();
        }

    } 

    protected function getTableColumns(): array
    {
        return [
            ImageColumn::make('account.profile_path')->disk('public')->height(120)->width(120)->url(function ($record) {
                return Storage::url($record->account->profile_path);
            })->openUrlInNewTab(),
            
            Tables\Columns\TextColumn::make('account.first_name')->label('Name')->formatStateUsing(function ($record){ 
                return $record->account->first_name . ' ' . $record->account->last_name;
            })->searchable(),
            Tables\Columns\TextColumn::make('account.role.name')->label('Position')->formatStateusing(function($record){
                return Str::ucfirst( $record->account->role->name);
            
            }),
            // Tables\Columns\TextColumn::make('student.course.name')->label('Course'),
            // Tables\Columns\TextColumn::make('student.year')->label('Year'),
            Tables\Columns\TextColumn::make('updated_at')->label('Enter') ->since()->color('success')->formatStateUsing(function ($record){ 
                // if($record->logout->status == 'Not Logout'){
                    
                // }
                
                if($record->logout->status == 'Logged out'){
                    return $record->updated_at->format('H:i A');
                    // return  'Logout ';
                }
                return $record->updated_at->diffForHumans();
              
            }),
            Tables\Columns\TextColumn::make('logout.updated_at')->label('Exit')->since()->color('danger')->formatStateUsing(function ($record){ 

                if($record->logout->status == 'Not Logout'){
                    return '- Currently Inside -';
                    
                }
                
                if($record->logout->status == 'Did Not Logout'){
                    
                    return 'Did Not Logout';
                }

                if($record->logout->status == 'Logged out'){
                    return  $record->logout->updated_at->format('H:i:s A');
                }

                }
                // return $record->account->first_name . ' ' . $record->account->last_name;
            ),
            
            
        ];
    }
    public function render()
    {
        return view('livewire.realtime-attendance');
    }
}
