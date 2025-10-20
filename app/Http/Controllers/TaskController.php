<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\Project;
use App\Models\User;
use App\Models\TaskFile;
use App\Models\TaskComment;
use App\Http\Requests\TaskRequest;
use App\Services\PersianDateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::with(['assignedUser', 'creator', 'project', 'category', 'files', 'comments'])
                    ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        // Filter by assigned user
        if ($request->has('assigned_to') && $request->assigned_to !== 'all') {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Filter by project
        if ($request->has('project_id') && $request->project_id !== 'all') {
            $query->where('project_id', $request->project_id);
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id !== 'all') {
            $query->where('category_id', $request->category_id);
        }

        // Filter by overdue tasks
        if ($request->has('overdue') && $request->overdue) {
            $query->overdue();
        }

        // Search by title or description
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $tasks = $query->paginate(20);

        // Get filter options
        $statuses = [
            'pending' => 'در انتظار',
            'in_progress' => 'در حال انجام',
            'completed' => 'تکمیل شده',
            'cancelled' => 'لغو شده',
            'on_hold' => 'در انتظار'
        ];

        $priorities = [
            'low' => 'پایین',
            'normal' => 'عادی',
            'high' => 'بالا',
            'urgent' => 'فوری'
        ];

        $users = User::select('id', 'name')->get();
        $projects = Project::select('id', 'name')->get();
        $categories = TaskCategory::active()->select('id', 'name')->get();

        return view('admin.tasks.index', compact('tasks', 'statuses', 'priorities', 'users', 'projects', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select('id', 'name')->get();
        $projects = Project::select('id', 'name')->get();
        $categories = TaskCategory::active()->select('id', 'name')->get();

        return view('admin.tasks.create', compact('users', 'projects', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,normal,high,urgent',
            'due_date' => 'nullable|string',
            'start_date' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
            'category_id' => 'nullable|exists:task_categories,id',
            'estimated_hours' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        // Convert Persian dates to Carbon instances
        $dueDate = null;
        $startDate = null;

        if ($request->due_date) {
            $dueDate = $this->convertPersianToCarbon($request->due_date);
        }

        if ($request->start_date) {
            $startDate = $this->convertPersianToCarbon($request->start_date);
        }

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'due_date' => $dueDate,
            'start_date' => $startDate,
            'assigned_to' => $request->assigned_to,
            'created_by' => Auth::id(),
            'project_id' => $request->project_id,
            'category_id' => $request->category_id,
            'estimated_hours' => $request->estimated_hours,
            'notes' => $request->notes
        ]);

        return redirect()->route('tasks.show', $task)
                        ->with('success', 'وظیفه با موفقیت ایجاد شد.');
    }

    /**
     * Convert Persian date string to Carbon instance
     */
    private function convertPersianToCarbon($persianDate)
    {
        try {
            // Log the input for debugging
            \Log::info('Converting Persian date: ' . $persianDate);

            // Parse Persian date format: YYYY/MM/DD HH:MM
            if (preg_match('/^(\d{4})\/(\d{1,2})\/(\d{1,2})\s+(\d{1,2}):(\d{1,2})$/', $persianDate, $matches)) {
                $year = (int)$matches[1];
                $month = (int)$matches[2];
                $day = (int)$matches[3];
                $hour = (int)$matches[4];
                $minute = (int)$matches[5];

                \Log::info('Parsed date parts', [
                    'year' => $year,
                    'month' => $month,
                    'day' => $day,
                    'hour' => $hour,
                    'minute' => $minute
                ]);

                // Convert Persian date to Gregorian using the service
                $carbon = PersianDateService::persianToCarbon($year . '/' . $month . '/' . $day, $hour . ':' . $minute);

                \Log::info('Converted to Carbon: ' . ($carbon ? $carbon->toDateTimeString() : 'null'));

                return $carbon;
            } else {
                \Log::warning('Date format does not match regex pattern: ' . $persianDate);
            }
        } catch (\Exception $e) {
            \Log::error('Persian date conversion error: ' . $e->getMessage(), [
                'persian_date' => $persianDate,
                'trace' => $e->getTraceAsString()
            ]);
        }

        return null;
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load(['assignedUser', 'creator', 'project', 'category', 'files.uploader', 'comments.user']);

        return view('admin.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $users = User::select('id', 'name')->get();
        $projects = Project::select('id', 'name')->get();
        $categories = TaskCategory::active()->select('id', 'name')->get();

        return view('admin.tasks.edit', compact('task', 'users', 'projects', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed,cancelled,on_hold',
            'priority' => 'required|in:low,normal,high,urgent',
            'due_date' => 'nullable|string',
            'start_date' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
            'category_id' => 'nullable|exists:task_categories,id',
            'estimated_hours' => 'nullable|numeric|min:0',
            'actual_hours' => 'nullable|numeric|min:0',
            'progress' => 'required|integer|min:0|max:100',
            'notes' => 'nullable|string'
        ]);

        // Convert Persian dates to Carbon instances
        $dueDate = null;
        $startDate = null;

        if ($request->due_date) {
            $dueDate = $this->convertPersianToCarbon($request->due_date);
        }

        if ($request->start_date) {
            $startDate = $this->convertPersianToCarbon($request->start_date);
        }

        $updateData = $request->only([
            'title', 'description', 'status', 'priority',
            'assigned_to', 'project_id', 'category_id', 'estimated_hours',
            'actual_hours', 'progress', 'notes'
        ]);

        $updateData['due_date'] = $dueDate;
        $updateData['start_date'] = $startDate;

        // Set completed date if status is completed
        if ($request->status === 'completed' && $task->status !== 'completed') {
            $updateData['completed_date'] = now();
        } elseif ($request->status !== 'completed') {
            $updateData['completed_date'] = null;
        }

        $task->update($updateData);

        return redirect()->route('tasks.show', $task)
                        ->with('success', 'وظیفه با موفقیت به‌روزرسانی شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
                        ->with('success', 'وظیفه با موفقیت حذف شد.');
    }

    /**
     * Upload file to task
     */
    public function uploadFile(Request $request, Task $task)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'description' => 'nullable|string|max:255'
        ]);

        $file = $request->file('file');
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('task-files', $fileName, 'public');

        TaskFile::create([
            'task_id' => $task->id,
            'file_name' => $fileName,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_by' => Auth::id(),
            'description' => $request->description
        ]);

        return redirect()->back()
                        ->with('success', 'فایل با موفقیت آپلود شد.');
    }

    /**
     * Delete file from task
     */
    public function deleteFile(TaskFile $file)
    {
        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return redirect()->back()
                        ->with('success', 'فایل با موفقیت حذف شد.');
    }

    /**
     * Add comment to task
     */
    public function addComment(Request $request, Task $task)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
            'is_internal' => 'boolean'
        ]);

        TaskComment::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'is_internal' => $request->boolean('is_internal', false)
        ]);

        return redirect()->back()
                        ->with('success', 'نظر با موفقیت اضافه شد.');
    }

    /**
     * Update task status
     */
    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled,on_hold'
        ]);

        $updateData = ['status' => $request->status];

        if ($request->status === 'completed' && $task->status !== 'completed') {
            $updateData['completed_date'] = now();
        } elseif ($request->status !== 'completed') {
            $updateData['completed_date'] = null;
        }

        $task->update($updateData);

        return redirect()->back()
                        ->with('success', 'وضعیت وظیفه با موفقیت به‌روزرسانی شد.');
    }

    /**
     * Get overdue tasks
     */
    public function overdue()
    {
        $tasks = Task::overdue()
                    ->with(['assignedUser', 'creator', 'project', 'category'])
                    ->orderBy('due_date', 'asc')
                    ->paginate(20);

        return view('admin.tasks.overdue', compact('tasks'));
    }

    /**
     * Get my tasks
     */
    public function myTasks(Request $request)
    {
        $query = Task::assignedTo(Auth::id())
                    ->with(['creator', 'project', 'category', 'files', 'comments'])
                    ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $tasks = $query->paginate(20);

        $statuses = [
            'pending' => 'در انتظار',
            'in_progress' => 'در حال انجام',
            'completed' => 'تکمیل شده',
            'cancelled' => 'لغو شده',
            'on_hold' => 'در انتظار'
        ];

        return view('admin.tasks.my-tasks', compact('tasks', 'statuses'));
    }
}
