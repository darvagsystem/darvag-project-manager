<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    DashboardController,
    AdminController,
    BankController,
    EmployeeController,
    EmployeeBankAccountController,
    ProjectController,
    ProjectEmployeeController,
    ClientController,
    ClientContactController,
    HelpController,
    FileManagerController,
    ProjectTemplateController,
    TagController,
    TaskController
};
use App\Models\{User, Project};
use Illuminate\Support\Facades\Hash;

// Redirect root to panel
Route::get('/', function () {
    return redirect('/panel');
});

// Authentication Routes (Public)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Logout (Authenticated)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Panel Routes (All authenticated routes under panel prefix)
Route::middleware('auth')->prefix('panel')->name('panel.')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.alt');

    // Employees
    Route::resource('employees', EmployeeController::class);
    Route::prefix('employees/{employee}')->name('employees.')->group(function () {
        Route::get('/bank-accounts', [EmployeeBankAccountController::class, 'index'])->name('bank-accounts');
        Route::post('/bank-accounts', [EmployeeBankAccountController::class, 'store'])->name('bank-accounts.store');
        Route::get('/documents', [EmployeeController::class, 'documents'])->name('documents');
        Route::get('/default-account', [EmployeeBankAccountController::class, 'getDefaultAccount'])->name('default-account');
    });

    // Employee Bank Accounts
    Route::prefix('employee-bank-accounts')->name('employee-bank-accounts.')->group(function () {
        Route::get('/{account}', [EmployeeBankAccountController::class, 'show'])->name('show');
        Route::put('/{account}', [EmployeeBankAccountController::class, 'update'])->name('update');
        Route::delete('/{account}', [EmployeeBankAccountController::class, 'destroy'])->name('destroy');
        Route::post('/{account}/set-default', [EmployeeBankAccountController::class, 'setAsDefault'])->name('set-default');
        Route::post('/{account}/toggle-status', [EmployeeBankAccountController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Validation Routes
    Route::post('/validate-iban', [EmployeeBankAccountController::class, 'validateIban'])->name('validate-iban');
    Route::post('/validate-card-number', [EmployeeBankAccountController::class, 'validateCardNumber'])->name('validate-card-number');

    // Clients
    Route::resource('clients', ClientController::class);
    Route::resource('clients.contacts', ClientContactController::class)->except(['index']);
    Route::get('/clients/{client}/contacts', [ClientContactController::class, 'index'])->name('clients.contacts.index');

    // Projects
    Route::resource('projects', ProjectController::class);
    Route::prefix('projects/{project}')->name('projects.')->group(function () {
        // Project Employees
        Route::resource('employees', ProjectEmployeeController::class)->except(['show']);
        Route::post('/employees/{projectEmployee}/toggle-status', [ProjectEmployeeController::class, 'toggleStatus'])->name('employees.toggle-status');

        // Project File Manager
        Route::prefix('filemanager')->name('filemanager.')->group(function () {
            Route::get('/', function(Project $project) {
                return view('admin.file-manager.project-livewire', compact('project'));
            })->name('index');
            Route::get('/files', [FileManagerController::class, 'getFiles'])->name('files');
            Route::post('/create-folder', [FileManagerController::class, 'createFolder'])->name('create-folder');
            Route::post('/upload', [FileManagerController::class, 'upload'])->name('upload');
            Route::get('/thumbnail/{file}', [FileManagerController::class, 'thumbnail'])->name('thumbnail');
            Route::get('/download/{file}', [FileManagerController::class, 'download'])->name('download');
            Route::put('/{file}/rename', [FileManagerController::class, 'rename'])->name('rename');
            Route::delete('/delete', [FileManagerController::class, 'delete'])->name('delete');

            // Tag routes
            Route::get('/tags', [FileManagerController::class, 'getTags'])->name('tags');
            Route::post('/{file}/tags', [FileManagerController::class, 'addTag'])->name('add-tag');
            Route::delete('/{file}/tags/{tag}', [FileManagerController::class, 'removeTag'])->name('remove-tag');
            Route::get('/filter/tag/{tag}', [FileManagerController::class, 'filterByTag'])->name('filter-tag');
        });
    });

    // General File Manager
    Route::prefix('file-manager')->name('file-manager.')->group(function () {
        Route::get('/', function() {
            return view('admin.file-manager.livewire');
        })->name('index');
        Route::get('/files', [FileManagerController::class, 'getFiles'])->name('files');
        Route::post('/create-folder', [FileManagerController::class, 'createFolder'])->name('create-folder');
        Route::post('/upload', [FileManagerController::class, 'upload'])->name('upload');
        Route::get('/thumbnail/{file}', [FileManagerController::class, 'thumbnail'])->name('thumbnail');
        Route::get('/download/{file}', [FileManagerController::class, 'download'])->name('download');
        Route::put('/{file}/rename', [FileManagerController::class, 'rename'])->name('rename');
        Route::delete('/delete', [FileManagerController::class, 'delete'])->name('delete');

        // Tag routes
        Route::get('/tags', [FileManagerController::class, 'getTags'])->name('tags');
        Route::post('/{file}/tags', [FileManagerController::class, 'addTag'])->name('add-tag');
        Route::delete('/{file}/tags/{tag}', [FileManagerController::class, 'removeTag'])->name('remove-tag');
        Route::get('/filter/tag/{tag}', [FileManagerController::class, 'filterByTag'])->name('filter-tag');
    });

    // Tags Management
    Route::resource('tags', TagController::class);
    Route::get('/tags-api', [TagController::class, 'getTags'])->name('tags.api');
    Route::get('/tags/{tag}/files', [TagController::class, 'files'])->name('tags.files');
    Route::post('/tags/{tag}/bulk-download', [TagController::class, 'bulkDownload'])->name('tags.bulk-download');
    Route::post('/tags/{tag}/merge-pdf', [TagController::class, 'mergePdf'])->name('tags.merge-pdf');

    // Tasks Management
    Route::resource('tasks', TaskController::class);
    Route::get('/tasks-dashboard', [TaskController::class, 'dashboard'])->name('tasks.dashboard');
    Route::get('/my-tasks', [TaskController::class, 'myTasks'])->name('tasks.my-tasks');
    Route::post('/tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [AdminController::class, 'settings'])->name('index');
        Route::get('/company', [AdminController::class, 'companySettings'])->name('company');
        Route::post('/company', [AdminController::class, 'settingsUpdate'])->name('company.update');

        // Banks
        Route::resource('banks', BankController::class);
        Route::post('/banks/seed', [BankController::class, 'seed'])->name('banks.seed');
    });

    // Project Templates
    Route::resource('project-templates', ProjectTemplateController::class);
    Route::post('/project-templates/apply', [ProjectTemplateController::class, 'applyToProject'])->name('project-templates.apply');
    Route::post('/project-templates/create-from-project', [ProjectTemplateController::class, 'createFromProject'])->name('project-templates.create-from-project');

    // Services
    Route::get('/services', [AdminController::class, 'services'])->name('services');

    // Blog
    Route::get('/blog', [AdminController::class, 'blog'])->name('blog');

    // Gallery
    Route::get('/gallery', [AdminController::class, 'gallery'])->name('gallery');

    // Help
    Route::get('/help', [HelpController::class, 'index'])->name('help');
    Route::prefix('help')->name('help.')->group(function () {
        Route::get('/', [HelpController::class, 'index'])->name('index');
        Route::get('/getting-started', [HelpController::class, 'gettingStarted'])->name('getting-started');
        Route::get('/dashboard', [HelpController::class, 'dashboard'])->name('dashboard');
        Route::get('/employees', [HelpController::class, 'employees'])->name('employees');
        Route::get('/projects', [HelpController::class, 'projects'])->name('projects');
        Route::get('/clients', [HelpController::class, 'clients'])->name('clients');
        Route::get('/settings', [HelpController::class, 'settings'])->name('settings');
        Route::get('/bank-accounts', [HelpController::class, 'bankAccounts'])->name('bank-accounts');
        Route::get('/project-employees', [HelpController::class, 'projectEmployees'])->name('project-employees');
    });

    // System
    Route::get('/backup', [AdminController::class, 'backup'])->name('backup');
    Route::get('/logs', [AdminController::class, 'logs'])->name('logs');

    // API Routes
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/stats', [AdminController::class, 'getStats'])->name('stats');
        Route::get('/project-templates', [ProjectTemplateController::class, 'getTemplatesForProject'])->name('project-templates');
        Route::get('/projects', function() {
            return response()->json(['projects' => Project::select('id', 'name')->get()]);
        })->name('projects');
    });
});

// Route Model Binding
Route::model('employee', \App\Models\Employee::class);
Route::model('client', \App\Models\Client::class);
Route::model('file', \App\Models\FileManager::class);
