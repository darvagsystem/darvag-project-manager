<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\ArchiveFile;
use App\Models\Project;
use App\Models\Tag;
use App\Models\ProjectTagRequirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{
    /**
     * Display a listing of archives.
     */
    public function index()
    {
        $archives = Archive::with(['project', 'creator'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.archives.index', compact('archives'));
    }

    /**
     * Show the form for creating a new archive.
     */
    public function create()
    {
        $projects = Project::whereDoesntHave('archive')->get();

        return view('admin.archives.create', compact('projects'));
    }

    /**
     * Store a newly created archive.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id|unique:archives,project_id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'required_tags' => 'array',
            'required_tags.*' => 'exists:tags,id'
        ]);

        $archive = Archive::create([
            'project_id' => $request->project_id,
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => Auth::id()
        ]);

        // No default folders created - user will create them manually

        // Set tag requirements
        if ($request->has('required_tags')) {
            foreach ($request->required_tags as $tagId) {
                ProjectTagRequirement::create([
                    'project_id' => $archive->project_id,
                    'tag_id' => $tagId,
                    'is_required' => true,
                    'priority' => 1,
                    'created_by' => Auth::id()
                ]);
            }
        }

        return redirect()->route('archives.show', $archive)
                        ->with('success', 'بایگانی با موفقیت ایجاد شد.');
    }

    /**
     * Display the specified archive.
     */
    public function show(Archive $archive)
    {
        $archive->load(['project', 'rootFolders.children', 'files', 'tagRequirements.tag']);

        return view('admin.archives.show', compact('archive'));
    }

    /**
     * Show the form for editing the specified archive.
     */
    public function edit(Archive $archive)
    {
        $projects = Project::all();
        $selectedTags = $archive->tagRequirements()->pluck('tag_id')->toArray();

        return view('admin.archives.edit', compact('archive', 'projects', 'selectedTags'));
    }

    /**
     * Update the specified archive.
     */
    public function update(Request $request, Archive $archive)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'required_tags' => 'array',
            'required_tags.*' => 'exists:tags,id'
        ]);

        $archive->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        // Update tag requirements
        $archive->tagRequirements()->delete();
        if ($request->has('required_tags')) {
            foreach ($request->required_tags as $tagId) {
                ProjectTagRequirement::create([
                    'project_id' => $archive->project_id,
                    'tag_id' => $tagId,
                    'is_required' => true,
                    'priority' => 1,
                    'created_by' => Auth::id()
                ]);
            }
        }

        $archive->checkCompletion();

        return redirect()->route('archives.show', $archive)
                        ->with('success', 'بایگانی با موفقیت به‌روزرسانی شد.');
    }

    /**
     * Remove the specified archive.
     */
    public function destroy(Archive $archive)
    {
        // Delete all files
        foreach ($archive->files as $file) {
            $file->deleteFile();
            $file->delete();
        }

        // Delete all folders
        foreach ($archive->folders as $folder) {
            $folder->delete();
        }

        // Delete tag requirements
        $archive->tagRequirements()->delete();

        $archive->delete();

        return redirect()->route('archives.index')
                        ->with('success', 'بایگانی با موفقیت حذف شد.');
    }

    /**
     * Upload files to archive
     */
    public function uploadFiles(Request $request, Archive $archive)
    {
        try {
            $request->validate([
                'files.*' => 'required|file|max:10240',
                'description' => 'nullable|string|max:500',
                'tags' => 'nullable|array',
                'tags.*' => 'exists:tags,id'
            ]);

            $currentFolder = null; // You can get this from request if needed
            $uploadedCount = 0;

            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . \Illuminate\Support\Str::random(10) . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('archives/' . $archive->id, $fileName, 'public');

                ArchiveFile::create([
                    'archive_id' => $archive->id,
                    'folder_id' => $currentFolder,
                    'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                    'original_name' => $file->getClientOriginalName(),
                    'file_path' => $filePath,
                    'file_name' => $fileName,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension(),
                    'description' => $request->description,
                    'tag_requirements' => $request->tags ?? [],
                    'uploaded_by' => auth()->id()
                ]);

                $uploadedCount++;
            }

            $archive->checkCompletion();

            return response()->json([
                'success' => true,
                'message' => $uploadedCount . ' فایل با موفقیت آپلود شد.',
                'count' => $uploadedCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در آپلود: ' . $e->getMessage()
            ], 500);
        }
    }

}
