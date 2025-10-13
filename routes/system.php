<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BankController;

/*
|--------------------------------------------------------------------------
| System Management Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to system management.
| This includes users, roles, permissions, settings and banks.
|
*/

Route::middleware('auth')->prefix('panel')->name('panel.')->group(function () {

    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Roles Management
    Route::get('/roles', function () {
        return view('admin.roles.index');
    })->name('roles.index');

    // Permissions Management
    Route::get('/permissions', function () {
        return view('admin.permissions.index');
    })->name('permissions.index');

    // Settings Management
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings.index');
    Route::get('/settings/company', [AdminController::class, 'companySettings'])->name('settings.company');
    Route::post('/settings/company', [AdminController::class, 'settingsUpdate'])->name('settings.company.update');

    // Banks Management
    Route::resource('settings/banks', BankController::class)->names([
        'index' => 'settings.banks.index',
        'create' => 'settings.banks.create',
        'store' => 'settings.banks.store',
        'show' => 'settings.banks.show',
        'edit' => 'settings.banks.edit',
        'update' => 'settings.banks.update',
        'destroy' => 'settings.banks.destroy',
    ]);
    Route::post('/settings/banks/seed', [BankController::class, 'seed'])->name('settings.banks.seed');

});
