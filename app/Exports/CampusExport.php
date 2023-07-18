<?php

namespace App\Exports;

use App\Models\Campus;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class CampusExport implements  FromView
{
   
    public function view(): View
    {
        return view('exports.campuses', [
            'collections' => [
                (object) [
                    'name' => 'Isulan Campus',
                    // Add other attributes
                ],
                (object) [
                    'name' => 'Tacurong Campus',
                    // Add other attributes
                ],
                (object) [
                    'name' => 'Access Campus',
                    // Add other attributes
                ],
            ]
        ]);
    }
}
