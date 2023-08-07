<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Login;
use App\Models\Course;
use App\Models\Section;
use App\Models\Guardian;
use App\Models\Department;
use App\Models\SchoolYear;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function boot()
{
    parent::boot();

    static::creating(function ($account) {
        $account->generateSlug();
    });

    static::updating(function ($account) {
        $account->generateSlug();
    });
}

    
 public function generateSlug()
 {
    $baseSlug = Str::slug($this->first_name.$this->last_name);
    $slug = $baseSlug;
    $counter = 1;
    $counter = Str::random(8); 
    while (self::where('slug', $slug)->exists()) {
        $slug = $baseSlug . '-' . $counter;
        $counter++;
        $counter = Str::random(8); // Generate
    }

    $this->slug = $slug;
 }

    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    public function guardian(){
        
        return $this->hasOne(Guardian::class);
    }

    
    public function schoolYear(){
        
        return $this->belongsTo(SchoolYear::class);
    }
  

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function section(){
        return $this->belongsTo(Section::class);
    }





    public function logins()
    {
        return $this->hasMany(Login::class);
    }
}
