<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('welcome'));

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Parent Route
|--------------------------------------------------------------------------
*/

Route::post('/load_teacher', [DashboardController::class,'load_teacher'])->name('load_teacher');

/*
|--------------------------------------------------------------------------
| Student Routes (no auth — students have no accounts)
|--------------------------------------------------------------------------
*/

Route::get('/attendance/form', [AttendanceController::class, 'attendance_form'])->name('attendance.form');
Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Attendance
    Route::get('/attendance', fn() => view('attendance'))->name('show_attendance');
    Route::get('/attendance/{date}', [AttendanceController::class, 'show'])->name('attendance.show');

    // User Management
    Route::get('/show_users', [ProfileController::class, 'index'])->name('show_users');
    Route::get('/add_user', [ProfileController::class, 'add_users'])->name('add_user');
    Route::post('/create_users', [ProfileController::class, 'create_users'])->name('create_users');
    Route::get('/edit_user/{id}', [ProfileController::class, 'edit_users'])->name('edit_user');
    Route::put('/update_user/{id}', [ProfileController::class, 'update_user'])->name('update_user');
    Route::delete('/delete_user/{id}', [ProfileController::class, 'delete_user'])->name('delete_user');

    // Role Management
    Route::get('/role_management', [RoleController::class, 'index'])->name('role_management');
    Route::post('/create_role', [RoleController::class, 'create_role'])->name('create_role');
    Route::put('/roles/{id}', [RoleController::class, 'edit_role'])->name('edit_role');
    Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('delete_role');

    // Student Management
    Route::get('/view_students',[StudentController::class, 'view_students'])->name('view_students');
    Route::post('/add_student', [StudentController::class,'store_students'])->name('add_student');
    Route::put('/edit_student/{id}',[StudentController::class,'edit_student'])->name('update_student');
    Route::delete('/delete_student/{id}', [StudentController::class, 'delete_student'])->name('delete_student');

    // History
    Route::get('/history', [HistoryController::class, 'index'])->name('history');
    Route::post('/restore/user/{id}', [HistoryController::class, 'restoreUser'])->name('restore.user');
});

require __DIR__.'/auth.php';