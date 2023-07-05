<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
