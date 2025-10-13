# مثال کامل سیستم مدیریت کارها

## فرآیند کامل مدیریت کارها

### 1. ایجاد کار توسط mosayeb

```php
// mosayeb یک کار جدید ایجاد می‌کند
$task = Task::create([
    'title' => 'توسعه صفحه ورود کاربران',
    'description' => 'طراحی و پیاده‌سازی صفحه ورود با قابلیت احراز هویت دو مرحله‌ای',
    'priority' => 'high',
    'type' => 'task',
    'due_date' => '2025-10-15',
    'created_by' => auth()->id(), // mosayeb
    'status' => 'pending'
]);
```

### 2. واگذاری کار به ali و hassan

```php
// mosayeb کار را به ali و hassan واگذار می‌کند
$task->assignTo($aliUserId, 'primary', 'این کار اولویت بالایی دارد و باید تا 15 مهر تکمیل شود', '2025-10-15');
$task->assignTo($hassanUserId, 'collaborator', 'می‌توانید در این کار مشارکت کنید', '2025-10-15');
```

### 3. ali درخواست شروع کار می‌زند

```php
// ali درخواست شروع کار می‌زند
$request = $task->createRequest(
    'start_work',
    'آماده شروع کار',
    'من آماده شروع کار هستم. آیا می‌توانم شروع کنم؟',
    'high',
    [] // فایل‌های ضمیمه
);
```

### 4. mosayeb درخواست ali را تأیید می‌کند

```php
// mosayeb درخواست شروع کار را تأیید می‌کند
$request->approve(auth()->id(), 'بله، می‌توانید شروع کنید');
// کار به صورت خودکار به وضعیت in_progress تغییر می‌کند
```

### 5. hassan به عنوان مشارکت کننده اضافه می‌شود

```php
// mosayeb hassan را به عنوان مشارکت کننده اضافه می‌کند
$collaboration = $task->addCollaborator(
    $hassanUserId,
    'contributor',
    ['view', 'comment', 'upload', 'edit'],
    'hassan می‌تواند در طراحی UI کمک کند'
);
```

### 6. ali و hassan در کار مشارکت می‌کنند

```php
// ali گزارش پیشرفت می‌دهد
$progressReport = $task->progressReports()->create([
    'reported_by' => $aliUserId,
    'report_date' => now()->toDateString(),
    'work_done' => 'صفحه ورود طراحی شد و کدهای HTML/CSS نوشته شد',
    'challenges' => 'مشکلی در responsive design وجود دارد',
    'next_plans' => 'فردا JavaScript و validation اضافه می‌کنم',
    'hours_worked' => 6,
    'progress_percentage' => 40
]);

// hassan نظر می‌دهد
$comment = $task->comments()->create([
    'user_id' => $hassanUserId,
    'comment' => 'طراحی خوبی است. پیشنهاد می‌کنم رنگ‌ها را کمی تغییر دهید',
    'type' => 'feedback',
    'is_important' => false
]);

// hassan فایل ضمیمه آپلود می‌کند
$attachment = $task->attachments()->create([
    'uploaded_by' => $hassanUserId,
    'original_name' => 'design-mockup.png',
    'file_name' => 'design-mockup.png',
    'file_path' => 'task-attachments/design-mockup.png',
    'file_type' => 'image/png',
    'file_size' => 1024000,
    'file_extension' => 'png',
    'attachment_type' => 'task',
    'is_public' => true
]);
```

### 7. ali درخواست تکمیل کار می‌زند

```php
// ali درخواست تکمیل کار می‌زند
$completeRequest = $task->createRequest(
    'complete_work',
    'کار تکمیل شد',
    'صفحه ورود کاملاً پیاده‌سازی شد و تست شده است. تمام قابلیت‌ها کار می‌کنند.',
    'high',
    ['attachment_id_1', 'attachment_id_2'] // فایل‌های ضمیمه
);
```

### 8. mosayeb کار را بررسی و تأیید یا رد می‌کند

```php
// mosayeb کار را بررسی می‌کند
if ($task->isCompletedProperly()) {
    // تأیید نهایی
    $completeRequest->approve(auth()->id(), 'کار عالی انجام شده است. تأیید می‌کنم.');
    $task->update(['status' => 'completed']);
} else {
    // رد کردن
    $completeRequest->reject(auth()->id(), 'چند مشکل وجود دارد که باید برطرف شود.');
}
```

## API Endpoints

### واگذاری کار
```http
POST /panel/tasks/{task}/assign
Content-Type: application/json

{
    "assigned_users": [1, 2],
    "assignment_type": "primary",
    "instructions": "دستورالعمل‌های کار",
    "due_date": "2025-10-15",
    "priority": "high"
}
```

### درخواست شروع کار
```http
POST /panel/tasks/{task}/request-start
Content-Type: multipart/form-data

{
    "title": "آماده شروع کار",
    "description": "توضیحات درخواست",
    "priority": "high",
    "attachments[]": [file1, file2]
}
```

### درخواست تکمیل کار
```http
POST /panel/tasks/{task}/request-complete
Content-Type: multipart/form-data

{
    "title": "کار تکمیل شد",
    "description": "توضیحات تکمیل",
    "completion_notes": "یادداشت‌های تکمیل",
    "attachments[]": [file1, file2]
}
```

### افزودن مشارکت کننده
```http
POST /panel/tasks/{task}/add-collaborator
Content-Type: application/json

{
    "user_id": 3,
    "collaboration_type": "contributor",
    "permissions": ["view", "comment", "upload"],
    "notes": "یادداشت‌ها"
}
```

### دریافت وضعیت فرآیند
```http
GET /panel/tasks/{task}/workflow-status
```

## ویژگی‌های کلیدی سیستم

1. **واگذاری چندگانه**: امکان واگذاری کار به چندین کاربر
2. **درخواست‌های ساختاریافته**: سیستم درخواست برای شروع، تکمیل و تغییرات
3. **مشارکت انعطاف‌پذیر**: امکان مشارکت کاربران مختلف با مجوزهای مختلف
4. **ردیابی کامل**: ردیابی تمام فعالیت‌ها و تغییرات
5. **تأیید/رد نهایی**: کنترل کامل واگذار کننده بر فرآیند
6. **فایل‌های ضمیمه**: امکان آپلود فایل در هر مرحله
7. **گزارش‌دهی**: سیستم گزارش‌دهی پیشرفت کار
8. **چت و نظر**: امکان ارتباط و تبادل نظر

## استفاده در ویو

```php
// در کنترلر
public function show(Task $task)
{
    $task->load([
        'assignments.assignedTo',
        'collaborators.user',
        'requests.requestedBy',
        'progressReports.reportedBy',
        'comments.user',
        'attachments.uploadedBy'
    ]);
    
    return view('admin.tasks.show', compact('task'));
}
```

```blade
{{-- در ویو --}}
@foreach($task->assignments as $assignment)
    <div class="assignment-item {{ $assignment->status }}">
        <h6>{{ $assignment->assignedTo->name }}</h6>
        <span class="badge badge-{{ $assignment->status_color }}">
            {{ $assignment->status_text }}
        </span>
    </div>
@endforeach
```

این سیستم یک فرآیند کامل و حرفه‌ای برای مدیریت کارها فراهم می‌کند که تمام نیازهای شما را پوشش می‌دهد.
