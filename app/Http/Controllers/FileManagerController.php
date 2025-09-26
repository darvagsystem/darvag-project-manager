<?php

namespace App\Http\Controllers;

use App\Models\FileManager;
use App\Models\Project;
use App\Models\ProjectTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use ZipArchive;
use Response;

class FileManagerController extends Controller
{
    /**
     * Display the file manager for general files
     */
    public function index(Request $request)
    {
        $project = null;
        $currentFolder = null;
        $folderId = $request->get('folder');

        if ($folderId) {
            $currentFolder = FileManager::findOrFail($folderId);
        }

        // Get current directory contents
        $query = FileManager::with(['uploader', 'project'])
            ->whereNull('project_id');

        if ($currentFolder) {
            $query->where('parent_id', $currentFolder->id);
            $breadcrumb = $currentFolder->getBreadcrumb();
        } else {
            $query->whereNull('parent_id');
            $breadcrumb = collect();
        }

        $folders = $query->where('is_folder', true)->get();
        $files = $query->where('is_folder', false)->get();

        return view('admin.file-manager.index', compact('project', 'folders', 'files', 'currentFolder', 'breadcrumb'));
    }

    /**
     * Display the file manager for a specific project
     */
    public function projectFiles(Request $request, Project $project)
    {
        $currentFolder = null;
        $folderId = $request->get('folder');

        if ($folderId) {
            $currentFolder = FileManager::where('project_id', $project->id)
                ->findOrFail($folderId);
        }

        // Get current directory contents
        $query = FileManager::with(['uploader', 'project'])
            ->where('project_id', $project->id);

        if ($currentFolder) {
            $query->where('parent_id', $currentFolder->id);
            $breadcrumb = $currentFolder->getBreadcrumb();
        } else {
            $query->whereNull('parent_id');
            $breadcrumb = collect();
        }

        $folders = $query->where('is_folder', true)->get();
        $files = $query->where('is_folder', false)->get();

        return view('admin.file-manager.index', compact('project', 'folders', 'files', 'currentFolder', 'breadcrumb'));
    }

    /**
     * Create a new folder
     */
    public function createFolder(Request $request)
    {
        $project = $this->resolveProject($request);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'folder_color' => 'nullable|string',
            'parent_id' => 'nullable|exists:file_managers,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در اعتبارسنجی داده‌ها',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $folder = FileManager::create([
                'name' => $request->name,
                'type' => 'folder',
                'is_folder' => true,
                'is_template' => false,
                'parent_id' => $request->parent_id,
                'project_id' => $project?->id,
                'description' => $request->description,
                'folder_color' => $request->folder_color,
                'uploaded_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'پوشه با موفقیت ایجاد شد',
                'folder' => $folder
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در ایجاد پوشه: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload files
     */
    public function upload(Request $request)
    {
        $project = $this->resolveProject($request);

        $validator = Validator::make($request->all(), [
            'files' => 'required|array',
            'files.*' => 'file|max:10240', // 10MB max per file
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:file_managers,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در اعتبارسنجی داده‌ها',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $uploadedFiles = [];

            foreach ($request->file('files') as $file) {
                $path = $file->store('file-manager', 'public');

                $uploadedFile = FileManager::create([
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'type' => 'file',
                    'is_folder' => false,
                    'is_template' => false,
                    'parent_id' => $request->parent_id,
                    'project_id' => $project?->id,
                    'description' => $request->description,
                    'uploaded_by' => auth()->id()
                ]);

                $uploadedFiles[] = $uploadedFile;
            }

            return response()->json([
                'success' => true,
                'message' => 'فایل‌ها با موفقیت آپلود شدند',
                'files' => $uploadedFiles
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در آپلود فایل‌ها: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download a file
     */
    public function download($id)
    {
        $file = FileManager::findOrFail($id);

        if ($file->is_folder) {
            return response()->json([
                'success' => false,
                'message' => 'نمی‌توان پوشه را دانلود کرد'
            ], 400);
        }

        $filePath = storage_path('app/public/' . $file->path);

        if (!file_exists($filePath)) {
            return response()->json([
                'success' => false,
                'message' => 'فایل یافت نشد'
            ], 404);
        }

        return response()->download($filePath, $file->name);
    }

    /**
     * Bulk download files
     */
    public function bulkDownload(Request $request)
    {
        $project = $this->resolveProject($request);

        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:file_managers,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در اعتبارسنجی داده‌ها'
            ], 422);
        }

        try {
            $files = FileManager::whereIn('id', $request->ids)
                ->where('is_folder', false)
                ->when($project, function ($query) use ($project) {
                    $query->where('project_id', $project->id);
                }, function ($query) {
                    $query->whereNull('project_id');
                })
                ->get();

            if ($files->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'فایلی برای دانلود یافت نشد'
                ], 404);
            }

            $zip = new ZipArchive();
            $zipName = 'files_' . time() . '.zip';
            $zipPath = storage_path('app/temp/' . $zipName);

            if (!file_exists(storage_path('app/temp'))) {
                mkdir(storage_path('app/temp'), 0755, true);
            }

            if ($zip->open($zipPath, ZipArchive::CREATE) !== TRUE) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در ایجاد فایل ZIP'
                ], 500);
            }

            foreach ($files as $file) {
                $filePath = storage_path('app/public/' . $file->path);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $file->name);
                }
            }

