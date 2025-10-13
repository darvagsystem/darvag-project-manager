<?php

namespace App\Http\Controllers;

use App\Models\ChecklistCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ChecklistCategoryController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ChecklistCategory::forUser(Auth::id())
            ->withCount('checklists')
            ->orderBy('is_default', 'desc')
            ->orderBy('name')
            ->get();

        return view('admin.checklist-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.checklist-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|max:7'
        ]);

        ChecklistCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
            'user_id' => Auth::id(),
            'is_default' => false
        ]);

        return redirect()->route('checklist-categories.index')
            ->with('success', 'دسته‌بندی با موفقیت ایجاد شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ChecklistCategory $checklistCategory)
    {
        $checklistCategory->load(['checklists' => function($query) {
            $query->where('user_id', Auth::id())->orderBy('created_at', 'desc');
        }]);

        return view('admin.checklist-categories.show', compact('checklistCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChecklistCategory $checklistCategory)
    {
        // Only allow editing user's own categories
        if ($checklistCategory->user_id !== Auth::id()) {
            abort(403);
        }

        return view('admin.checklist-categories.edit', compact('checklistCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChecklistCategory $checklistCategory)
    {
        // Only allow updating user's own categories
        if ($checklistCategory->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|max:7'
        ]);

        $checklistCategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color
        ]);

        return redirect()->route('checklist-categories.index')
            ->with('success', 'دسته‌بندی با موفقیت به‌روزرسانی شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChecklistCategory $checklistCategory)
    {
        // Only allow deleting user's own categories
        if ($checklistCategory->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if category has checklists
        if ($checklistCategory->checklists()->count() > 0) {
            return redirect()->route('checklist-categories.index')
                ->with('error', 'نمی‌توان دسته‌بندی‌ای که دارای چک لیست است را حذف کرد.');
        }

        $checklistCategory->delete();

        return redirect()->route('checklist-categories.index')
            ->with('success', 'دسته‌بندی با موفقیت حذف شد.');
    }
}
