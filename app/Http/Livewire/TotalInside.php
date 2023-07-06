<?php

namespace App\Http\Livewire;

use App\Models\DayRecord;
use App\Models\Login;
use Livewire\Component;

class TotalInside extends Component
{

    public $totalInside;

   
    public function render()
    {
        $latestRecord = DayRecord::latest()->first();
        $this->totalInside = $latestRecord->logins()->whereHas('logout', function($query) {
            $query->where('status', 'Not Logout');
        })->count();

        return view('livewire.total-inside');
    }
}
