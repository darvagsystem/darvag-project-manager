<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tasks\TaskController;

/*
|--------------------------------------------------------------------------
| Task Management Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to task management system.
| This includes task CRUD operations and workflow management.
|
*/

Route::middleware('auth')->prefix('panel')->name('panel.')->group(function () {

    // Tasks Management
    Route::resource('tasks', TaskController::class);
    Route::get('/tasks-dashboard', [TaskController::class, 'dashboard'])->name('tasks.dashboard');
    Route::get('/my-tasks', [TaskController::class, 'myTasks'])->name('tasks.my-tasks');

    // Task Actions
    Route::post('/tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');
    Route::post('/tasks/{task}/start', [TaskController::class, 'start'])->name('tasks.start');
    Route::post('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');

    // Task Comments and Attachments
    Route::post('/tasks/{task}/add-comment', [TaskController::class, 'addComment'])->name('tasks.add-comment');
    Route::post('/tasks/{task}/upload-file', [TaskController::class, 'uploadFile'])->name('tasks.upload-file');
    Route::get('/tasks/attachment/{attachment}/download', [TaskController::class, 'downloadAttachment'])->name('tasks.attachment.download');

});
