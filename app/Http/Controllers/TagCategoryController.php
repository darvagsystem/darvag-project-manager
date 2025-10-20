<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TagCategory;
use Illuminate\Support\Str;

class TagCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tagCategories = TagCategory::ordered()->get();
        return view('admin.tag-categories.index', compact('tagCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tag-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'sort_order' => 'nullable|integer|min:0',
            'is_required' => 'boolean',
            'required_for_projects' => 'nullable|array',
            'required_for_projects.*' => 'string|in:construction,industrial,infrastructure,energy,petrochemical'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($data['name']);
        $data['is_required'] = $request->has('is_required');

        TagCategory::create($data);

        return redirect()->route('panel.tag-categories.index')
            ->with('success', 'دسته‌بندی تگ با موفقیت ایجاد شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(TagCategory $tagCategory)
    {
        $tagCategory->load('tags');
        return view('admin.tag-categories.show', compact('tagCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TagCategory $tagCategory)
    {
        return view('admin.tag-categories.edit', compact('tagCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TagCategory $tagCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'sort_order' => 'nullable|integer|min:0',
            'is_required' => 'boolean',
            'required_for_projects' => 'nullable|array',
            'required_for_projects.*' => 'string|in:construction,industrial,infrastructure,energy,petrochemical'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($data['name']);
        $data['is_required'] = $request->has('is_required');

        $tagCategory->update($data);

        return redirect()->route('panel.tag-categories.index')
            ->with('success', 'دسته‌بندی تگ با موفقیت به‌روزرسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TagCategory $tagCategory)
    {
        if ($tagCategory->tags()->count() > 0) {
            return redirect()->back()
                ->with('error', 'نمی‌توان دسته‌بندی را حذف کرد زیرا دارای تگ است');
        }

        $tagCategory->delete();

        return redirect()->route('panel.tag-categories.index')
            ->with('success', 'دسته‌بندی تگ با موفقیت حذف شد');
    }
}
