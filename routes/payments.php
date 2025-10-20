<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentRecipientController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\ProjectFinanceController;

/*
|--------------------------------------------------------------------------
| Payment Management Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to payment management system.
| This includes payment CRUD operations and recipient management.
|
*/

Route::middleware('auth')->prefix('panel')->name('panel.')->group(function () {

    // Payment Types - Moved to project settings

    // Payment Recipients
    Route::resource('payment-recipients', PaymentRecipientController::class);
    Route::get('payment-recipients/{recipient}/bank-accounts', [PaymentRecipientController::class, 'getBankAccounts'])->name('payment-recipients.bank-accounts');

    // Project Payments
    Route::prefix('projects/{project}')->name('projects.')->group(function () {
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
        Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
        Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
        Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');
        Route::patch('/payments/{payment}/status', [PaymentController::class, 'updateStatus'])->name('payments.update-status');

        // Project Finance
        Route::get('/finance', [ProjectFinanceController::class, 'dashboard'])->name('finance.dashboard');
        Route::get('/finance/incomes', [ProjectFinanceController::class, 'incomes'])->name('finance.incomes');
        Route::get('/finance/expenses', [ProjectFinanceController::class, 'expenses'])->name('finance.expenses');
        Route::get('/finance/payments', [ProjectFinanceController::class, 'payments'])->name('finance.payments');
        Route::get('/finance/profit-loss', [ProjectFinanceController::class, 'profitLoss'])->name('finance.profit-loss');

        // Project Settings - Payment Types
        Route::get('/settings/payment-types', [PaymentTypeController::class, 'index'])->name('settings.payment-types.index');
        Route::get('/settings/payment-types/create', [PaymentTypeController::class, 'create'])->name('settings.payment-types.create');
        Route::post('/settings/payment-types', [PaymentTypeController::class, 'store'])->name('settings.payment-types.store');
        Route::get('/settings/payment-types/{paymentType}', [PaymentTypeController::class, 'show'])->name('settings.payment-types.show');
        Route::get('/settings/payment-types/{paymentType}/edit', [PaymentTypeController::class, 'edit'])->name('settings.payment-types.edit');
        Route::put('/settings/payment-types/{paymentType}', [PaymentTypeController::class, 'update'])->name('settings.payment-types.update');
        Route::delete('/settings/payment-types/{paymentType}', [PaymentTypeController::class, 'destroy'])->name('settings.payment-types.destroy');
        Route::patch('/settings/payment-types/{paymentType}/toggle-status', [PaymentTypeController::class, 'toggleStatus'])->name('settings.payment-types.toggle-status');
        Route::post('/settings/payment-types/reorder', [PaymentTypeController::class, 'reorder'])->name('settings.payment-types.reorder');
    });

});
