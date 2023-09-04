<?php

namespace App\Imports;

use App\Models\Role;
use App\Models\Course;
use App\Models\Account;
use App\Models\Section;
use App\Models\Department;
use App\Models\SchoolYear;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AccountToAddImport implements ToModel, WithHeadingRow
{
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row) 
    {

      
         $record = Account::find($row['id']);

        if($record){
            dd('exts');
        }else{

            $school_year = SchoolYear::where('from', 'like', '%' . $row['school_year'] )->first();

            $department = Department::where('name', $row['department_name'])->first();
            dd($department);
            $role = Role::where('name', $row['role_name'])->first();
            $section = Section::where('name', $row['section'])->first();
            $course = Course::where('name', $row['course_name'])->first();

            return new Account([
                'first_name'=> $row['first_name'],
                'last_name'=> $row['last_name'],
                'middle_name'=> $row['middle_name'],
                'school_year_id'=> $school_year->id ?? null,
                'department_id'=> $department->id ?? null,
                'role_id'=> $role->id ?? null,
                'section_id'=> $section->id ?? null,
                'course_id'=> $course->id ?? null,
            ]);

        }
    }

    
}
