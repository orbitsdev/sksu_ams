<?php

namespace App\Models;

use App\Models\Login;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function login(){
        return $this->belongsTo(Login::class);
    }
    
}
