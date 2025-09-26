<?php

namespace App\Http\Controllers;

use App\Models\FileManager;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FileManagerController extends Controller
{
    /**
     * نمایش فایل منیجر عمومی
     */
    public function index(Request $request)
    {
        $currentFolder = $this->getCurrentFolder($request->get('folder'));
        $breadcrumb = $this->getBreadcrumb($currentFolder);
        $contents = $this->getFolderContents($currentFolder);

        return view('admin.file-manager.index', [
            'project' => null,
            'currentFolder' => $currentFolder,
            'folders' => $contents['folders'],
            'files' => $contents['files'],
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * نمایش فایل منیجر پروژه
     */
    public function projectFiles(Request $request, Project $project)
    {
        $currentFolder = $this->getCurrentFolder($request->get('folder'), $project);
        $breadcrumb = $this->getBreadcrumb($currentFolder);
        $contents = $this->getFolderContents($currentFolder, $project);

        return view('admin.file-manager.index', [
            'project' => $project,
            'currentFolder' => $currentFolder,
            'folders' => $contents['folders'],
            'files' => $contents['files'],
            'breadcrumb' => $breadcrumb
        ]);
    }

    /**
     * ایجاد پوشه جدید
     */
    public function createFolder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'folder_color' => 'nullable|string',
            'parent_id' => 'nullable|exists:file_manager,id',
            'project_id' => 'nullable|exists:projects,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'داده‌های ورودی نامعتبر است',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // بررسی تکراری نبودن نام در همان پوشه
            $exists = FileManager::where('name', $request->name)
                ->where('parent_id', $request->parent_id)
                ->where('project_id', $request->project_id)
                ->where('is_folder', true)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'پوشه‌ای با این نام در این مکان وجود دارد'
                ], 422);
            }

            $folder = FileManager::create([
                'name' => $request->name,
                'type' => 'folder',
                'is_folder' => true,
                'parent_id' => $request->parent_id,
                'project_id' => $request->project_id,
                'description' => $request->description,
                'folder_color' => $request->folder_color ?: '#ffc107',
                'uploaded_by' => auth()->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'پوشه با موفقیت ایجاد شد',
                'folder' => $folder->load('uploader')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در ایجاد پوشه: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * آپلود فایل‌ها
     */
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files' => 'required|array',
            'files.*' => 'file|max:20480', // 20MB
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:file_manager,id',
            'project_id' => 'nullable|exists:projects,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'داده‌های ورودی نامعتبر است',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $uploadedFiles = [];

            foreach ($request->file('files') as $file) {
                // ذخیره فایل
                $path = $file->store('file-manager', 'public');

                // ایجاد رکورد در دیتابیس
                $originalName = $file->getClientOriginalName();
                $fileRecord = FileManager::create([
                    'name' => $originalName,
                    'original_name' => $originalName,
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'type' => 'file',
                    'is_folder' => false,
                    'parent_id' => $request->parent_id,
                    'project_id' => $request->project_id,
                    'description' => $request->description,
                    'uploaded_by' => auth()->id()
                ]);

                $uploadedFiles[] = $fileRecord->load('uploader');
            }

            return response()->json([
                'success' => true,
                'message' => count($uploadedFiles) . ' فایل با موفقیت آپلود شد',
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
     * تغییر نام فایل یا پوشه
     */
    public function rename(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'نام وارد شده نامعتبر است'
            ], 422);
        }

        try {
            $item = FileManager::findOrFail($id);

            // بررسی تکراری نبودن نام
            $exists = FileManager::where('name', $request->name)
                ->where('parent_id', $item->parent_id)
                ->where('project_id', $item->project_id)
                ->where('is_folder', $item->is_folder)
                ->where('id', '!=', $id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'نام انتخاب شده تکراری است'
                ], 422);
            }

            $item->update(['name' => $request->name]);

            return response()->json([
                'success' => true,
                'message' => 'نام با موفقیت تغییر کرد',
                'item' => $item->fresh()->load('uploader')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در تغییر نام: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * حذف فایل‌ها یا پوشه‌ها
     */
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:file_manager,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'آیتم‌های انتخاب شده نامعتبر است'
            ], 422);
        }

        try {
            $items = FileManager::whereIn('id', $request->ids)->get();

            foreach ($items as $item) {
                if ($item->is_folder) {
                    // حذف پوشه و تمام محتویات آن
                    $this->deleteFolderRecursively($item);
                } else {
                    // حذف فایل فیزیکی
                    if ($item->path && Storage::disk('public')->exists($item->path)) {
                        Storage::disk('public')->delete($item->path);
                    }
                    $item->delete();
                }
            }

            return response()->json([
                'success' => true,
                'message' => count($items) . ' آیتم با موفقیت حذف شد'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در حذف آیتم‌ها: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * دانلود فایل
     */
    public function download($id)
    {
        try {
            $file = FileManager::where('is_folder', false)->findOrFail($id);

            if (!$file->path || !Storage::disk('public')->exists($file->path)) {
                abort(404, 'فایل یافت نشد');
            }

            // به‌روزرسانی تعداد دانلود
            $file->increment('download_count');
            $file->update(['last_accessed_at' => now()]);

            $filePath = Storage::disk('public')->path($file->path);

            // استفاده از نام اصلی فایل اگر موجود است، در غیر این صورت از نام ذخیره شده
            $fileName = $file->original_name ?: $file->name;

            // اگر نام فایل پسوند ندارد، آن را از mime type استخراج کنیم
            if (!pathinfo($fileName, PATHINFO_EXTENSION) && $file->mime_type) {
                $extension = $this->getExtensionFromMimeType($file->mime_type);
                if ($extension) {
                    $fileName .= '.' . $extension;
                }
            }

            // تمیز کردن نام فایل از کاراکترهای غیرمجاز
            $fileName = $this->sanitizeFileName($fileName);

            return response()->download($filePath, $fileName, [
                'Content-Type' => $file->mime_type ?: 'application/octet-stream',
            ]);

        } catch (\Exception $e) {
            abort(500, 'خطا در دانلود فایل');
        }
    }

    /**
     * استخراج پسوند از mime type
     */
    private function getExtensionFromMimeType($mimeType)
    {
        $mimeToExt = [
            'image/jpeg' => 'jpg',
            'image/jpg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            'image/svg+xml' => 'svg',
            'application/pdf' => 'pdf',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.ms-excel' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/vnd.ms-powerpoint' => 'ppt',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'text/plain' => 'txt',
            'text/csv' => 'csv',
            'application/zip' => 'zip',
            'application/x-rar-compressed' => 'rar',
            'application/x-7z-compressed' => '7z',
            'video/mp4' => 'mp4',
            'video/avi' => 'avi',
            'video/quicktime' => 'mov',
            'audio/mpeg' => 'mp3',
            'audio/wav' => 'wav',
            'application/json' => 'json',
            'text/html' => 'html',
            'text/css' => 'css',
            'application/javascript' => 'js',
        ];

        return $mimeToExt[$mimeType] ?? null;
    }

    /**
     * تمیز کردن نام فایل
     */
    private function sanitizeFileName($fileName)
    {
        // حذف کاراکترهای غیرمجاز
        $fileName = preg_replace('/[^\w\s\-\._\(\)\[\]]/u', '', $fileName);

        // حذف فضاهای اضافی
        $fileName = preg_replace('/\s+/', ' ', $fileName);
        $fileName = trim($fileName);

        // اگر نام فایل خالی شد، نام پیش‌فرض بدهیم
        if (empty($fileName)) {
            $fileName = 'file_' . time();
        }

        return $fileName;
    }

    /**
     * نمایش تصویر کوچک
     */
    public function thumbnail($id)
    {
        try {
            $file = FileManager::where('is_folder', false)->findOrFail($id);

            if (!$file->path || !Storage::disk('public')->exists($file->path)) {
                abort(404);
            }

            // بررسی اینکه فایل تصویر است
            if (!str_starts_with($file->mime_type, 'image/')) {
                abort(404);
            }

            $filePath = Storage::disk('public')->path($file->path);

            return response()->file($filePath, [
                'Content-Type' => $file->mime_type,
                'Cache-Control' => 'public, max-age=3600'
            ]);

        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * دریافت محتویات پوشه برای AJAX
     */
    public function getFiles(Request $request, Project $project = null)
    {
        try {
            $currentFolder = $this->getCurrentFolder($request->get('folder'), $project);
            $breadcrumb = $this->getBreadcrumb($currentFolder);
            $contents = $this->getFolderContents($currentFolder, $project);

            return response()->json([
                'success' => true,
                'data' => [
                    'folders' => $contents['folders'],
                    'files' => $contents['files'],
                    'breadcrumb' => $breadcrumb,
                    'currentFolder' => $currentFolder
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در دریافت فایل‌ها: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * دریافت پوشه فعلی
     */
    private function getCurrentFolder($folderId, Project $project = null)
    {
        if (!$folderId) {
            return null;
        }

        $query = FileManager::where('is_folder', true);

        if ($project) {
            $query->where('project_id', $project->id);
        } else {
            $query->whereNull('project_id');
        }

        return $query->find($folderId);
    }

    /**
     * دریافت محتویات پوشه
     */
    private function getFolderContents($currentFolder, Project $project = null)
    {
        $query = FileManager::with(['uploader']);

        if ($project) {
            $query->where('project_id', $project->id);
        } else {
            $query->whereNull('project_id');
        }

        if ($currentFolder) {
            $query->where('parent_id', $currentFolder->id);
        } else {
            $query->whereNull('parent_id');
        }

        $folders = $query->clone()->where('is_folder', true)->orderBy('name')->get();
        $files = $query->clone()->where('is_folder', false)->orderBy('name')->get();

        return [
            'folders' => $folders,
            'files' => $files
        ];
    }

    /**
     * دریافت مسیر breadcrumb
     */
    private function getBreadcrumb($currentFolder)
    {
        if (!$currentFolder) {
            return collect();
        }

        return $currentFolder->getBreadcrumb();
    }

    /**
     * حذف پوشه به صورت بازگشتی
     */
    private function deleteFolderRecursively($folder)
    {
        $children = FileManager::where('parent_id', $folder->id)->get();

        foreach ($children as $child) {
            if ($child->is_folder) {
                $this->deleteFolderRecursively($child);
            } else {
                // حذف فایل فیزیکی
                if ($child->path && Storage::disk('public')->exists($child->path)) {
                    Storage::disk('public')->delete($child->path);
                }
                $child->delete();
            }
        }

        $folder->delete();
    }
}
