
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkRecordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonthlyReportController;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

// Show Add Work Record form
Route::get('/work-records/create', [WorkRecordController::class, 'create'])
    ->name('work-records.create');

// Save a new Work Record
Route::post('/work-records', [WorkRecordController::class, 'store'])
    ->name('work-records.store');

// Work Records page
Route::get('/work-records', [WorkRecordController::class, 'index'])
    ->name('work-records.index');

// Show Edit form
Route::get('/work-records/{workRecord}/edit', [WorkRecordController::class, 'edit'])
    ->name('work-records.edit');

// Update Work Record
Route::put('/work-records/{workRecord}', [WorkRecordController::class, 'update'])
    ->name('work-records.update');

// Delete Work Record
Route::delete('/work-records/{workRecord}', [WorkRecordController::class, 'destroy'])
    ->name('work-records.destroy');
// Monthly Reports
Route::get('/monthly-reports', [MonthlyReportController::class, 'index'])
    ->name('monthly-reports.index');
