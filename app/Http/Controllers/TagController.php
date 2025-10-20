<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\TagCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    /**
     * Display a listing of tags.
     */
    public function index()
    {
        $tags = Tag::with('category')->orderBy('name')->paginate(20);
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new tag.
     */
    public function create()
    {
        $categories = TagCategory::orderBy('name')->get();
        return view('admin.tags.create', compact('categories'));
    }

    /**
     * Store a newly created tag.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|max:7',
            'category_id' => 'required|exists:tag_categories,id'
        ]);

        Tag::create([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
            'category_id' => $request->category_id
        ]);

        return redirect()->route('panel.tags.index')
                        ->with('success', 'تگ با موفقیت ایجاد شد.');
    }

    /**
     * Display the specified tag.
     */
    public function show(Tag $tag)
    {
        $tag->load('category');
        return view('admin.tags.show', compact('tag'));
    }

    /**
     * Display files with this tag.
     */
    public function files(Tag $tag)
    {
        $files = $tag->files()->with(['archive', 'archive.project'])->paginate(20);
        return view('admin.tags.files', compact('tag', 'files'));
    }

    /**
     * Get tags for API.
     */
    public function getTags(Request $request)
    {
        $query = Tag::with('category');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        return $query->get();
    }

    /**
     * Show the form for editing the specified tag.
     */
    public function edit(Tag $tag)
    {
        $categories = TagCategory::orderBy('name')->get();
        return view('admin.tags.edit', compact('tag', 'categories'));
    }

    /**
     * Update the specified tag.
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|max:7',
            'category_id' => 'required|exists:tag_categories,id'
        ]);

        $tag->update([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
            'category_id' => $request->category_id
        ]);

        return redirect()->route('panel.tags.index')
                        ->with('success', 'تگ با موفقیت به‌روزرسانی شد.');
    }

    /**
     * Remove the specified tag.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('panel.tags.index')
                        ->with('success', 'تگ با موفقیت حذف شد.');
    }
}
