<?php

namespace App\Http\Controllers;

use App\Models\TaskCategory;
use Illuminate\Http\Request;

class TaskCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = TaskCategory::withCount(['tasks', 'tasks as active_tasks_count' => function($query) {
            $query->where('status', '!=', 'completed');
        }])
        ->orderBy('sort_order')
        ->orderBy('name')
        ->paginate(20);

        return view('admin.task-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.task-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:task_categories,name',
            'description' => 'nullable|string',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        TaskCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
            'icon' => $request->icon,
            'sort_order' => $request->sort_order ?? 0
        ]);

        return redirect()->route('task-categories.index')
                        ->with('success', 'دسته‌بندی با موفقیت ایجاد شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskCategory $taskCategory)
    {
        $tasks = $taskCategory->tasks()
                             ->with(['assignedUser', 'creator', 'project'])
                             ->orderBy('created_at', 'desc')
                             ->paginate(20);

        return view('admin.task-categories.show', compact('taskCategory', 'tasks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskCategory $taskCategory)
    {
        return view('admin.task-categories.edit', compact('taskCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskCategory $taskCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:task_categories,name,' . $taskCategory->id,
            'description' => 'nullable|string',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $taskCategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
            'icon' => $request->icon,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('task-categories.index')
                        ->with('success', 'دسته‌بندی با موفقیت به‌روزرسانی شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskCategory $taskCategory)
    {
        // Check if category has tasks
        if ($taskCategory->tasks()->count() > 0) {
            return redirect()->back()
                            ->with('error', 'نمی‌توان دسته‌بندی‌ای که دارای وظیفه است را حذف کرد.');
        }

        $taskCategory->delete();

        return redirect()->route('task-categories.index')
                        ->with('success', 'دسته‌بندی با موفقیت حذف شد.');
    }

    /**
     * Toggle category status
     */
    public function toggleStatus(TaskCategory $taskCategory)
    {
        $taskCategory->update([
            'is_active' => !$taskCategory->is_active
        ]);

        $status = $taskCategory->is_active ? 'فعال' : 'غیرفعال';

        return redirect()->back()
                        ->with('success', "دسته‌بندی {$status} شد.");
    }
}
