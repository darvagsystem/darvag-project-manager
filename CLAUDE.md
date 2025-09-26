# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 11 project management system for "Darvag" construction company, supporting Persian/Farsi language. The system manages employees, clients, projects, and company settings with a focus on construction industry workflows.

## Development Commands

### Common Commands
- **Development server**: `composer dev` (runs Laravel server, queue worker, logs, and Vite dev in parallel)
- **Asset building**: `npm run build` (production build) or `npm run dev` (development)
- **Testing**: `vendor/bin/phpunit` or `php artisan test`
- **Code formatting**: `vendor/bin/pint` (Laravel Pint for PHP formatting)
- **Database operations**:
  - `php artisan migrate` - Run migrations
  - `php artisan db:seed` - Run seeders
  - `php artisan migrate:fresh --seed` - Fresh database with seed data

### Laravel Artisan Commands
- `php artisan serve` - Start development server
- `php artisan queue:work` - Process queue jobs
- `php artisan pail` - Real-time log monitoring

## Architecture & Key Components

### Core Models & Relationships
- **Project**: Central entity with relationship to Client, stores Persian dates as strings
- **Client**: Has many projects and client contacts
- **Employee**: Auto-generates employee codes (DVG + national_code), has bank accounts and documents
- **Banks**: System-wide bank management for employee accounts

### Key Features
1. **Persian Date Handling**: Dates stored as strings, not Carbon instances
2. **File Uploads**: Avatars, client logos, company logos stored in public/storage
3. **Employee Management**: Auto-generated codes, bank account tracking, document management
4. **Project Tracking**: Status, priority, progress percentage, financial tracking
5. **Multi-language**: Persian translations in resources/lang/fa/

### Database Design
- Uses SQLite database (database/database.sqlite)
- Extensive enum fields for status, priority, education levels, etc.
- Foreign key relationships with cascade deletes
- Decimal precision for financial amounts (15,2)

### Controllers & Routes
- **Admin routes**: Prefixed with `/admin`, includes dashboard, settings, user management
- **Resource routes**: Standard CRUD for employees, projects, clients
- **Nested routes**: Client contacts under clients
- **Settings**: Company settings, bank management under admin/settings

### Views & UI
- **Blade templates**: Located in resources/views/admin/
- **TailwindCSS**: Used for styling
- **Responsive design**: Admin layout with sidebar navigation
- **Persian language**: All UI text in Persian/Farsi

### Important Technical Notes
1. **Persian Date Storage**: Project dates are stored as strings, not proper date objects
2. **Employee Code Generation**: Automatic generation using national code with "DVG" prefix
3. **Logging**: Extensive logging for debugging, especially in project creation
4. **File Storage**: Uses Laravel's public disk for file uploads
5. **Validation**: Comprehensive validation rules for all forms

### Testing
- PHPUnit configuration in phpunit.xml
- Test suites: Unit and Feature tests
- Uses SQLite in-memory database for testing (commented out in config)