<?php

namespace App\Exports;

use App\Models\Deparment;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DepartmentExport implements  FromView
{
  
    public function view(): View
    {
        return view('exports.departments', [
            'collections' => [
                (object) [
                    'name' => 'Computer Studies (CCS)',
                    // Add other attributes
                ],
                (object) [
                    'name' => 'Engineering (COE)',
                    // Add other attributes
                ],
                (object) [
                    'name' => 'NABA (NABA)',
                    // Add other attributes
                ],
            ]
        ]);
    }
}
