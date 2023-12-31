<?php

namespace App\Models;

use App\Models\Login;
use App\Models\DayRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolYear extends Model
{
    use HasFactory;

    protected $guarded= [];  

    public function logins(){
        return $this->hasMany(DayRecord::class);
    }
}
