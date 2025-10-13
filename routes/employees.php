<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeBankAccountController;
use App\Http\Controllers\EmployeeReportController;

/*
|--------------------------------------------------------------------------
| Employee Management Routes
|--------------------------------------------------------------------------
|
| Here are all the routes related to employee management system.
| This includes employee CRUD operations and bank account management.
|
*/


// Test route without auth middleware
Route::get('/panel/employees/reports-test', function () {
    return 'Reports test route is working!';
});

// Test main reports route without auth middleware
Route::get('/panel/employees/reports-no-auth', function () {
    try {
        $banks = \App\Models\Bank::active()->get();
        $totalEmployees = \App\Models\Employee::count();
        $employeesWithBankAccounts = \App\Models\Employee::whereHas('bankAccounts')->count();

        return view('admin.employees.reports.index', compact('banks', 'totalEmployees', 'employeesWithBankAccounts'));
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::middleware('auth')->prefix('panel')->name('panel.')->group(function () {


    // Employees
    Route::resource('employees', EmployeeController::class);

    // Employee specific routes
    Route::prefix('employees/{employee}')->name('employees.')->group(function () {
        Route::get('/bank-accounts', [EmployeeBankAccountController::class, 'index'])->name('bank-accounts');
        Route::post('/bank-accounts', [EmployeeBankAccountController::class, 'store'])->name('bank-accounts.store');
        Route::get('/documents', [EmployeeController::class, 'documents'])->name('documents');
        Route::get('/default-account', [EmployeeBankAccountController::class, 'getDefaultAccount'])->name('default-account');
    });

    // Employee Bank Accounts
    Route::prefix('employee-bank-accounts')->name('employee-bank-accounts.')->group(function () {
        Route::get('/{account}', [EmployeeBankAccountController::class, 'show'])->name('show');
        Route::get('/{account}/edit', [EmployeeBankAccountController::class, 'edit'])->name('edit');
        Route::put('/{account}', [EmployeeBankAccountController::class, 'update'])->name('update');
        Route::delete('/{account}', [EmployeeBankAccountController::class, 'destroy'])->name('destroy');
        Route::post('/{account}/set-default', [EmployeeBankAccountController::class, 'setAsDefault'])->name('set-default');
        Route::post('/{account}/toggle-status', [EmployeeBankAccountController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Validation Routes
    Route::post('/validate-iban', [EmployeeBankAccountController::class, 'validateIban'])->name('validate-iban');
    Route::post('/validate-card-number', [EmployeeBankAccountController::class, 'validateCardNumber'])->name('validate-card-number');

    // Card to IBAN Service Routes
    Route::post('/get-bank-info-from-card', [EmployeeBankAccountController::class, 'getBankInfoFromCard'])->name('get-bank-info-from-card');

    // Employee Reports Routes
    Route::prefix('employees/reports')->name('employees.reports.')->group(function () {
        Route::get('/', [EmployeeReportController::class, 'index'])->name('index');
        Route::get('/employees-list', [EmployeeReportController::class, 'employeesList'])->name('employees-list');
        Route::get('/employees-with-bank-accounts', [EmployeeReportController::class, 'employeesWithBankAccounts'])->name('employees-with-bank-accounts');
        Route::get('/bank-employees', [EmployeeReportController::class, 'bankEmployees'])->name('bank-employees');
        Route::get('/bank-accounts-summary', [EmployeeReportController::class, 'bankAccountsSummary'])->name('bank-accounts-summary');
        Route::get('/employee/{employee}/detail', [EmployeeReportController::class, 'employeeDetail'])->name('employee-detail');
        Route::get('/export', [EmployeeReportController::class, 'export'])->name('export');
    });

});
