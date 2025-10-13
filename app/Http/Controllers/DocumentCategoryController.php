<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentCategory;
use Illuminate\Support\Str;
use App\Services\ActivityLoggerService;

class DocumentCategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index()
    {
        $categories = DocumentCategory::withCount('documents')
                                    ->where('is_active', true)
                                    ->orderBy('sort_order')
                                    ->get();

        return view('admin.document-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('admin.document-categories.create');
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        // Generate category code before creation
        $tempCategory = new DocumentCategory([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'parent_id' => null, // No parent categories
            'icon' => $request->icon ?: 'mdi mdi-folder',
            'color' => $request->color ?: '#3b82f6',
            'sort_order' => $request->sort_order ?: 0,
            'is_active' => $request->boolean('is_active', true)
        ]);

        // Generate code for the new category (simple sequential numbering)
        $lastCategory = DocumentCategory::orderBy('id', 'desc')->first();
        $categoryCode = $lastCategory ? str_pad($lastCategory->id + 1, 2, '0', STR_PAD_LEFT) : '01';

        $category = DocumentCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'code' => $categoryCode,
            'description' => $request->description,
            'parent_id' => null, // No parent categories
            'icon' => $request->icon ?: 'mdi mdi-folder',
            'color' => $request->color ?: '#3b82f6',
            'sort_order' => $request->sort_order ?: 0,
            'is_active' => $request->boolean('is_active', true)
        ]);

        // Log activity
        ActivityLoggerService::logCreated($category, [
            'parent_category' => $category->parent ? $category->parent->name : 'هیچ',
            'path' => $category->path
        ]);

        return redirect()->route('panel.document-categories.index')
                       ->with('success', 'دسته‌بندی با موفقیت ایجاد شد');
    }

    /**
     * Display the specified category
     */
    public function show(DocumentCategory $category)
    {
        $category->load(['parent', 'children.documents', 'documents.creator']);

        return view('admin.document-categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit(DocumentCategory $category)
    {
        return view('admin.document-categories.edit', compact('category'));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, DocumentCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $oldData = $category->toArray();

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'parent_id' => null, // No parent categories
            'icon' => $request->icon ?: 'mdi mdi-folder',
            'color' => $request->color ?: '#3b82f6',
            'sort_order' => $request->sort_order ?: 0,
            'is_active' => $request->boolean('is_active', true)
        ]);

        // Log activity
        ActivityLoggerService::logUpdated($category, $oldData, $category->toArray());

        return redirect()->route('panel.document-categories.show', $category)
                       ->with('success', 'دسته‌بندی با موفقیت به‌روزرسانی شد');
    }

    /**
     * Remove the specified category
     */
    public function destroy(DocumentCategory $category)
    {
        // Check if category has children
        if ($category->children()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'این دسته‌بندی دارای زیردسته است و قابل حذف نیست'
            ], 400);
        }

        // Check if category has documents
        if ($category->documents()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'این دسته‌بندی دارای سند است و قابل حذف نیست'
            ], 400);
        }

        // Log activity before deletion
        ActivityLoggerService::logDeleted($category, [
            'name' => $category->name,
            'path' => $category->path
        ]);

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'دسته‌بندی با موفقیت حذف شد'
        ]);
    }

    /**
     * Toggle category status
     */
    public function toggleStatus(DocumentCategory $category)
    {
        $category->update(['is_active' => !$category->is_active]);

        $status = $category->is_active ? 'فعال' : 'غیرفعال';

        return redirect()->back()
                       ->with('success', "دسته‌بندی {$status} شد");
    }

    /**
     * Update sort order
     */
    public function updateSortOrder(Request $request)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:document_categories,id',
            'categories.*.sort_order' => 'required|integer|min:0'
        ]);

        foreach ($request->categories as $categoryData) {
            DocumentCategory::where('id', $categoryData['id'])
                          ->update(['sort_order' => $categoryData['sort_order']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Generate category code for new category
     */
    private function generateCategoryCodeForNew($parentId = null)
    {
        if (!$parentId) {
            // Root category - use simple numbering
            $lastRoot = DocumentCategory::whereNull('parent_id')
                                     ->orderBy('id', 'desc')
                                     ->first();
            $nextNumber = $lastRoot ? $lastRoot->id + 1 : 1;
            return str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
        }

        // Child category - use parent code + sequential number
        $parent = DocumentCategory::find($parentId);
        if (!$parent) {
            return '01';
        }

        $siblings = DocumentCategory::where('parent_id', $parentId)->count();
        $nextNumber = $siblings + 1;
        $childCode = str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        return $parent->code . '.' . $childCode;
    }

    /**
     * Generate category code based on hierarchy
     */
    private function generateCategoryCode($category)
    {
        if (!$category->parent_id) {
            // Root category - use simple numbering
            $lastRoot = DocumentCategory::whereNull('parent_id')
                                     ->where('id', '!=', $category->id)
                                     ->orderBy('id', 'desc')
                                     ->first();
            $nextNumber = $lastRoot ? $lastRoot->id + 1 : $category->id;
            return str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
        }

        // Child category - use parent code + sequential number
        $parent = $category->parent;
        if (!$parent) {
            return '01';
        }

        $siblings = DocumentCategory::where('parent_id', $category->parent_id)
                                  ->where('id', '<=', $category->id)
                                  ->count();

        $childCode = str_pad($siblings, 2, '0', STR_PAD_LEFT);

        return $parent->code . '.' . $childCode;
    }
}
