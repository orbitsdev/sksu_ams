<?php

namespace App\Http\Livewire;

use App\Models\Account;
use Livewire\Component;

class TotalStaff extends Component
{

    public $totalStaff;
    public function render()
    {
        $this->totalStaff = Account::whereHas('role', function($query){
            $query->where('name', 'staff');
        })->count();
        return view('livewire.total-staff');
    }
}
