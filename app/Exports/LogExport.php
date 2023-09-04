<?php

namespace App\Exports;

use App\Models\Log;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LogExport  implements FromView
{

   
    protected $logs;

    public function __construct($logs)
    {
        $this->logs = $logs;
      
    }
    
    public function view(): View
    {
        return view('exports.logs', [
            'collections' => $this->logs,
        ]);
    }

}
