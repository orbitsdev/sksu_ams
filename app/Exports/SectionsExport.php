<?php

namespace App\Exports;

use App\Models\Section;
use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class SectionsExport implements  FromView
{
  
    public function view(): View
    {
        return view('exports.sections', [
            'collections' => [
                (object) [
                    'name' => 'BSIT-1A',
                    // Add other attributes
                ],
                (object) [
                    'name' => 'BSIT-1B',
                    // Add other attributes
                ],
                (object) [
                    'name' => 'BSIT-1C',
                    // Add other attributes
                ],
            ]
        ]);
    }
}