            $zip->close();

            return response()->download($zipPath, $zipName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در ایجاد فایل ZIP: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Rename a file or folder
     */
    public function rename(Request $request, $id)
    {
        $project = $this->resolveProject($request);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در اعتبارسنجی داده‌ها',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // ابتدا بررسی کنیم که آیتم وجود دارد
            $query = FileManager::where('id', $id);

            if ($project) {
                $query->where('project_id', $project->id);
            } else {
                $query->whereNull('project_id');
            }

            // استفاده از first() به جای firstOrFail() برای مدیریت بهتر خطا
            $file = $query->first();
            
            if (!$file) {
                return response()->json([
                    'success' => false,
                    'message' => 'آیتم مورد نظر یافت نشد'
                ], 404);
            }

            // بررسی اینکه آیا نام جدید با نام قدیم یکی نیست
            if ($file->name === $request->name) {
                return response()->json([
                    'success' => true,
                    'message' => 'نام بدون تغییر باقی ماند'
                ]);
            }

            // بررسی اینکه نام جدید تکراری نباشد در همان پوشه
            $duplicate = FileManager::where('name', $request->name)
                ->where('parent_id', $file->parent_id)
                ->where('is_folder', $file->is_folder)
                ->where('id', '!=', $id);
                
            if ($project) {
                $duplicate->where('project_id', $project->id);
            } else {
                $duplicate->whereNull('project_id');
            }
            
            if ($duplicate->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'نام انتخاب شده تکراری است'
                ], 422);
            }

            // تغییر نام
            $file->update(['name' => $request->name]);

            return response()->json([
                'success' => true,
                'message' => 'نام با موفقیت تغییر کرد',
                'file' => $file
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in rename: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'خطا در تغییر نام',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Move files or folders
     */
    public function move(Request $request)
    {
        $project = $this->resolveProject($request);

        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:file_managers,id',
            'destination_folder_id' => 'nullable|exists:file_managers,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در اعتبارسنجی داده‌ها',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $query = FileManager::whereIn('id', $request->ids);

            if ($project) {
                $query->where('project_id', $project->id);
            } else {
                $query->whereNull('project_id');
            }

            $items = $query->get();

            if ($items->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'آیتم‌های انتخاب شده یافت نشدند'
                ], 404);
            }

            foreach ($items as $item) {
                $item->update(['parent_id' => $request->destination_folder_id]);
            }

            return response()->json([
                'success' => true,
                'message' => 'آیتم‌ها با موفقیت منتقل شدند'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in move: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'خطا در انتقال آیتم‌ها',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete files or folders
     */
    public function delete(Request $request)
    {
        $project = $this->resolveProject($request);

        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:file_managers,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در اعتبارسنجی داده‌ها',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $query = FileManager::whereIn('id', $request->ids);

            if ($project) {
                $query->where('project_id', $project->id);
            } else {
                $query->whereNull('project_id');
            }

            $items = $query->get();

            if ($items->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'آیتم‌های انتخاب شده یافت نشدند'
                ], 404);
            }

            foreach ($items as $item) {
                if (!$item->is_folder) {
                    // Delete physical file
                    $filePath = storage_path('app/public/' . $item->path);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                // Delete from database
                $item->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'آیتم‌ها با موفقیت حذف شدند'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in delete: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'خطا در حذف آیتم‌ها',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get file details
     */
    public function details($id)
    {
        $file = FileManager::with(['uploader', 'project'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'file' => $file
        ]);
    }

    /**
     * Search files and folders
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => 'عبارت جستجو الزامی است'
            ], 400);
        }

        $results = FileManager::with(['uploader', 'project'])
            ->where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $results
        ]);
    }

    private function resolveProject(Request $request): ?Project
    {
        $projectParam = $request->route('project');

        if ($projectParam instanceof Project) {
            return $projectParam;
        }

        if (is_numeric($projectParam)) {
            return Project::findOrFail($projectParam);
        }

        return null;
    }
}
