# Darvag Project Manager - Important Notes

## Route Structure
- **All routes are now under `panel` prefix**
- All admin routes use `panel.` prefix in route names
- Example: `employees.store` → `panel.employees.store`
- Example: `employees.index` → `panel.employees.index`

## Common Route Patterns
- Dashboard: `panel.dashboard`
- Employees: `panel.employees.*`
- Projects: `panel.projects.*`
- Clients: `panel.clients.*`
- Users: `panel.users.*`
- Settings: `panel.settings.*`

## Authentication
- Login route: `/login` (no prefix)
- Logout route: `/logout` (no prefix)
- All other routes require authentication and are under `/panel/`

## Important Files to Check for Route Updates
- All Blade templates in `resources/views/admin/`
- Any JavaScript files that use `route()` helper
- Livewire components that reference routes

## Recent Fixes
- Fixed ActivityLoggerService type hint issue (User model import)
- Fixed employee create form route names
- Fixed all route references in admin views to use panel prefix
- Updated file manager, tasks, and tags views with correct route names
- Fixed EmployeeController route references to use panel prefix
- Confirmed all routes are working correctly (tested with HTTP requests)
- **IMPORTANT**: Replaced `findOrFail($id)` with route model binding (`Employee $employee`) in EmployeeController
- This fixes 404 errors when employee doesn't exist - now shows proper error handling

## New Features Added
- **Document Management System**: Complete system for managing forms and documents
  - Document upload with version control
  - Category management with hierarchical structure
  - Advanced search and filtering
  - File type support: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, ZIP, RAR
  - Tag system for better organization
  - Download tracking and statistics

- **Icon Picker Component**: Reusable icon selection component
  - **Location**: `resources/views/admin/partials/icon-picker.blade.php`
  - **Usage**: `@include('admin.partials.icon-picker', ['inputId' => 'icon', 'inputName' => 'icon', 'label' => 'آیکون', 'value' => 'mdi mdi-folder'])`
  - **Features**:
    - 200+ Material Design Icons
    - Visual icon selection with preview
    - Search functionality
    - Responsive modal design
    - Reusable across the application
  - **Parameters**:
    - `inputId`: ID of the input field (default: 'icon')
    - `inputName`: Name of the input field (default: 'icon')
    - `label`: Label text (default: 'آیکون')
    - `value`: Default value (default: 'mdi mdi-folder')

- **Dynamic Modal Component**: Universal modal system for all applications
  - **Location**: `resources/views/admin/partials/dynamic-modal.blade.php`
  - **Usage**: `ModalManager.message({...})`, `ModalManager.confirm({...})`, `ModalManager.form({...})`
  - **Features**:
    - 4 Modal Types: message, confirm, form, loading
    - Vue.js powered with reactive forms
    - Bootstrap 5 integration
    - Persian RTL support
    - Customizable styling and behavior
    - Form validation with error display
    - Promise-based API
  - **Modal Types**:
    - `message`: Simple message display
    - `confirm`: Confirmation dialog with promise
    - `form`: Dynamic form with validation
    - `loading`: Loading indicator
  - **Form Field Types**:
    - text, email, password, textarea
    - select, checkbox, radio
  - **Examples**: `resources/views/admin/partials/modal-examples.blade.php`

## Notes for Future Development
- Always use `panel.` prefix for new admin routes
- Check existing views when adding new features
- Test route generation after making changes

## Common Issues & Solutions
- **404 errors on panel routes**: Usually means user is not authenticated
- **Route not found errors**: Check if route names use `panel.` prefix
- **Authentication redirects**: All panel routes require login
- **Browser cache issues**: Clear browser cache if routes seem broken
- **Employee 404 errors**: Use route model binding (`Employee $employee`) instead of `findOrFail($id)`
- **Model binding**: Laravel automatically handles 404 for missing models when using route model binding
# به هیچ عنوان جازه حذف یا رول بک دیتابببیس رو نداری دیتاببس حاوی اطلاعات هستش
