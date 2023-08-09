<?php

namespace App\Exports;

use App\Models\Log;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LogExport  implements FromView
{

    // use Exportable;

    // protected $logs;

    // public function __construct($logs)
    // {
    //     $this->logs = $logs;
    // }

    // public function collection()
    // {
    //     return $this->logs;
    // }

    // public function headings(): array
    // {
    //     return [
    //         'Column 1 Header',
    //         'Column 2 Header',
    //         // Add more headings as needed
    //     ];
    // }

    // return (new LogExport($this->logs))->download('log_report.xlsx');
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
