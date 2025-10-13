<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Backup Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to backup system.
| This includes database backup and restore.
|
*/

Route::middleware('auth')->prefix('panel')->name('panel.')->group(function () {

    // Backup Management
    Route::get('/backup', [AdminController::class, 'backup'])->name('backup');

});
