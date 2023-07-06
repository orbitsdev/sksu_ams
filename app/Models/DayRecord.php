<?php

namespace App\Models;

use App\Models\Login;
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
}
