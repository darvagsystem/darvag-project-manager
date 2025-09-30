<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * نمایش لیست کارها
     */
    public function index(Request $request)
    {
        $query = Task::with(['project', 'assignedTo', 'createdBy']);

        // فیلتر بر اساس وضعیت
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // فیلتر بر اساس اولویت
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // فیلتر بر اساس نوع
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // فیلتر بر اساس پروژه
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        // فیلتر بر اساس کاربر واگذار شده
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // فیلتر بر اساس تاریخ موعد
        if ($request->filled('due_date_from')) {
            $query->where('due_date', '>=', $request->due_date_from);
        }

        if ($request->filled('due_date_to')) {
            $query->where('due_date', '<=', $request->due_date_to);
        }

        // جستجو در عنوان و توضیحات
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $tasks = $query->orderBy('due_date', 'asc')
                      ->orderBy('priority', 'desc')
                      ->paginate(20);

        $projects = Project::all();
        $employees = Employee::all();

        return view('admin.tasks.index', compact('tasks', 'projects', 'employees'));
    }

    /**
     * نمایش فرم ایجاد کار
     */
    public function create()
    {
        $projects = Project::all();
        $employees = Employee::all();
        return view('admin.tasks.create', compact('projects', 'employees'));
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
            'type' => 'required|in:task,reminder,meeting,deadline',
            'due_date' => 'nullable|date',
            'due_time' => 'nullable|date_format:H:i',
            'estimated_hours' => 'nullable|integer|min:0',
            'project_id' => 'nullable|exists:projects,id',
            'assigned_to' => 'nullable|exists:employees,id',
            'tags' => 'nullable|array',
            'notes' => 'nullable|string',
            'is_reminder' => 'boolean',
            'reminder_at' => 'nullable|date',
            'is_recurring' => 'boolean'
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'type' => $request->type,
            'due_date' => $request->due_date,
            'due_time' => $request->due_time,
            'estimated_hours' => $request->estimated_hours,
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'created_by' => auth()->id(),
            'tags' => $request->tags,
            'notes' => $request->notes,
            'is_reminder' => $request->boolean('is_reminder'),
            'reminder_at' => $request->reminder_at,
            'is_recurring' => $request->boolean('is_recurring'),
            'recurring_settings' => $request->recurring_settings
        ]);

        return redirect()->route('admin.tasks.index')
                        ->with('success', 'کار با موفقیت ایجاد شد.');
    }

    /**
     * نمایش جزئیات کار
     */
    public function show(Task $task)
    {
        $task->load(['project', 'assignedTo', 'createdBy']);
        return view('admin.tasks.show', compact('task'));
    }

    /**
     * نمایش فرم ویرایش کار
     */
    public function edit(Task $task)
    {
        $projects = Project::all();
        $employees = Employee::all();
        return view('admin.tasks.edit', compact('task', 'projects', 'employees'));
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
            'type' => 'required|in:task,reminder,meeting,deadline',
            'due_date' => 'nullable|date',
            'due_time' => 'nullable|date_format:H:i',
            'estimated_hours' => 'nullable|integer|min:0',
            'actual_hours' => 'nullable|integer|min:0',
            'project_id' => 'nullable|exists:projects,id',
            'assigned_to' => 'nullable|exists:employees,id',
            'tags' => 'nullable|array',
            'notes' => 'nullable|string',
            'is_reminder' => 'boolean',
            'reminder_at' => 'nullable|date',
            'is_recurring' => 'boolean'
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => $request->status,
            'type' => $request->type,
            'due_date' => $request->due_date,
            'due_time' => $request->due_time,
            'estimated_hours' => $request->estimated_hours,
            'actual_hours' => $request->actual_hours,
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'tags' => $request->tags,
            'notes' => $request->notes,
            'is_reminder' => $request->boolean('is_reminder'),
            'reminder_at' => $request->reminder_at,
            'is_recurring' => $request->boolean('is_recurring'),
            'recurring_settings' => $request->recurring_settings
        ]);

        return redirect()->route('admin.tasks.index')
                        ->with('success', 'کار با موفقیت به‌روزرسانی شد.');
    }

    /**
     * حذف کار
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.tasks.index')
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
            'message' => 'وضعیت کار به‌روزرسانی شد.',
            'status_text' => $task->status_text,
            'status_color' => $task->status_color
        ]);
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
            'overdue' => Task::overdue()->count(),
            'due_today' => Task::dueToday()->count(),
            'due_this_week' => Task::dueThisWeek()->count(),
            'high_priority' => Task::highPriority()->count()
        ];

        $recentTasks = Task::with(['project', 'assignedTo'])
                          ->orderBy('created_at', 'desc')
                          ->limit(10)
                          ->get();

        $overdueTasks = Task::overdue()
                           ->with(['project', 'assignedTo'])
                           ->orderBy('due_date', 'asc')
                           ->limit(10)
                           ->get();

        $dueTodayTasks = Task::dueToday()
                            ->with(['project', 'assignedTo'])
                            ->orderBy('due_time', 'asc')
                            ->get();

        return view('admin.tasks.dashboard', compact('stats', 'recentTasks', 'overdueTasks', 'dueTodayTasks'));
    }

    /**
     * کارهای من (کاربر فعلی)
     */
    public function myTasks(Request $request)
    {
        $query = Task::forUser(auth()->id())
                    ->with(['project', 'createdBy']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tasks = $query->orderBy('due_date', 'asc')
                      ->orderBy('priority', 'desc')
                      ->paginate(20);

        return view('admin.tasks.my-tasks', compact('tasks'));
    }
}
