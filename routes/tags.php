<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TagCategoryController;

/*
|--------------------------------------------------------------------------
| Tag Management Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to tag management system.
| This includes tag CRUD operations and category management.
|
*/

Route::middleware('auth')->prefix('panel')->name('panel.')->group(function () {

    // Tag Categories Management
    Route::resource('tag-categories', TagCategoryController::class);

    // Tags Management
    Route::resource('tags', TagController::class);
    Route::get('/tags/{tag}/files', [TagController::class, 'files'])->name('tags.files');
    Route::get('/tags-api', [TagController::class, 'getTags'])->name('tags.api');

});
