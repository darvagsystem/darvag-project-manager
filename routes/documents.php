<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentCategoryController;

/*
|--------------------------------------------------------------------------
| Document Management Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to document management system.
| This includes document CRUD operations and category management.
|
*/

Route::middleware('auth')->prefix('panel')->name('panel.')->group(function () {

    // Document Management Routes
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/list', [DocumentController::class, 'list'])->name('documents.list');
    Route::resource('documents', DocumentController::class)->except(['index']);

    // Document specific routes
    Route::prefix('documents/{document}')->name('documents.')->group(function () {
        Route::get('/download', [DocumentController::class, 'download'])->name('download');
        Route::get('/download-version/{version}', [DocumentController::class, 'downloadVersion'])->name('download-version');
        Route::post('/upload-version', [DocumentController::class, 'uploadVersion'])->name('upload-version');
        Route::post('/set-current-version/{version}', [DocumentController::class, 'setCurrentVersion'])->name('set-current-version');
    });

    // Document Categories Routes
    Route::resource('document-categories', DocumentCategoryController::class)->parameters(['document-categories' => 'category']);

    // Category specific routes
    Route::prefix('document-categories/{category}')->name('document-categories.')->group(function () {
        Route::post('/toggle-status', [DocumentCategoryController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Category sort order update
    Route::post('/document-categories/update-sort-order', [DocumentCategoryController::class, 'updateSortOrder'])->name('document-categories.update-sort-order');
});
