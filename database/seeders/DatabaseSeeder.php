<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Database\Seeders\CourseSeeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\DepartmentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        $this->call([
            // DepartmentSeeder::class,
            // CourseSeeder::class,
            
            // EmployeeSeeder::class,
            // UserSeeder::class,
        ]);

        $roles = ['staff','student','admin','guest'];

        foreach($roles as $role){
            Role::create(['name' => $role]);
        }

        $admin = [
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ];
        $staff = [
            'name' => 'Staff User',
            'email' => 'staff@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ];
        $student = [
            'name' => 'Studer User',
            'email' => 'student@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ];
        $guest = [
            'name' => 'Guest User',
            'email' => 'guest@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ];

        $accounts = [$admin,$staff,$student,$guest];
        
        $admin_role = Role::where('name','admin')->first();
        $staff_role = Role::where('name','staff')->first();
        $student_role = Role::where('name','student')->first();
        $guest_role = Role::where('name','guest')->first();
        
        $admin_account = User::create($accounts[0])->roles()->attach($admin_role->id);
        $staff_account = User::create($accounts[1])->roles()->attach($staff_role->id);
        $student_account = User::create($accounts[2])->roles()->attach($student_role->id);
        $student_account = User::create($accounts[3])->roles()->attach($guest_role->id);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
