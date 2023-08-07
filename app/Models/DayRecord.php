<?php

namespace App\Models;

use App\Models\Login;
use App\Models\SchoolYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DayRecord extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function logins()
    {
        return $this->hasMany(Login::class);
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }
}
