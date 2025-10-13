<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ContactMessageController;

/*
|--------------------------------------------------------------------------
| Contact Messages Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to contact messages management.
| This includes viewing, updating, and managing contact messages.
|
*/

Route::middleware('auth')->prefix('panel')->name('admin.')->group(function () {
    
    // Contact Messages Management
    Route::resource('contact-messages', ContactMessageController::class)->except(['create', 'edit']);
    
    // Additional routes for contact messages
    Route::prefix('contact-messages')->name('contact-messages.')->group(function () {
        Route::post('/{contactMessage}/mark-read', [ContactMessageController::class, 'markAsRead'])->name('mark-read');
        Route::post('/{contactMessage}/mark-replied', [ContactMessageController::class, 'markAsReplied'])->name('mark-replied');
        Route::post('/{contactMessage}/mark-closed', [ContactMessageController::class, 'markAsClosed'])->name('mark-closed');
        Route::post('/bulk-action', [ContactMessageController::class, 'bulkAction'])->name('bulk-action');
    });
    
});
