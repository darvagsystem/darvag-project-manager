<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardToIbanController;

/*
|--------------------------------------------------------------------------
| Card to IBAN Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to card to IBAN conversion.
| This includes conversion, bank management and logs.
|
*/

Route::middleware('auth')->prefix('panel')->name('panel.')->group(function () {

    // Card to IBAN Management
    Route::get('/card-to-iban', [CardToIbanController::class, 'index'])->name('card-to-iban.index');
    Route::get('/card-to-iban/banks', [CardToIbanController::class, 'getBanks'])->name('card-to-iban.banks');
    Route::get('/card-to-iban/card-to-iban-logs', [CardToIbanController::class, 'viewLogs'])->name('card-to-iban.card-to-iban-logs');
    Route::post('/card-to-iban/convert', [CardToIbanController::class, 'convert'])->name('card-to-iban.convert');
    Route::post('/card-to-iban/update-cookies', [CardToIbanController::class, 'updateCookies'])->name('card-to-iban.update-cookies');

});
