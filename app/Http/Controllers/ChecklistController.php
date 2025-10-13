<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\ChecklistCategory;
use App\Models\ChecklistItem;
use App\Services\PersianDateService;
use App\Rules\PersianDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ChecklistController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checklists = Checklist::with(['category', 'items'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $categories = ChecklistCategory::forUser(Auth::id())->get();

        return view('admin.checklists.index', compact('checklists', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ChecklistCategory::forUser(Auth::id())->get();
        return view('admin.checklists.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:checklist_categories,id',
            'color' => 'nullable|string|max:7',
            'is_public' => 'boolean',
            'due_date' => ['nullable', new PersianDate()],
            'priority' => 'in:low,normal,high,urgent',
            'status' => 'in:active,completed,paused,archived'
        ]);

        $checklist = Checklist::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'color' => $request->color ?? '#3B82F6',
            'is_public' => $request->boolean('is_public'),
            'due_date' => PersianDateService::parseFromInput($request->due_date, true),
            'priority' => $request->priority ?? 'normal',
            'status' => $request->status ?? 'active'
        ]);

        return redirect()->route('checklists.show', $checklist)
            ->with('success', 'چک لیست با موفقیت ایجاد شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Checklist $checklist)
    {
        $this->authorize('view', $checklist);

        $checklist->load(['category', 'items' => function($query) {
            $query->orderBy('order')->orderBy('created_at');
        }]);

        return view('admin.checklists.show', compact('checklist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checklist $checklist)
    {
        $this->authorize('update', $checklist);

        $categories = ChecklistCategory::forUser(Auth::id())->get();
        return view('admin.checklists.edit', compact('checklist', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checklist $checklist)
    {
        $this->authorize('update', $checklist);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:checklist_categories,id',
            'color' => 'nullable|string|max:7',
            'is_public' => 'boolean',
            'due_date' => ['nullable', new PersianDate()],
            'priority' => 'in:low,normal,high,urgent',
            'status' => 'in:active,completed,paused,archived'
        ]);

        $checklist->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'color' => $request->color ?? '#3B82F6',
            'is_public' => $request->boolean('is_public'),
            'due_date' => PersianDateService::parseFromInput($request->due_date, true),
            'priority' => $request->priority ?? 'normal',
            'status' => $request->status ?? 'active'
        ]);

        return redirect()->route('checklists.show', $checklist)
            ->with('success', 'چک لیست با موفقیت به‌روزرسانی شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checklist $checklist)
    {
        $this->authorize('delete', $checklist);

        $checklist->delete();

        return redirect()->route('checklists.index')
            ->with('success', 'چک لیست با موفقیت حذف شد.');
    }

    /**
     * Display the print view for the specified checklist.
     */
    public function print(Checklist $checklist)
    {
        $this->authorize('view', $checklist);

        return view('admin.checklists.print', compact('checklist'));
    }

    /**
     * Toggle item completion status
     */
    public function toggleItem(Request $request, Checklist $checklist, ChecklistItem $item)
    {
        $this->authorize('view', $checklist);

        if ($item->checklist_id !== $checklist->id) {
            abort(404);
        }

        if ($item->is_completed) {
            $item->markAsPending();
        } else {
            $item->markAsCompleted();
        }

        return response()->json([
            'success' => true,
            'is_completed' => $item->is_completed,
            'status_text' => $item->status_text
        ]);
    }

    /**
     * Add new item to checklist
     */
    public function addItem(Request $request, Checklist $checklist)
    {
        $this->authorize('update', $checklist);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'in:low,normal,high,urgent',
            'due_date' => 'nullable|date'
        ]);

        $item = $checklist->items()->create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority ?? 'normal',
            'due_date' => PersianDateService::parseFromInput($request->due_date, true),
            'order' => $checklist->items()->max('order') + 1
        ]);

        return response()->json([
            'success' => true,
            'item' => $item
        ]);
    }

    /**
     * Update item
     */
    public function updateItem(Request $request, Checklist $checklist, ChecklistItem $item)
    {
        $this->authorize('update', $checklist);

        if ($item->checklist_id !== $checklist->id) {
            abort(404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'in:low,normal,high,urgent',
            'due_date' => 'nullable|date'
        ]);

        $item->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority ?? 'normal',
            'due_date' => PersianDateService::parseFromInput($request->due_date, true)
        ]);

        return response()->json([
            'success' => true,
            'item' => $item
        ]);
    }

    /**
     * Delete item
     */
    public function deleteItem(Checklist $checklist, ChecklistItem $item)
    {
        $this->authorize('update', $checklist);

        if ($item->checklist_id !== $checklist->id) {
            abort(404);
        }

        $item->delete();

        return response()->json(['success' => true]);
    }
}
