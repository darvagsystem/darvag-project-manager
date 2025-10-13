<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| No Access Routes
|--------------------------------------------------------------------------
|
| Here are the routes related to access control.
| This includes no-access page for unauthorized users.
|
*/

Route::middleware('auth')->prefix('panel')->name('panel.')->group(function () {

    // No Access Page
    Route::get('/no-access', function () {
        return view('admin.no-access');
    })->name('no-access');

});
