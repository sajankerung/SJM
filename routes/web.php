
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkRecordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonthlyReportController;

// Guest routes: only users who are not logged in
Route::middleware('guest')->group(function () {

    // Registration
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');
});

// Protected routes: login is required
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Work Records
    Route::get('/work-records/create', [WorkRecordController::class, 'create'])
        ->name('work-records.create');

    Route::post('/work-records', [WorkRecordController::class, 'store'])
        ->name('work-records.store');

    Route::get('/work-records', [WorkRecordController::class, 'index'])
        ->name('work-records.index');

    Route::get('/work-records/{workRecord}/edit', [WorkRecordController::class, 'edit'])
        ->name('work-records.edit');

    Route::put('/work-records/{workRecord}', [WorkRecordController::class, 'update'])
        ->name('work-records.update');

    Route::delete('/work-records/{workRecord}', [WorkRecordController::class, 'destroy'])
        ->name('work-records.destroy');

    // Monthly Reports
    Route::get('/monthly-reports', [MonthlyReportController::class, 'index'])
        ->name('monthly-reports.index');
});
