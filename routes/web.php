<?php

use App\Models\Account;
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
        Route::get('/manage-school-year', function () {  return view('manage.school-year');  })->name('school-year');
        Route::get('/manage-campuses', function () {  return view('manage.campuses');  })->name('campuses');
        Route::get('/manage-department', function () {  return view('manage.departments');  })->name('departments');
        Route::get('/manage-courses', function () {  return view('manage.courses');  })->name('courses');
        Route::get('/manage-sections', function () {  return view('manage.sections');  })->name('sections');
        Route::get('/manage-staffs', function () {  return view('manage.staffs');  })->name('staffs');
        Route::get('/manage-accounts', function () {  return view('manage.accounts');  })->name('accounts');
        Route::get('/manage-users', function () {  return view('manage.users');  })->name('users');
    });


    Route::get('/account/details/{account:slug}', function ($slug) {
        // $account = Account::where('slug', $slug)->first();
    
        // if (!$account) {
        //     abort(404);
        // }
        $account = Account::where('slug', $slug)->firstOrFail();
        return view('account-details', compact('account'));
    })->name('account.details');
    

});
