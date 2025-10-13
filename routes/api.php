<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Models\Project;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here are all the API routes for the application.
| This includes stats, projects data, and other API endpoints.
|
*/

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/stats', [AdminController::class, 'getStats'])->name('stats');
    Route::get('/projects', function() {
        return response()->json(['projects' => Project::select('id', 'name')->get()]);
    })->name('projects');
});
