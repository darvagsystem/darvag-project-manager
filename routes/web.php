<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeBankAccountController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectEmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientContactController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\ProjectTemplateController;

Route::get('/', function () {
    return view('welcome');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    Route::get('/services', [AdminController::class, 'services'])->name('services');
    Route::get('/blog', [AdminController::class, 'blog'])->name('blog');
    Route::get('/gallery', [AdminController::class, 'gallery'])->name('gallery');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/roles', [AdminController::class, 'roles'])->name('roles');

    // Settings routes
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::get('/settings/company', [AdminController::class, 'companySettings'])->name('settings.company');
    Route::post('/settings/company', [AdminController::class, 'settingsUpdate'])->name('settings.company.update');

    // Banks management routes
    Route::get('/settings/banks', [BankController::class, 'index'])->name('settings.banks');
    Route::get('/settings/banks/create', [BankController::class, 'create'])->name('settings.banks.create');
    Route::post('/settings/banks', [BankController::class, 'store'])->name('settings.banks.store');
    Route::get('/settings/banks/{id}/edit', [BankController::class, 'edit'])->name('settings.banks.edit');
    Route::put('/settings/banks/{id}', [BankController::class, 'update'])->name('settings.banks.update');
    Route::delete('/settings/banks/{id}', [BankController::class, 'destroy'])->name('settings.banks.destroy');
    Route::post('/settings/banks/seed', [BankController::class, 'seed'])->name('settings.banks.seed');

    Route::get('/backup', [AdminController::class, 'backup'])->name('backup');
    Route::get('/logs', [AdminController::class, 'logs'])->name('logs');

    // API routes for dashboard
    Route::get('/api/stats', [AdminController::class, 'getStats'])->name('api.stats');

    // Help routes
    Route::get('/help', [HelpController::class, 'index'])->name('help');
    Route::get('/help/getting-started', [HelpController::class, 'gettingStarted'])->name('help.getting-started');
    Route::get('/help/dashboard', [HelpController::class, 'dashboard'])->name('help.dashboard');
    Route::get('/help/employees', [HelpController::class, 'employees'])->name('help.employees');
    Route::get('/help/projects', [HelpController::class, 'projects'])->name('help.projects');
    Route::get('/help/clients', [HelpController::class, 'clients'])->name('help.clients');
    Route::get('/help/attendance', [HelpController::class, 'attendance'])->name('help.attendance');
    Route::get('/help/settings', [HelpController::class, 'settings'])->name('help.settings');
    Route::get('/help/bank-accounts', [HelpController::class, 'bankAccounts'])->name('help.bank-accounts');
    Route::get('/help/project-employees', [HelpController::class, 'projectEmployees'])->name('help.project-employees');

    // Project Templates routes
    Route::get('/project-templates', [ProjectTemplateController::class, 'index'])->name('project-templates.index');
    Route::get('/project-templates/create', [ProjectTemplateController::class, 'create'])->name('project-templates.create');
    Route::post('/project-templates', [ProjectTemplateController::class, 'store'])->name('project-templates.store');
    Route::get('/project-templates/{id}', [ProjectTemplateController::class, 'show'])->name('project-templates.show');
    Route::get('/project-templates/{id}/edit', [ProjectTemplateController::class, 'edit'])->name('project-templates.edit');
    Route::put('/project-templates/{id}', [ProjectTemplateController::class, 'update'])->name('project-templates.update');
    Route::delete('/project-templates/{id}', [ProjectTemplateController::class, 'destroy'])->name('project-templates.destroy');
    Route::post('/project-templates/apply', [ProjectTemplateController::class, 'applyToProject'])->name('project-templates.apply');
    Route::post('/project-templates/create-from-project', [ProjectTemplateController::class, 'createFromProject'])->name('project-templates.create-from-project');
    Route::get('/api/project-templates', [ProjectTemplateController::class, 'getTemplatesForProject'])->name('api.project-templates');
    Route::get('/api/projects', function() {
        $projects = \App\Models\Project::select('id', 'name')->get();
        return response()->json(['projects' => $projects]);
    })->name('api.projects');

    // Logout route
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
});

// Employee routes (separate resource routes)
Route::resource('employees', EmployeeController::class);
Route::get('/employees/{id}/bank-accounts', [EmployeeBankAccountController::class, 'index'])->name('employees.bank-accounts');
Route::get('/employees/{id}/documents', [EmployeeController::class, 'documents'])->name('employees.documents');
Route::get('/employees-test', [EmployeeController::class, 'test'])->name('employees.test');
Route::post('/employees-test-store', [EmployeeController::class, 'testStore'])->name('employees.test-store');
Route::get('/employees-test-form', [EmployeeController::class, 'testForm'])->name('employees.test-form');

// Employee Bank Account routes
Route::get('/employees/{id}/bank-accounts', [EmployeeBankAccountController::class, 'index'])->name('employees.bank-accounts');
Route::post('/employees/{id}/bank-accounts', [EmployeeBankAccountController::class, 'store'])->name('employees.bank-accounts.store');
Route::get('/employee-bank-accounts/{id}', [EmployeeBankAccountController::class, 'show'])->name('employee-bank-accounts.show');
Route::put('/employee-bank-accounts/{id}', [EmployeeBankAccountController::class, 'update'])->name('employee-bank-accounts.update');
Route::delete('/employee-bank-accounts/{id}', [EmployeeBankAccountController::class, 'destroy'])->name('employee-bank-accounts.destroy');
Route::post('/employee-bank-accounts/{id}/set-default', [EmployeeBankAccountController::class, 'setAsDefault'])->name('employee-bank-accounts.set-default');
Route::post('/employee-bank-accounts/{id}/toggle-status', [EmployeeBankAccountController::class, 'toggleStatus'])->name('employee-bank-accounts.toggle-status');
Route::get('/employees/{id}/default-account', [EmployeeBankAccountController::class, 'getDefaultAccount'])->name('employees.default-account');
Route::post('/validate-iban', [EmployeeBankAccountController::class, 'validateIban'])->name('validate-iban');
Route::post('/validate-card-number', [EmployeeBankAccountController::class, 'validateCardNumber'])->name('validate-card-number');

