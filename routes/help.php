<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelpController;

/*
|--------------------------------------------------------------------------
| Help Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to help system.
| This includes help documentation and guides.
|
*/

Route::middleware('auth')->prefix('panel')->name('panel.')->group(function () {
    // Help Documentation
    Route::get('/help', [HelpController::class, 'index'])->name('help.index');
    Route::get('/help/dashboard', [HelpController::class, 'dashboard'])->name('help.dashboard');
    Route::get('/help/getting-started', [HelpController::class, 'gettingStarted'])->name('help.getting-started');
    Route::get('/help/projects', [HelpController::class, 'projects'])->name('help.projects');
    Route::get('/help/employees', [HelpController::class, 'employees'])->name('help.employees');
    Route::get('/help/project-employees', [HelpController::class, 'projectEmployees'])->name('help.project-employees');
    Route::get('/help/clients', [HelpController::class, 'clients'])->name('help.clients');
    Route::get('/help/bank-accounts', [HelpController::class, 'bankAccounts'])->name('help.bank-accounts');
    Route::get('/help/settings', [HelpController::class, 'settings'])->name('help.settings');

});
