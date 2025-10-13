<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ActivityLogController;

/*
|--------------------------------------------------------------------------
| Log Management Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to log management.
| This includes system logs and activity logs.
|
*/

Route::middleware('auth')->prefix('panel')->name('panel.')->group(function () {

    // System Logs
    Route::get('/logs', [LogController::class, 'index'])->name('logs');
    Route::get('/logs/get', [LogController::class, 'getLogs'])->name('logs.get');
    Route::post('/logs/clear', [LogController::class, 'clearLogs'])->name('logs.clear');
    Route::get('/logs/download', [LogController::class, 'downloadLogs'])->name('logs.download');

    // Activity Logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs');
    Route::get('/activity-logs/get', [ActivityLogController::class, 'getLogs'])->name('activity-logs.get');
    Route::get('/activity-logs/statistics', [ActivityLogController::class, 'getStatistics'])->name('activity-logs.statistics');
    Route::get('/activity-logs/user/{userId}', [ActivityLogController::class, 'getUserActivity'])->name('activity-logs.user');
    Route::get('/activity-logs/model/{modelType}/{modelId}', [ActivityLogController::class, 'getModelActivity'])->name('activity-logs.model');
    Route::get('/activity-logs/export', [ActivityLogController::class, 'export'])->name('activity-logs.export');
    Route::post('/activity-logs/clear-old', [ActivityLogController::class, 'clearOldLogs'])->name('activity-logs.clear-old');

});
