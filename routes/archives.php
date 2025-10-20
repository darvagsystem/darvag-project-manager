<?php

use App\Http\Controllers\ArchiveController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('panel')->group(function () {
    Route::resource('archives', ArchiveController::class);
    Route::get('archives/{archive}/manage', [ArchiveController::class, 'show'])->name('archives.manage');
    Route::post('archives/{archive}/files/upload', [ArchiveController::class, 'uploadFiles'])->name('archives.files.upload');
});
