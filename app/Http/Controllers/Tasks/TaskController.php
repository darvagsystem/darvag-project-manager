<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Tasks\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * نمایش لیست کارها
     */
    public function index(Request $request)
    {
        $query = Task::with(['project', 'assignedTo', 'createdBy']);

        // فیلترها
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $tasks = $query->orderBy('created_at', 'desc')->paginate(20);
        $projects = Project::all();
        $users = User::all();

        return view('admin.tasks.index', compact('tasks', 'projects', 'users'));
    }

    /**
     * نمایش فرم ایجاد کار
     */
    public function create()
    {
        $projects = Project::all();
        $users = User::all();
        return view('admin.tasks.create', compact('projects', 'users'));
    }

    /**
     * ذخیره کار جدید
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'due_date' => 'nullable|date|after:today',
            'project_id' => 'nullable|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'notes' => 'nullable|string'
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'created_by' => auth()->id(),
            'notes' => $request->notes,
            'status' => 'pending',
            'progress' => 0
        ]);

        return redirect()->route('panel.tasks.index')
                        ->with('success', 'کار با موفقیت ایجاد شد.');
    }

    /**
     * نمایش جزئیات کار
     */
    public function show(Task $task)
    {
        $task->load(['project', 'assignedTo', 'createdBy', 'comments.user', 'attachments.user']);
        return view('admin.tasks.show', compact('task'));
    }

    /**
     * نمایش فرم ویرایش کار
     */
    public function edit(Task $task)
    {
        $projects = Project::all();
        $users = User::all();
        return view('admin.tasks.edit', compact('task', 'projects', 'users'));
    }

    /**
     * به‌روزرسانی کار
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'due_date' => 'nullable|date',
            'project_id' => 'nullable|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'progress' => 'required|integer|min:0|max:100',
            'notes' => 'nullable|string'
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'progress' => $request->progress,
            'notes' => $request->notes
        ]);

        return redirect()->route('panel.tasks.index')
                        ->with('success', 'کار با موفقیت به‌روزرسانی شد.');
    }

    /**
     * حذف کار
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('panel.tasks.index')
                        ->with('success', 'کار با موفقیت حذف شد.');
    }

    /**
     * تغییر وضعیت کار
     */
    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled'
        ]);

        $task->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'وضعیت کار به‌روزرسانی شد.'
        ]);
    }

    /**
     * شروع کار
     */
    public function start(Task $task)
    {
        if (!$task->canBeStartedBy(auth()->id())) {
            return response()->json([
                'success' => false,
                'message' => 'شما مجاز به شروع این کار نیستید.'
            ], 403);
        }

        if ($task->start()) {
            return response()->json([
                'success' => true,
                'message' => 'کار با موفقیت شروع شد.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'خطا در شروع کار.'
        ], 400);
    }

    /**
     * تکمیل کار
     */
    public function complete(Task $task)
    {
        if (!$task->canBeCompletedBy(auth()->id())) {
            return response()->json([
                'success' => false,
                'message' => 'شما مجاز به تکمیل این کار نیستید.'
            ], 403);
        }

        if ($task->complete()) {
            return response()->json([
                'success' => true,
                'message' => 'کار با موفقیت تکمیل شد.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'خطا در تکمیل کار.'
        ], 400);
    }

    /**
     * افزودن نظر
     */
    public function addComment(Request $request, Task $task)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
            'is_internal' => 'boolean'
        ]);

        $task->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'is_internal' => $request->boolean('is_internal', false)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'نظر با موفقیت اضافه شد.'
        ]);
    }

    /**
     * آپلود فایل
     */
    public function uploadFile(Request $request, Task $task)
    {
        $request->validate([
            'file' => 'required|file|max:10240' // حداکثر 10MB
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('task-attachments', $fileName, 'public');

        $task->attachments()->create([
            'user_id' => auth()->id(),
            'original_name' => $originalName,
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'file_type' => $file->getMimeType()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'فایل با موفقیت آپلود شد.'
        ]);
    }

    /**
     * دانلود فایل ضمیمه
     */
    public function downloadAttachment($attachmentId)
    {
        $attachment = \App\Models\Tasks\TaskAttachment::findOrFail($attachmentId);

        // بررسی دسترسی
        if (!$task->canBeViewedBy(auth()->id())) {
            abort(403, 'دسترسی غیرمجاز');
        }

        return response()->download(storage_path('app/public/' . $attachment->file_path), $attachment->original_name);
    }

    /**
     * کارهای من
     */
    public function myTasks(Request $request)
    {
        $query = Task::forUser(auth()->id())
                    ->with(['project', 'createdBy']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tasks = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.tasks.my-tasks', compact('tasks'));
    }

    /**
     * داشبورد کارها
     */
    public function dashboard()
    {
        $stats = [
            'total' => Task::count(),
            'pending' => Task::pending()->count(),
            'in_progress' => Task::inProgress()->count(),
            'completed' => Task::completed()->count(),
            'my_tasks' => Task::forUser(auth()->id())->count(),
            'high_priority' => Task::highPriority()->count()
        ];

        $recentTasks = Task::with(['project', 'assignedTo'])
                          ->orderBy('created_at', 'desc')
                          ->limit(10)
                          ->get();

        $myTasks = Task::forUser(auth()->id())
                      ->with(['project'])
                      ->orderBy('created_at', 'desc')
                      ->limit(10)
                      ->get();

        return view('admin.tasks.dashboard', compact('stats', 'recentTasks', 'myTasks'));
    }
}
