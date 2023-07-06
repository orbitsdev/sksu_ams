<?php

namespace App\Http\Livewire;

use App\Models\Account;
use Livewire\Component;

class TotalAccount extends Component
{

    public $totalAccounts;
    public function render()
    {   
        $this->totalAccounts = Account::count();
        return view('livewire.total-account');
    }
}
