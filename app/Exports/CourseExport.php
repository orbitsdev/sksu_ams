<?php

namespace App\Exports;

use App\Models\Course;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class CourseExport implements FromView
{
    public function view(): View
    {
        return view('exports.courses', [
            'collections' => [
                (object) [
                    'name' => 'Bachelor of Science in Information Technology',
                    // Add other attributes
                ],
                (object) [
                    'name' => 'Bachelor of Science in Computer Science',
                    // Add other attributes
                ],
                (object) [
                    'name' => 'Bachelor of Science in Information System',
                    // Add other attributes
                ],
            ]
        ]);
    }
}
