<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskCategoryController;
use Illuminate\Support\Facades\Route;

// Task Management Routes
Route::middleware(['auth'])->prefix('panel')->group(function () {
    // Task routes
    Route::resource('tasks', TaskController::class);

    // Additional task routes
    Route::post('tasks/{task}/upload-file', [TaskController::class, 'uploadFile'])->name('tasks.upload-file');
    Route::delete('task-files/{file}', [TaskController::class, 'deleteFile'])->name('task-files.destroy');
    Route::post('tasks/{task}/add-comment', [TaskController::class, 'addComment'])->name('tasks.add-comment');
    Route::patch('tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');
    Route::get('tasks-overdue', [TaskController::class, 'overdue'])->name('tasks.overdue');
    Route::get('my-tasks', [TaskController::class, 'myTasks'])->name('tasks.my-tasks');

    // Task Category routes
    Route::resource('task-categories', TaskCategoryController::class);
    Route::patch('task-categories/{taskCategory}/toggle-status', [TaskCategoryController::class, 'toggleStatus'])->name('task-categories.toggle-status');
});
