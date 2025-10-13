<?php

use Illuminate\Support\Facades\Route;

// Include Website Routes
require __DIR__.'/website.php';

// Include Authentication Routes
require __DIR__.'/auth.php';

// Include No Access Routes
require __DIR__.'/no-access.php';

// Include Profile Routes
require __DIR__.'/profile.php';

// Include Dashboard Routes
require __DIR__.'/dashboard.php';

// Include Employee Management Routes
require __DIR__.'/employees.php';

// Include Client Management Routes
require __DIR__.'/clients.php';

// Include Project Management Routes
require __DIR__.'/projects.php';

// Include Document Management Routes
require __DIR__.'/documents.php';

// Include File Manager Routes
require __DIR__.'/file-manager.php';

// Include Tag Management Routes
require __DIR__.'/tags.php';

// Include Task Management Routes
require __DIR__.'/tasks.php';

// Include Card to IBAN Routes
require __DIR__.'/card-to-iban.php';

// Include System Management Routes
require __DIR__.'/system.php';

// Include Log Management Routes
require __DIR__.'/logs.php';

// Include Help Routes
require __DIR__.'/help.php';

// Include Backup Routes
require __DIR__.'/backup.php';

// Include Checklist Routes
require __DIR__.'/checklists.php';

// Include Contact Messages Routes
require __DIR__.'/contact-messages.php';

// Include API Routes
require __DIR__.'/api.php';

// Route Model Binding
Route::model('employee', \App\Models\Employee::class);
Route::model('client', \App\Models\Client::class);
Route::model('file', \App\Models\FileManager::class);
Route::model('company', \App\Models\Company::class);
Route::model('phonebook', \App\Models\ClientPhonebook::class);
Route::model('projectEmployee', \App\Models\ProjectEmployee::class);
Route::model('contactMessage', \App\Models\ContactMessage::class);
