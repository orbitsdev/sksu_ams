<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campus extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function departments(){
        return $this->hasMany(Department::class);
    }
    
}
