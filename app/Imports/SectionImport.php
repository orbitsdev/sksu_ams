<?php

namespace App\Imports;

use App\Models\Section;


use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class SectionImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $data = Section::where('name', $row['name'])->first();

        if($data){

        }else{
            return new Section([
                'name'=> $row['name']
            ]);

        }
    }
}
