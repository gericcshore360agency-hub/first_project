<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('my_dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/attendance', function () {
        return view('attendance');})->name('show_attendance');

    //Attendance Related
    Route::get('/attendance/{date}', [AttendanceController::class, 'show'])->name('attendance.show');

    //User Management
    Route::get('/show_users', [ProfileController::class, 'index'])->name('show_users');

    Route::get('/edit_user/{id}', [ProfileController::class, 'edit_users'])->name('edit_user');

    Route::get('/add_user', [ProfileController::class, 'add_users'])->name('add_user');

});

require __DIR__.'/auth.php';
