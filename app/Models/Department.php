<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $guarded;

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
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
