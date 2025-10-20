<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectEmployeeController;
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

        // Bulk employee operations
        Route::get('/employees/bulk/create', [ProjectEmployeeController::class, 'bulkCreate'])->name('employees.bulk-create');
        Route::post('/employees/bulk/store', [ProjectEmployeeController::class, 'bulkStore'])->name('employees.bulk-store');

        // File Manager - redirect to archive management
        Route::get('/filemanager', function(Project $project) {
            $archive = $project->archive;
            if (!$archive) {
                return redirect()->route('panel.projects.show', $project)
                    ->with('error', 'این پروژه هنوز بایگانی ندارد. لطفاً ابتدا بایگانی ایجاد کنید.');
            }
            return redirect()->route('panel.archives.manage', $archive);
        })->name('filemanager.index');

    });

});

