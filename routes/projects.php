<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectEmployeeController;
use App\Http\Controllers\FileManagerController;
use App\Models\Project;

// Route Model Binding for projects
Route::model('project', Project::class);

/*
|--------------------------------------------------------------------------
| Project Management Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to project management system.
| This includes project CRUD operations and project-specific file management.
|
*/

Route::middleware('auth')->prefix('panel')->name('panel.')->group(function () {

    // Projects
    Route::resource('projects', ProjectController::class);

    // Project Templates - Copy structure from one project to another
    Route::post('/project-templates/create-from-project', [ProjectController::class, 'copyStructure'])->name('project-templates.create-from-project');

    // Test route
    Route::get('/test-project/{project}', function(Project $project) {
        return response()->json(['project_id' => $project->id, 'project_name' => $project->name]);
    })->name('test-project');

    // Project specific routes
    Route::prefix('projects/{project}')->name('projects.')->group(function () {
        // Project Employees
        Route::resource('employees', ProjectEmployeeController::class, ['parameters' => ['employees' => 'projectEmployee']])->except(['show']);
        Route::post('/employees/{projectEmployee}/toggle-status', [ProjectEmployeeController::class, 'toggleStatus'])->name('employees.toggle-status');
        Route::get('/employees-report', [ProjectEmployeeController::class, 'report'])->name('employees.report');

        // Project File Manager
        Route::prefix('filemanager')->name('filemanager.')->group(function () {
            Route::get('/', function(Project $project) {
                return view('admin.file-manager.project-livewire', compact('project'));
            })->name('index');
            Route::get('/files', [FileManagerController::class, 'getFiles'])->name('files');
            Route::post('/create-folder', [FileManagerController::class, 'createFolder'])->name('create-folder');
            Route::post('/upload', [FileManagerController::class, 'upload'])->name('upload');
            Route::post('/upload-chunk', [FileManagerController::class, 'uploadChunk'])->name('upload-chunk');
            Route::get('/thumbnail/{file}', [FileManagerController::class, 'thumbnail'])->name('thumbnail');
            Route::get('/thumbnail', [FileManagerController::class, 'thumbnailPost'])->name('thumbnail.post');
            Route::get('/download/{file}', [FileManagerController::class, 'download'])->name('download');
            Route::post('/download', [FileManagerController::class, 'downloadPost'])->name('download.post');
            Route::put('/{file}/rename', [FileManagerController::class, 'rename'])->name('rename');
            Route::post('/rename', [FileManagerController::class, 'renamePost'])->name('rename.post');
            Route::post('/delete', [FileManagerController::class, 'delete'])->name('delete');

            // Tag routes
            Route::get('/tags', [FileManagerController::class, 'getTags'])->name('tags');
            Route::post('/{file}/tags', [FileManagerController::class, 'addTag'])->name('add-tag');
            Route::delete('/{file}/tags/{tag}', [FileManagerController::class, 'removeTag'])->name('remove-tag');
            Route::get('/filter/tag/{tag}', [FileManagerController::class, 'filterByTag'])->name('filter-tag');
        });
    });

});

