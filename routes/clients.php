<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientPhonebookController;

/*
|--------------------------------------------------------------------------
| Client Management Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to client management system.
| This includes client CRUD operations and phonebook management.
|
*/

Route::middleware('auth')->prefix('panel')->name('panel.')->group(function () {

    // Client Management Routes
    Route::resource('clients', ClientController::class);

    // Client Phonebook Routes
    Route::prefix('clients/{client}')->name('clients.phonebook.')->group(function () {
        Route::get('/phonebook', [ClientPhonebookController::class, 'index'])->name('index');
        Route::get('/phonebook/create', [ClientPhonebookController::class, 'create'])->name('create');
        Route::post('/phonebook', [ClientPhonebookController::class, 'store'])->name('store');
        Route::get('/phonebook/{phonebook}/edit', [ClientPhonebookController::class, 'edit'])->name('edit');
        Route::put('/phonebook/{phonebook}', [ClientPhonebookController::class, 'update'])->name('update');
        Route::delete('/phonebook/{phonebook}', [ClientPhonebookController::class, 'destroy'])->name('destroy');
        Route::post('/phonebook/{phonebook}/toggle-status', [ClientPhonebookController::class, 'toggleStatus'])->name('toggle-status');
    });

});
