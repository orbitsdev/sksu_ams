<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('attendance')->name('attendance.')->group(function(){
    Route::get('/', [AttendanceController::class, 'index'])->name('index');
});





Route::middleware([ 'auth:sanctum',  config('jetstream.auth_session'), 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {  return view('dashboard');  })->name('dashboard');
    Route::get('/reports', function () {  return view('reports');  })->name('reports');
    Route::name('manage.')->group(function(){
        Route::get('/manage-department', function () {  return view('manage.departments');  })->name('departments');
        Route::get('/manage-courses', function () {  return view('manage.courses');  })->name('courses');
        Route::get('/manage-staffs', function () {  return view('manage.staffs');  })->name('staffs');
        Route::get('/manage-accounts', function () {  return view('manage.accounts');  })->name('accounts');
        Route::get('/manage-users', function () {  return view('manage.users');  })->name('users');
    });

});
