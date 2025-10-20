<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\Project;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class TaskManagementComponent extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $status = 'all';
    public $priority = 'all';
    public $assignedTo = 'all';
    public $projectId = 'all';
    public $categoryId = 'all';
    public $showOverdue = false;

    // Task creation/editing
    public $showCreateModal = false;
    public $showEditModal = false;
    public $editingTask = null;

    // Task form fields
    public $title = '';
    public $description = '';
    public $priority = 'normal';
    public $dueDate = '';
    public $startDate = '';
    public $assignedTo = '';
    public $projectId = '';
    public $categoryId = '';
    public $estimatedHours = '';
    public $notes = '';

    // File upload
    public $uploadedFiles = [];
    public $fileDescription = '';

    // Comment
    public $comment = '';
    public $isInternalComment = false;

    // Filter options
    public $users = [];
    public $projects = [];
    public $categories = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'priority' => 'required|in:low,normal,high,urgent',
        'dueDate' => 'nullable|date|after:now',
        'startDate' => 'nullable|date',
        'assignedTo' => 'nullable|exists:users,id',
        'projectId' => 'nullable|exists:projects,id',
        'categoryId' => 'nullable|exists:task_categories,id',
        'estimatedHours' => 'nullable|numeric|min:0',
        'notes' => 'nullable|string',
        'comment' => 'nullable|string|max:1000'
    ];

    public function mount()
    {
        $this->loadFilterOptions();
    }

    public function loadFilterOptions()
    {
        $this->users = User::select('id', 'name')->get();
        $this->projects = Project::select('id', 'name')->get();
        $this->categories = TaskCategory::active()->select('id', 'name')->get();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedPriority()
    {
        $this->resetPage();
    }

    public function updatedAssignedTo()
    {
        $this->resetPage();
    }

    public function updatedProjectId()
    {
        $this->resetPage();
    }

    public function updatedCategoryId()
    {
        $this->resetPage();
    }

    public function updatedShowOverdue()
    {
        $this->resetPage();
    }

    public function showCreateTask()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function showEditTask($taskId)
    {
        $task = Task::findOrFail($taskId);
        $this->editingTask = $task;

        $this->title = $task->title;
        $this->description = $task->description;
        $this->priority = $task->priority;
        $this->dueDate = $task->due_date ? $task->due_date->format('Y-m-d\TH:i') : '';
        $this->startDate = $task->start_date ? $task->start_date->format('Y-m-d\TH:i') : '';
        $this->assignedTo = $task->assigned_to;
        $this->projectId = $task->project_id;
        $this->categoryId = $task->category_id;
        $this->estimatedHours = $task->estimated_hours;
        $this->notes = $task->notes;

        $this->showEditModal = true;
    }

    public function saveTask()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,normal,high,urgent',
            'dueDate' => 'nullable|date',
            'startDate' => 'nullable|date',
            'assignedTo' => 'nullable|exists:users,id',
            'projectId' => 'nullable|exists:projects,id',
            'categoryId' => 'nullable|exists:task_categories,id',
            'estimatedHours' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'due_date' => $this->dueDate ?: null,
            'start_date' => $this->startDate ?: null,
            'assigned_to' => $this->assignedTo ?: null,
            'project_id' => $this->projectId ?: null,
            'category_id' => $this->categoryId ?: null,
            'estimated_hours' => $this->estimatedHours ?: null,
            'notes' => $this->notes
        ];

        if ($this->editingTask) {
            $this->editingTask->update($data);
            session()->flash('success', 'وظیفه با موفقیت به‌روزرسانی شد.');
        } else {
            $data['created_by'] = Auth::id();
            Task::create($data);
            session()->flash('success', 'وظیفه با موفقیت ایجاد شد.');
        }

        $this->closeModals();
        $this->resetForm();
    }

    public function updateTaskStatus($taskId, $status)
    {
        $task = Task::findOrFail($taskId);

        $updateData = ['status' => $status];

        if ($status === 'completed' && $task->status !== 'completed') {
            $updateData['completed_date'] = now();
        } elseif ($status !== 'completed') {
            $updateData['completed_date'] = null;
        }

        $task->update($updateData);

        session()->flash('success', 'وضعیت وظیفه به‌روزرسانی شد.');
    }

    public function deleteTask($taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->delete();

        session()->flash('success', 'وظیفه حذف شد.');
    }

    public function addComment($taskId)
    {
        $this->validate(['comment' => 'required|string|max:1000']);

        $task = Task::findOrFail($taskId);
        $task->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $this->comment,
            'is_internal' => $this->isInternalComment
        ]);

        $this->comment = '';
        $this->isInternalComment = false;

        session()->flash('success', 'نظر اضافه شد.');
    }

    public function uploadFiles($taskId)
    {
        $this->validate([
            'uploadedFiles.*' => 'file|max:10240', // 10MB max
            'fileDescription' => 'nullable|string|max:255'
        ]);

        $task = Task::findOrFail($taskId);

        foreach ($this->uploadedFiles as $file) {
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('task-files', $fileName, 'public');

            $task->files()->create([
                'file_name' => $fileName,
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'uploaded_by' => Auth::id(),
                'description' => $this->fileDescription
            ]);
        }

        $this->uploadedFiles = [];
        $this->fileDescription = '';

        session()->flash('success', 'فایل‌ها آپلود شدند.');
    }

    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->editingTask = null;
    }

    public function resetForm()
    {
        $this->title = '';
        $this->description = '';
        $this->priority = 'normal';
        $this->dueDate = '';
        $this->startDate = '';
        $this->assignedTo = '';
        $this->projectId = '';
        $this->categoryId = '';
        $this->estimatedHours = '';
        $this->notes = '';
        $this->comment = '';
        $this->isInternalComment = false;
        $this->uploadedFiles = [];
        $this->fileDescription = '';
    }

    public function render()
    {
        $query = Task::with(['assignedUser', 'creator', 'project', 'category', 'files', 'comments'])
                    ->orderBy('created_at', 'desc');

        // Apply filters
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status !== 'all') {
            $query->where('status', $this->status);
        }

        if ($this->priority !== 'all') {
            $query->where('priority', $this->priority);
        }

        if ($this->assignedTo !== 'all') {
            $query->where('assigned_to', $this->assignedTo);
        }

        if ($this->projectId !== 'all') {
            $query->where('project_id', $this->projectId);
        }

        if ($this->categoryId !== 'all') {
            $query->where('category_id', $this->categoryId);
        }

        if ($this->showOverdue) {
            $query->overdue();
        }

        $tasks = $query->paginate(20);

        return view('livewire.task-management-component', compact('tasks'));
    }
}
