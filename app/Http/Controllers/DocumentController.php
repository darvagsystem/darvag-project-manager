<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentVersion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\ActivityLoggerService;

class DocumentController extends Controller
{
    /**
     * Display documents dashboard
     */
    public function index(Request $request)
    {
        try {
            // Get statistics
            $stats = $this->getDocumentStats();

        // Get recent documents
        $recentDocuments = Document::with(['category', 'creator'])
                                 ->where('is_active', true)
                                 ->orderBy('created_at', 'desc')
                                 ->limit(6)
                                 ->get();

        // Get popular documents
        $popularDocuments = Document::with(['category', 'creator'])
                                  ->where('is_active', true)
                                  ->orderByRaw('(download_count + view_count) DESC')
                                  ->limit(6)
                                  ->get();

        // Get documents by category
        $documentsByCategory = DocumentCategory::withCount(['documents' => function($query) {
            $query->where('is_active', true);
        }])
        ->where('is_active', true)
        ->having('documents_count', '>', 0)
        ->orderBy('documents_count', 'desc')
        ->limit(8)
        ->get();

        // Get documents by file type
        $documentsByFileType = Document::where('is_active', true)
                                     ->selectRaw('file_type, COUNT(*) as count')
                                     ->groupBy('file_type')
                                     ->orderBy('count', 'desc')
                                     ->get();

        // Get recent activity (simplified)
        $recentActivity = collect();

        // Get search/filter data
        $categories = DocumentCategory::where('is_active', true)->with('children')->get();
        $fileTypes = Document::where('is_active', true)->distinct()->pluck('file_type')->filter();
        $tags = Document::where('is_active', true)
                      ->whereNotNull('tags')
                      ->get()
                      ->pluck('tags')
                      ->flatten()
                      ->unique()
                      ->values();

            return view('admin.documents.dashboard', compact(
                'stats',
                'recentDocuments',
                'popularDocuments',
                'documentsByCategory',
                'documentsByFileType',
                'recentActivity',
                'categories',
                'fileTypes',
                'tags'
            ));

        } catch (\Exception $e) {
            // Log error and return simple view
            \Log::error('Document index error: ' . $e->getMessage());

            return view('admin.documents.dashboard', [
                'stats' => [
                    'total_documents' => 0,
                    'total_categories' => 0,
                    'total_downloads' => 0,
                    'total_views' => 0,
                    'this_month' => 0,
                    'most_popular_category' => null,
                    'most_downloaded' => null
                ],
                'recentDocuments' => collect(),
                'popularDocuments' => collect(),
                'documentsByCategory' => collect(),
                'documentsByFileType' => collect(),
                'recentActivity' => collect(),
                'categories' => collect(),
                'fileTypes' => collect(),
                'tags' => collect()
            ]);
        }
    }

    /**
     * Display documents list with search/filter
     */
    public function list(Request $request)
    {
        $query = Document::with(['category', 'creator', 'currentVersion'])
                        ->where('is_active', true);

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->byCategory($request->category_id);
        }

        // Filter by file type
        if ($request->filled('file_type')) {
            $query->byFileType($request->file_type);
        }

        // Filter by tags
        if ($request->filled('tag')) {
            $query->byTag($request->tag);
        }

        // Sort options
        $sortBy = $request->get('sort', 'recent');
        switch ($sortBy) {
            case 'popular':
                $query->popular();
                break;
            case 'title':
                $query->orderBy('title');
                break;
            case 'oldest':
                $query->orderBy('created_at');
                break;
            default:
                $query->recent();
        }

        $documents = $query->paginate(20);
        $categories = DocumentCategory::where('is_active', true)->with('children')->get();
        $fileTypes = Document::where('is_active', true)->distinct()->pluck('file_type')->filter();
        $tags = $this->getAllTags();

