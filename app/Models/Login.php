<?php

namespace App\Models;

use App\Models\Log;
use App\Models\Logout;
use App\Models\Account;
use App\Models\DayRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Login extends Model
{
    use HasFactory;

    protected $guarded = [];

   

    public function dayRecord(){
        return $this->belongsTo(DayRecord::class);
    }

    public function account(){
        return $this->belongsTo(Account::class);
    }

    public function logout(){
        return $this->hasOne(Logout::class);
 
    }

    public function log(){
        return $this->hasOne(Log::class);
    }
}
