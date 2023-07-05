<?php

namespace App\Models;

use App\Models\User;
use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles','user_id','role_id');
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
