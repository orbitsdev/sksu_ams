<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Test extends Component
{

    public  $samples = [1,23,4,5,6,44,234,23,423,4,234,234,234, 1,23,4,5,6,44,234,23,423,4,234,234,234, 1,23,4,5,6,44,234,23,423,4,234,234,234,1,23,4,5,6,44,234,23,423,4,234,234,234,1,23,4,5,6,44,234,23,423,4,234,234,234,];


    public function print()
    {
        // Your logic to prepare the data or anything you want to do before printing...

        // Emit an event to trigger the JavaScript print function
        $this->emit('aaa');
    }
    public function render()
    {
        return view('livewire.test');
    }
}
