<?php

use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ChecklistCategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Checklist Routes
|--------------------------------------------------------------------------
|
| Here are the routes for checklist management functionality.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

Route::middleware(['auth'])->prefix('panel')->name('panel.')->group(function () {
    // Checklist CRUD routes
    Route::resource('checklists', ChecklistController::class);
    Route::get('checklists/{checklist}/print', [ChecklistController::class, 'print'])->name('checklists.print');

    // Additional checklist item routes
    Route::post('checklists/{checklist}/items', [ChecklistController::class, 'addItem'])->name('checklists.items.store');
    Route::put('checklists/{checklist}/items/{item}', [ChecklistController::class, 'updateItem'])->name('checklists.items.update');
    Route::delete('checklists/{checklist}/items/{item}', [ChecklistController::class, 'deleteItem'])->name('checklists.items.destroy');
    Route::post('checklists/{checklist}/items/{item}/toggle', [ChecklistController::class, 'toggleItem'])->name('checklists.items.toggle');

    // Checklist Category routes
    Route::resource('checklist-categories', ChecklistCategoryController::class);
});
