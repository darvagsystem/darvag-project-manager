<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileManagerController;

/*
|--------------------------------------------------------------------------
| File Manager Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to file management system.
| This includes file upload, download, rename, delete and tag management.
|
*/

Route::middleware('auth')->prefix('panel')->name('panel.')->group(function () {

    // File Upload Page
    Route::get('/upload-files', [FileManagerController::class, 'uploadPage'])->name('upload-files');
    Route::post('/upload-files', [FileManagerController::class, 'uploadFiles'])->name('upload-files.store');

    // General File Manager
    Route::prefix('file-manager')->name('file-manager.')->group(function () {
        Route::get('/', [FileManagerController::class, 'index'])->name('index');
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
