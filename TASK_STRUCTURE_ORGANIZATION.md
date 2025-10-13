# سازماندهی ساختار مدیریت وظایف

## 📁 ساختار جدید پوشه‌ها

### Models
```
app/Models/Tasks/
├── Task.php                    # مدل اصلی وظایف
├── TaskAssignment.php          # واگذاری وظایف
├── TaskRequest.php             # درخواست‌های مربوط به وظایف
├── TaskCollaboration.php       # مشارکت در وظایف
├── TaskProgressReport.php      # گزارش‌های پیشرفت
├── TaskComment.php             # نظرات وظایف
├── TaskAttachment.php          # فایل‌های ضمیمه
├── TaskChatMessage.php         # پیام‌های چت
├── TaskDependency.php          # وابستگی‌های وظایف
└── README.md                   # مستندات مدل‌ها
```

### Controllers
```
app/Http/Controllers/Tasks/
├── TaskController.php          # کنترلر اصلی وظایف
├── TaskWorkflowController.php  # کنترلر فرآیند کارها
└── README.md                   # مستندات کنترلرها
```

### Views
```
resources/views/admin/tasks/
├── workflow/
│   └── index.blade.php         # صفحه مدیریت فرآیند
├── index.blade.php             # لیست وظایف
├── create.blade.php            # ایجاد وظیفه
├── show.blade.php              # نمایش وظیفه
├── edit.blade.php              # ویرایش وظیفه
└── dashboard.blade.php         # داشبورد وظایف
```

### Migrations
```
database/migrations/tasks/
├── create_tasks_table.php
├── create_task_assignments_table.php
├── create_task_requests_table.php
├── create_task_collaborations_table.php
├── create_task_progress_reports_table.php
├── create_task_comments_table.php
├── create_task_attachments_table.php
├── create_task_chat_messages_table.php
├── create_task_dependencies_table.php
└── add_workflow_fields_to_tasks_table.php
```

## 🔧 تغییرات انجام شده

### 1. Namespace ها
- **مدل‌ها**: `App\Models\Tasks\`
- **کنترلرها**: `App\Http\Controllers\Tasks\`

### 2. Import ها
```php
// قبل
use App\Models\Task;
use App\Http\Controllers\TaskController;

// بعد
use App\Models\Tasks\Task;
use App\Http\Controllers\Tasks\TaskController;
```

### 3. مسیرهای ویو
```php
// قبل
return view('admin.tasks.workflow', compact('task'));

// بعد
return view('admin.tasks.workflow.index', compact('task'));
```

### 4. Service Provider
- **TaskServiceProvider** برای مدیریت داده‌های مشترک
- ثبت در `bootstrap/providers.php`

## 📋 مزایای ساختار جدید

### ✅ سازماندهی بهتر
- جداسازی کامل مدل‌ها و کنترلرهای وظایف
- ساختار پوشه‌ای منطقی و قابل فهم
- مستندات کامل برای هر بخش

### ✅ مدیریت آسان‌تر
- پیدا کردن فایل‌ها راحت‌تر
- تغییرات محدود به پوشه مربوطه
- کاهش تداخل با سایر بخش‌ها

### ✅ قابلیت نگهداری
- کد تمیز و منظم
- مستندات کامل
- ساختار قابل توسعه

### ✅ عملکرد بهتر
- Autoloading بهینه
- بارگذاری سریع‌تر
- حافظه کمتر

## 🚀 نحوه استفاده

### Import مدل‌ها
```php
use App\Models\Tasks\Task;
use App\Models\Tasks\TaskAssignment;
use App\Models\Tasks\TaskRequest;
use App\Models\Tasks\TaskCollaboration;
```

### Import کنترلرها
```php
use App\Http\Controllers\Tasks\TaskController;
use App\Http\Controllers\Tasks\TaskWorkflowController;
```

### استفاده در روت‌ها
```php
Route::resource('tasks', TaskController::class);
Route::post('/tasks/{task}/assign', [TaskWorkflowController::class, 'assignTask']);
```

## 📝 فایل‌های مستندات

- `app/Models/Tasks/README.md` - مستندات مدل‌ها
- `app/Http/Controllers/Tasks/README.md` - مستندات کنترلرها
- `TASK_WORKFLOW_EXAMPLE.md` - مثال‌های استفاده
- `TASK_STRUCTURE_ORGANIZATION.md` - این فایل

## 🔄 Migration ها

تمام migration های مربوط به وظایف در پوشه `database/migrations/tasks/` قرار گرفته‌اند و آماده اجرا هستند.

## ⚡ اجرای سریع

```bash
# به‌روزرسانی autoload
composer dump-autoload

# اجرای migration ها
php artisan migrate

# پاک کردن cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

این ساختار جدید مدیریت وظایف را بسیار آسان‌تر و حرفه‌ای‌تر کرده است! 🎉
