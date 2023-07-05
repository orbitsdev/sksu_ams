<?php

namespace App\Models;

use App\Models\Account;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

      
 public function generateSlug()
 {
     $baseSlug = Str::slug($this->title);
     $slug = $baseSlug;
     $counter = 1;

     while (self::where('slug', $slug)->exists()) {
         $slug = $baseSlug . '-' . $counter;
         $counter++;
     }

     $this->slug = $slug;
 }
}
