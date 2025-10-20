<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| Attendance Management Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to employee attendance management.
| This includes daily attendance tracking and reporting.
|
*/

Route::middleware('auth')->prefix('panel')->name('panel.')->group(function () {

    // Project Attendance Management
    Route::prefix('projects/{project}')->name('projects.')->group(function () {

        // Daily Attendance
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');

        // Attendance Reports
        Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');
        Route::get('/attendance/report/print', [AttendanceController::class, 'printReport'])->name('attendance.report.print');

        // AJAX Routes
        Route::get('/attendance/data', [AttendanceController::class, 'getAttendanceData'])->name('attendance.data');

        // Bulk Operations
        Route::post('/attendance/bulk-update', [AttendanceController::class, 'bulkUpdate'])->name('attendance.bulk-update');
    });

});