// Project routes (separate resource routes)
Route::resource('projects', ProjectController::class);

// Project Employee routes
Route::get('/projects/{project}/employees', [ProjectEmployeeController::class, 'index'])->name('projects.employees.index');
Route::get('/projects/{project}/employees/create', [ProjectEmployeeController::class, 'create'])->name('projects.employees.create');
Route::post('/projects/{project}/employees', [ProjectEmployeeController::class, 'store'])->name('projects.employees.store');
Route::get('/projects/{project}/employees/{projectEmployee}/edit', [ProjectEmployeeController::class, 'edit'])->name('projects.employees.edit');
Route::put('/projects/{project}/employees/{projectEmployee}', [ProjectEmployeeController::class, 'update'])->name('projects.employees.update');
Route::delete('/projects/{project}/employees/{projectEmployee}', [ProjectEmployeeController::class, 'destroy'])->name('projects.employees.destroy');
Route::post('/projects/{project}/employees/{projectEmployee}/toggle-status', [ProjectEmployeeController::class, 'toggleStatus'])->name('projects.employees.toggle-status');

// Attendance routes
Route::get('/projects/{project}/attendance', [AttendanceController::class, 'index'])->name('projects.attendance.index');
Route::get('/projects/{project}/attendance/create', [AttendanceController::class, 'create'])->name('projects.attendance.create');
Route::post('/projects/{project}/attendance', [AttendanceController::class, 'store'])->name('projects.attendance.store');
Route::get('/projects/{project}/attendance/{date}', [AttendanceController::class, 'show'])->name('projects.attendance.show');
Route::put('/projects/{project}/attendance/{attendance}', [AttendanceController::class, 'update'])->name('projects.attendance.update');
Route::delete('/projects/{project}/attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('projects.attendance.destroy');

// Client routes (separate resource routes)
Route::resource('clients', ClientController::class);

// Client Contact routes
Route::get('/clients/{client}/contacts', [ClientContactController::class, 'index'])->name('clients.contacts.index');
Route::get('/clients/{client}/contacts/create', [ClientContactController::class, 'create'])->name('clients.contacts.create');
Route::post('/clients/{client}/contacts', [ClientContactController::class, 'store'])->name('clients.contacts.store');
Route::get('/clients/{client}/contacts/{contact}/edit', [ClientContactController::class, 'edit'])->name('clients.contacts.edit');
Route::put('/clients/{client}/contacts/{contact}', [ClientContactController::class, 'update'])->name('clients.contacts.update');
Route::delete('/clients/{client}/contacts/{contact}', [ClientContactController::class, 'destroy'])->name('clients.contacts.destroy');

// File Manager routes
Route::get('/file-manager', [FileManagerController::class, 'index'])->name('file-manager.index');
Route::post('/file-manager/create-folder', [FileManagerController::class, 'createFolder'])->name('file-manager.create-folder');
Route::post('/file-manager/upload', [FileManagerController::class, 'upload'])->name('file-manager.upload');
Route::get('/file-manager/download/{id}', [FileManagerController::class, 'download'])->name('file-manager.download');
Route::post('/file-manager/bulk-download', [FileManagerController::class, 'bulkDownload'])->name('file-manager.bulk-download');
Route::put('/file-manager/{id}/rename', [FileManagerController::class, 'rename'])->name('file-manager.rename');
Route::post('/file-manager/move', [FileManagerController::class, 'move'])->name('file-manager.move');
Route::delete('/file-manager/delete', [FileManagerController::class, 'delete'])->name('file-manager.delete');
Route::get('/file-manager/{id}/details', [FileManagerController::class, 'details'])->name('file-manager.details');
Route::get('/file-manager/search', [FileManagerController::class, 'search'])->name('file-manager.search');

// Project File Manager routes
Route::get('/projects/{project}/filemanager', [FileManagerController::class, 'projectFiles'])->name('projects.filemanager');
Route::post('/projects/{project}/filemanager/create-folder', [FileManagerController::class, 'createFolder'])->name('projects.filemanager.create-folder');
Route::post('/projects/{project}/filemanager/upload', [FileManagerController::class, 'upload'])->name('projects.filemanager.upload');
Route::get('/projects/{project}/filemanager/download/{id}', [FileManagerController::class, 'download'])->name('projects.filemanager.download');
Route::post('/projects/{project}/filemanager/bulk-download', [FileManagerController::class, 'bulkDownload'])->name('projects.filemanager.bulk-download');
Route::put('/projects/{project}/filemanager/{id}/rename', [FileManagerController::class, 'rename'])->name('projects.filemanager.rename');
Route::post('/projects/{project}/filemanager/move', [FileManagerController::class, 'move'])->name('projects.filemanager.move');
Route::delete('/projects/{project}/filemanager/delete', [FileManagerController::class, 'delete'])->name('projects.filemanager.delete');
Route::get('/projects/{project}/filemanager/{id}/details', [FileManagerController::class, 'details'])->name('projects.filemanager.details');
Route::get('/projects/{project}/filemanager/search', [FileManagerController::class, 'search'])->name('projects.filemanager.search');