        return view('admin.documents.list', compact(
            'documents',
            'categories',
            'fileTypes',
            'tags'
        ));
    }

    /**
     * Show the form for creating a new document
     */
    public function create()
    {
        $categories = DocumentCategory::where('is_active', true)->with('children')->get();
        return view('admin.documents.create', compact('categories'));
    }

    /**
     * Store a newly created document
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:document_categories,id',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar|max:10240',
            'tags' => 'nullable|string',
            'form_code' => 'nullable|string|unique:documents,form_code',
            'version_name' => 'nullable|string|max:255',
            'changelog' => 'nullable|string'
        ], [
            'title.required' => 'عنوان سند الزامی است',
            'title.max' => 'عنوان سند نمی‌تواند بیش از 255 کاراکتر باشد',
            'category_id.required' => 'انتخاب دسته‌بندی الزامی است',
            'category_id.exists' => 'دسته‌بندی انتخاب شده معتبر نیست',
            'file.required' => 'انتخاب فایل الزامی است',
            'file.file' => 'فایل انتخاب شده معتبر نیست',
            'file.mimes' => 'فرمت فایل مجاز نیست. فرمت‌های مجاز: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, ZIP, RAR',
            'file.max' => 'حجم فایل نمی‌تواند بیش از 10 مگابایت باشد',
            'form_code.unique' => 'کد فرم قبلاً استفاده شده است',
            'version_name.max' => 'نام نسخه نمی‌تواند بیش از 255 کاراکتر باشد'
        ]);

        try {
            DB::beginTransaction();

            // Handle file upload
            $file = $request->file('file');
            $filePath = $file->store('documents', 'public');
            $fileSize = $file->getSize();
            $fileType = $file->getClientOriginalExtension();
            $fileHash = hash_file('sha256', $file->getPathname());

            // Create document
            $document = Document::create([
                'form_code' => $request->form_code ?: 'DOC-' . strtoupper(Str::random(8)),
                'title' => $request->title,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'file_type' => $fileType,
                'file_size' => $fileSize,
                'file_path' => $filePath,
                'tags' => $this->parseTags($request->tags),
                'created_by' => auth()->id(),
                'updated_by' => auth()->id()
            ]);

            // Create first version
            DocumentVersion::create([
                'document_id' => $document->id,
                'version_number' => '1.0',
                'version_name' => $request->version_name ?: 'نسخه اولیه',
                'changelog' => $request->changelog ?: 'نسخه اولیه سند',
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $file->getMimeType(),
                'file_size' => $fileSize,
                'file_hash' => $fileHash,
                'is_current' => true,
                'is_active' => true,
                'created_by' => auth()->id()
            ]);

            // Generate thumbnail for images
            $this->generateThumbnail($document, $file);

            DB::commit();

            // Log activity
            ActivityLoggerService::logCreated($document, [
                'form_code' => $document->form_code,
                'file_type' => $fileType,
                'file_size' => $fileSize
            ]);

            return redirect()->route('panel.documents.index')
                           ->with('success', 'سند با موفقیت ایجاد شد');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            throw $e; // Re-throw validation exceptions
        } catch (\Exception $e) {
            DB::rollBack();

            // Clean up uploaded file
            if (isset($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            // Log the error for debugging
            \Log::error('Document upload error: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'file_name' => $request->file('file') ? $request->file('file')->getClientOriginalName() : 'unknown',
                'file_size' => $request->file('file') ? $request->file('file')->getSize() : 0,
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                           ->with('error', 'خطا در آپلود فایل: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Display the specified document
     */
    public function show(Document $document)
    {
        $document->incrementViewCount();

        $document->load(['category', 'creator', 'versions.creator']);

        return view('admin.documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified document
     */
    public function edit(Document $document)
    {
        $categories = DocumentCategory::where('is_active', true)->with('children')->get();
        return view('admin.documents.edit', compact('document', 'categories'));
    }

    /**
     * Update the specified document
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:document_categories,id',
            'tags' => 'nullable|string',
            'form_code' => 'required|string|unique:documents,form_code,' . $document->id,
            'is_active' => 'boolean'
        ]);

        $oldData = $document->toArray();

        $document->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'tags' => $this->parseTags($request->tags),
            'form_code' => $request->form_code,
            'is_active' => $request->boolean('is_active', true),
            'updated_by' => auth()->id()
        ]);

        // Log activity
        ActivityLoggerService::logUpdated($document, $oldData, $document->toArray());

        return redirect()->route('panel.documents.show', $document)
                       ->with('success', 'سند با موفقیت به‌روزرسانی شد');
    }

    /**
     * Remove the specified document
     */
    public function destroy(Document $document)
    {
        try {
            DB::beginTransaction();

            // Delete all versions and their files
            foreach ($document->versions as $version) {
                if ($version->file_path) {
                    Storage::disk('public')->delete($version->file_path);
                }
                $version->delete();
            }

            // Delete main document file
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }

            // Delete thumbnail
            if ($document->thumbnail_path) {
                Storage::disk('public')->delete($document->thumbnail_path);
            }

            // Log activity before deletion
            ActivityLoggerService::logDeleted($document, [
                'form_code' => $document->form_code,
                'title' => $document->title
            ]);

            $document->delete();

            DB::commit();

            return redirect()->route('panel.documents.index')
                           ->with('success', 'سند با موفقیت حذف شد');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'خطا در حذف سند: ' . $e->getMessage());
        }
    }

    /**
     * Download document
     */
    public function download(Document $document)
    {
        $document->incrementDownloadCount();

        // Log activity
        ActivityLoggerService::log('downloaded', "سند {$document->title} دانلود شد", $document, [
            'form_code' => $document->form_code,
            'file_type' => $document->file_type
        ]);

        return Storage::disk('public')->download($document->file_path, $document->title . '.' . $document->file_type);
    }

    /**
     * Download specific version
     */
    public function downloadVersion(Document $document, DocumentVersion $version)
    {
        // Verify that the version belongs to this document
        if ($version->document_id !== $document->id) {
            abort(404, 'Version not found');
        }

        $document->incrementDownloadCount();

        // Log activity
        ActivityLoggerService::log('downloaded', "نسخه {$version->version_number} سند {$document->title} دانلود شد", $document, [
            'form_code' => $document->form_code,
            'version_number' => $version->version_number,
            'file_type' => $document->file_type
        ]);

        $fileName = $document->title . '_v' . $version->version_number . '.' . $document->file_type;
        return Storage::disk('public')->download($version->file_path, $fileName);
    }

    /**
     * Upload new version
     */
    public function uploadVersion(Request $request, Document $document)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar|max:10240',
            'version_number' => 'required|string',
            'version_name' => 'nullable|string|max:255',
            'changelog' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $file = $request->file('file');
            $filePath = $file->store('documents', 'public');
            $fileSize = $file->getSize();
            $fileHash = hash_file('sha256', $file->getPathname());

            // Create new version
            $version = DocumentVersion::create([
                'document_id' => $document->id,
                'version_number' => $request->version_number,
                'version_name' => $request->version_name,
                'changelog' => $request->changelog,
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $file->getMimeType(),
                'file_size' => $fileSize,
                'file_hash' => $fileHash,
                'is_current' => true,
                'is_active' => true,
                'created_by' => auth()->id()
            ]);

            // Set as current version
            $version->setAsCurrent();

            // Update document file info
            $document->update([
                'file_path' => $filePath,
                'file_size' => $fileSize,
                'updated_by' => auth()->id()
            ]);

            DB::commit();

            return redirect()->route('panel.documents.show', $document)
                           ->with('success', 'نسخه جدید با موفقیت آپلود شد');

        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return redirect()->back()
                           ->with('error', 'خطا در آپلود نسخه جدید: ' . $e->getMessage());
        }
    }

    /**
     * Set version as current
     */
    public function setCurrentVersion(Document $document, DocumentVersion $version)
    {
        $version->setAsCurrent();

        return redirect()->route('panel.documents.show', $document)
                       ->with('success', 'نسخه به عنوان نسخه فعلی تنظیم شد');
    }

    /**
     * Get all unique tags
     */
    private function getAllTags()
    {
        return Document::active()
                      ->whereNotNull('tags')
                      ->get()
                      ->pluck('tags')
                      ->flatten()
                      ->unique()
                      ->values();
    }

    /**
     * Parse tags from string
     */
    private function parseTags($tagsString)
    {
        if (empty($tagsString)) {
            return [];
        }

        return collect(explode(',', $tagsString))
               ->map(fn($tag) => trim($tag))
               ->filter()
               ->values()
               ->toArray();
    }

    /**
     * Generate thumbnail for document
     */
    private function generateThumbnail(Document $document, $file)
    {
        // This is a placeholder - you can implement actual thumbnail generation
        // based on file type (PDF, images, etc.)
        $document->update([
            'thumbnail_path' => null // Implement thumbnail generation logic here
        ]);
    }

    /**
     * Get document statistics
     */
    private function getDocumentStats()
    {
        // Get all active documents (remove is_template filter)
        $totalDocuments = Document::where('is_active', true)->count();
        $totalCategories = DocumentCategory::where('is_active', true)->count();
        $totalDownloads = Document::where('is_active', true)->sum('download_count');
        $totalViews = Document::where('is_active', true)->sum('view_count');

        // Documents added this month
        $thisMonth = Document::where('is_active', true)
                            ->whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->count();

        // Most popular category
        $mostPopularCategory = DocumentCategory::withCount(['documents' => function($query) {
            $query->where('is_active', true);
        }])
        ->where('is_active', true)
        ->having('documents_count', '>', 0)
        ->orderBy('documents_count', 'desc')
        ->first();

        // Most downloaded document
        $mostDownloaded = Document::where('is_active', true)
                                ->orderBy('download_count', 'desc')
                                ->first();

        return [
            'total_documents' => $totalDocuments,
            'total_categories' => $totalCategories,
            'total_downloads' => $totalDownloads,
            'total_views' => $totalViews,
            'this_month' => $thisMonth,
            'most_popular_category' => $mostPopularCategory,
            'most_downloaded' => $mostDownloaded
        ];
    }

    /**
     * Get recent activity
     */
    private function getRecentActivity()
    {
        return \App\Models\ActivityLog::whereIn('action', ['created', 'updated', 'downloaded'])
                                    ->where('model_type', 'App\Models\Document')
                                    ->with(['user'])
                                    ->latest()
                                    ->limit(10)
                                    ->get();
    }
}
