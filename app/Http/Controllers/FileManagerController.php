<?php

namespace App\Http\Controllers;

use App\Models\FileManager;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FileManagerController extends Controller
{
    /**
     * صفحه آپلود فایل
     */
    public function uploadPage()
    {
        $tags = \App\Models\Tag::all();
        return view('admin.file-manager.upload-page', compact('tags'));
    }

    /**
     * آپلود فایل‌ها از صفحه جداگانه
     */
    public function uploadFiles(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files' => 'required|array',
            'files.*' => 'file|max:204800', // 200MB
            'description' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
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
                    'parent_id' => null,
                    'project_id' => null,
                    'description' => $request->description,
                    'uploaded_by' => auth()->id()
                ]);

                // اضافه کردن تگ‌ها
                if ($request->has('tags') && is_array($request->tags)) {
                    $fileRecord->tags()->attach($request->tags);
                }

                $uploadedFiles[] = $fileRecord->load(['uploader', 'tags']);
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
            'files' => $contents['files']->load('tags'),
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
            'files' => $contents['files']->load('tags'),
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
            'project_id' => 'nullable|exists:projects,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
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

            // اضافه کردن تگ‌ها
            if ($request->has('tags') && is_array($request->tags)) {
                $folder->tags()->attach($request->tags);
            }

            return response()->json([
                'success' => true,
                'message' => 'پوشه با موفقیت ایجاد شد',
                'folder' => $folder->load(['uploader', 'tags'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در ایجاد پوشه: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * آپلود تکه‌ای فایل‌های بزرگ
     */
    public function uploadChunk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file',
            'chunk_index' => 'required|integer|min:0',
            'total_chunks' => 'required|integer|min:1',
            'original_name' => 'required|string|max:255',
            'file_size' => 'required|integer|min:1',
            'mime_type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:file_manager,id',
            'project_id' => 'nullable|exists:projects,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'داده‌های ورودی نامعتبر است',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $chunkIndex = $request->chunk_index;
            $totalChunks = $request->total_chunks;
            $originalName = $request->original_name;
            $fileSize = $request->file_size;
            $mimeType = $request->mime_type;

            // ایجاد نام فایل موقت برای تکه‌ها
            $tempFileName = 'chunk_' . md5($originalName . $fileSize) . '_' . $chunkIndex;
            $tempPath = 'temp-chunks/' . $tempFileName;

            // ذخیره تکه
            $chunk = $request->file('file');
            $chunk->storeAs('temp-chunks', $tempFileName, 'public');

            // اگر آخرین تکه است، فایل کامل را بساز
            if ($chunkIndex == $totalChunks - 1) {
                $finalPath = $this->combineChunks($originalName, $totalChunks, $fileSize, $mimeType, $request);

                if ($finalPath) {
                    return response()->json([
                        'success' => true,
                        'message' => 'فایل با موفقیت آپلود شد',
                        'file_path' => $finalPath
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'خطا در ترکیب تکه‌های فایل'
                    ], 500);
                }
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'تکه آپلود شد',
                    'chunk_index' => $chunkIndex
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در آپلود تکه: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ترکیب تکه‌های فایل
     */
    private function combineChunks($originalName, $totalChunks, $fileSize, $mimeType, $request)
    {
        try {
            $tempDir = storage_path('app/public/temp-chunks');
            $finalPath = 'file-manager/' . time() . '_' . uniqid() . '_' . $originalName;
            $finalFullPath = storage_path('app/public/' . $finalPath);

            // ایجاد دایرکتوری نهایی
            $finalDir = dirname($finalFullPath);
            if (!is_dir($finalDir)) {
                mkdir($finalDir, 0755, true);
            }

            // باز کردن فایل نهایی برای نوشتن
            $finalFile = fopen($finalFullPath, 'wb');
            if (!$finalFile) {
                return false;
            }

            // ترکیب تکه‌ها
            for ($i = 0; $i < $totalChunks; $i++) {
                $chunkFileName = 'chunk_' . md5($originalName . $fileSize) . '_' . $i;
                $chunkPath = $tempDir . '/' . $chunkFileName;

                if (file_exists($chunkPath)) {
                    $chunkData = file_get_contents($chunkPath);
                    fwrite($finalFile, $chunkData);
                    unlink($chunkPath); // حذف تکه بعد از استفاده
                } else {
                    fclose($finalFile);
                    return false;
                }
            }

            fclose($finalFile);

            // بررسی اندازه فایل نهایی
            if (filesize($finalFullPath) !== $fileSize) {
                unlink($finalFullPath);
                return false;
            }

            // ایجاد رکورد در دیتابیس
            $fileRecord = FileManager::create([
                'name' => $originalName,
                'original_name' => $originalName,
                'path' => $finalPath,
                'size' => $fileSize,
                'mime_type' => $mimeType,
                'type' => 'file',
                'is_folder' => false,
                'parent_id' => $request->parent_id,
                'project_id' => $request->project_id,
                'description' => $request->description,
                'uploaded_by' => auth()->id()
            ]);

            // اضافه کردن تگ‌ها
            if ($request->has('tags') && is_array($request->tags)) {
                $fileRecord->tags()->attach($request->tags);
            }

            return $finalPath;

        } catch (\Exception $e) {
            \Log::error('Error combining chunks: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * آپلود فایل‌ها
     */
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files' => 'required|array',
            'files.*' => 'file|max:204800', // 200MB
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:file_manager,id',
            'project_id' => 'nullable|exists:projects,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
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

                // اضافه کردن تگ‌ها
                if ($request->has('tags') && is_array($request->tags)) {
                    $fileRecord->tags()->attach($request->tags);
                }

                $uploadedFiles[] = $fileRecord->load(['uploader', 'tags']);
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
     * تغییر نام فایل یا پوشه (POST)
     */
    public function renamePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:file_managers,id',
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'داده‌های ورودی نامعتبر است',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $item = FileManager::findOrFail($request->id);

            // بررسی تکراری نبودن نام
            $exists = FileManager::where('name', $request->name)
                ->where('parent_id', $item->parent_id)
                ->where('project_id', $item->project_id)
                ->where('is_folder', $item->is_folder)
                ->where('id', '!=', $request->id)
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
     * تغییر نام فایل یا پوشه (PUT)
     */
    public function rename(Request $request, $fileId)
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
            $item = FileManager::findOrFail($fileId);

            // بررسی تکراری نبودن نام
            $exists = FileManager::where('name', $request->name)
                ->where('parent_id', $item->parent_id)
                ->where('project_id', $item->project_id)
                ->where('is_folder', $item->is_folder)
                ->where('id', '!=', $fileId)
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
            'ids.*' => 'exists:file_managers,id'
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
     * دانلود فایل (POST)
     */
    public function downloadPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:file_managers,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'فایل انتخاب شده نامعتبر است'
            ], 422);
        }

        try {
            $file = FileManager::findOrFail($request->id);

            // بررسی اینکه آیا در context پروژه هستیم یا نه
            $project = $request->route('project');

            // بررسی اینکه فایل در context صحیح است
            if ($project && $file->project_id != $project->id) {
                abort(404, 'فایل متعلق به این پروژه نیست');
            }

            if (!$project && $file->project_id !== null) {
                abort(404, 'فایل متعلق به پروژه است');
            }

            // بررسی وجود فایل فیزیکی
            if (!$file->path) {
                abort(404, 'مسیر فایل مشخص نیست');
            }

            // بررسی وجود فایل در storage
            if (!Storage::disk('public')->exists($file->path)) {
                abort(404, 'فایل فیزیکی یافت نشد');
            }

            // به‌روزرسانی آمار دانلود
            try {
                $file->increment('download_count');
                $file->update(['last_accessed_at' => now()]);
            } catch (\Exception $e) {
                // در صورت خطا در به‌روزرسانی آمار، دانلود را ادامه بده
            }

            return Storage::disk('public')->download($file->path, $file->original_name);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در دانلود فایل: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * دانلود فایل (GET)
     */
    public function download(Request $request, $file)
    {
        try {
            // بررسی اینکه آیا در context پروژه هستیم یا نه
            $project = $request->route('project');

            // بررسی اینکه فایل در context صحیح است
            if ($project && $file->project_id != $project->id) {
                abort(404, 'فایل متعلق به این پروژه نیست');
            }

            if (!$project && $file->project_id !== null) {
                abort(404, 'فایل متعلق به پروژه است');
            }

            // بررسی وجود فایل فیزیکی
            if (!$file->path) {
                abort(404, 'مسیر فایل مشخص نیست');
            }

            // بررسی وجود فایل در storage
            if (!Storage::disk('public')->exists($file->path)) {
                abort(404, 'فایل فیزیکی یافت نشد');
            }

            // به‌روزرسانی آمار دانلود
            try {
                $file->increment('download_count');
                $file->update(['last_accessed_at' => now()]);
            } catch (\Exception $e) {
                // در صورت خطا در به‌روزرسانی آمار، دانلود را ادامه بده
            }

            // تعیین نام فایل برای دانلود
            $fileName = $file->original_name ?: $file->name;

            // اضافه کردن پسوند اگر وجود ندارد
            if (!pathinfo($fileName, PATHINFO_EXTENSION) && $file->mime_type) {
                $extension = $this->getExtensionFromMimeType($file->mime_type);
                if ($extension) {
                    $fileName .= '.' . $extension;
                }
            }

            // تمیز کردن نام فایل
            $fileName = $this->sanitizeFileName($fileName);

            // دانلود مستقیم فایل
            return Storage::disk('public')->download($file->path, $fileName, [
                'Content-Type' => $file->mime_type ?: 'application/octet-stream',
            ]);

        } catch (\Exception $e) {
            abort(500, 'خطا در دانلود فایل: ' . $e->getMessage());
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
     * دانلود ساده فایل - بدون پیچیدگی
     */
    public function simpleDownload($id)
    {
        try {
            $file = FileManager::where('is_folder', false)->find($id);

            if (!$file) {
                abort(404, 'فایل یافت نشد');
            }

            if (!$file->path) {
                abort(404, 'مسیر فایل مشخص نیست');
            }

            $fullPath = Storage::disk('public')->path($file->path);

            if (!file_exists($fullPath)) {
                abort(404, 'فایل فیزیکی یافت نشد');
            }

            // به‌روزرسانی آمار دانلود
            try {
                $file->increment('download_count');
                $file->update(['last_accessed_at' => now()]);
            } catch (\Exception $e) {
                // در صورت خطا در به‌روزرسانی آمار، دانلود را ادامه بده
            }

            // تعیین نام فایل برای دانلود
            $fileName = $file->original_name ?: $file->name;

            // اضافه کردن پسوند اگر وجود ندارد
            if (!pathinfo($fileName, PATHINFO_EXTENSION) && $file->mime_type) {
                $extension = $this->getExtensionFromMimeType($file->mime_type);
                if ($extension) {
                    $fileName .= '.' . $extension;
                }
            }

            // تمیز کردن نام فایل
            $fileName = $this->sanitizeFileName($fileName);

            return response()->download($fullPath, $fileName, [
                'Content-Type' => $file->mime_type ?: 'application/octet-stream',
            ]);

        } catch (\Exception $e) {
            abort(500, 'خطا در دانلود فایل: ' . $e->getMessage());
        }
    }

    /**
     * نمایش تصویر کوچک (GET)
     */
    public function thumbnailPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:file_managers,id'
        ]);

        if ($validator->fails()) {
            abort(404);
        }

        try {
            // بررسی اینکه آیا در context پروژه هستیم یا نه
            $project = $request->route('project');

            $query = FileManager::where('is_folder', false)->where('id', $request->id);

            if ($project) {
                $query->where('project_id', $project->id);
            } else {
                $query->whereNull('project_id');
            }

            $file = $query->first();

            if (!$file || !$file->path) {
                abort(404);
            }

            // بررسی اینکه فایل تصویر است
            if (!$file->mime_type || !str_starts_with($file->mime_type, 'image/')) {
                abort(404);
            }

            // بررسی وجود فایل در storage
            if (!Storage::disk('public')->exists($file->path)) {
                abort(404);
            }

            // بازگرداندن تصویر
            return Storage::disk('public')->response($file->path);

        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * نمایش تصویر کوچک (GET)
     */
    public function thumbnail(Request $request, $fileId)
    {
        try {
            // بررسی اینکه آیا در context پروژه هستیم یا نه
            $project = $request->route('project');

            $query = FileManager::where('is_folder', false)->where('id', $fileId);

            if ($project) {
                $query->where('project_id', $project->id);
            } else {
                $query->whereNull('project_id');
            }

            $file = $query->first();

            if (!$file || !$file->path) {
                abort(404);
            }

            // بررسی اینکه فایل تصویر است
            if (!$file->mime_type || !str_starts_with($file->mime_type, 'image/')) {
                abort(404);
            }

            $fullPath = Storage::disk('public')->path($file->path);

            if (!file_exists($fullPath)) {
                abort(404);
            }

            return response()->file($fullPath, [
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
    private function getCurrentFolder($folderId, $project = null)
    {
        if (!$folderId) {
            return null;
        }

        $query = FileManager::where('is_folder', true);

        if ($project) {
            // اگر $project یک string است، آن را به عنوان ID استفاده کن
            $projectId = is_object($project) ? $project->id : $project;
            $query->where('project_id', $projectId);
        } else {
            $query->whereNull('project_id');
        }

        return $query->find($folderId);
    }

    /**
     * دریافت محتویات پوشه
     */
    private function getFolderContents($currentFolder, $project = null)
    {
        $query = FileManager::with(['uploader']);

        if ($project) {
            // اگر $project یک string است، آن را به عنوان ID استفاده کن
            $projectId = is_object($project) ? $project->id : $project;
            $query->where('project_id', $projectId);
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

    /**
     * دریافت تمام تگ‌ها
     */
    public function getTags()
    {
        $tags = Tag::orderBy('name')->get();
        return response()->json($tags);
    }

    /**
     * اضافه کردن تگ به فایل
     */
    public function addTag(Request $request, $fileId)
    {
        $request->validate([
            'tag_id' => 'required|exists:tags,id'
        ]);

        $file = FileManager::findOrFail($fileId);
        $tag = Tag::findOrFail($request->tag_id);

        // بررسی اینکه تگ قبلاً اضافه نشده باشد
        if (!$file->tags()->where('tag_id', $tag->id)->exists()) {
            $file->tags()->attach($tag->id);
        }

        return response()->json([
            'success' => true,
            'message' => 'تگ با موفقیت اضافه شد'
        ]);
    }

    /**
     * حذف تگ از فایل
     */
    public function removeTag(Request $request, $fileId, $tagId)
    {
        $file = FileManager::findOrFail($fileId);
        $file->tags()->detach($tagId);

        return response()->json([
            'success' => true,
            'message' => 'تگ با موفقیت حذف شد'
        ]);
    }

    /**
     * فیلتر فایل‌ها بر اساس تگ
     */
    public function filterByTag(Request $request, $tagId = null)
    {
        $project = $request->route('project');
        // اگر $project یک string است، آن را به Project model تبدیل کن
        if ($project && !is_object($project)) {
            $project = \App\Models\Project::find($project);
        }
        $currentFolder = $this->getCurrentFolder($request->get('folder'), $project);

        // دریافت محتویات پوشه
        $contents = $this->getFolderContents($currentFolder, $project);

        // فیلتر فایل‌ها بر اساس تگ
        if ($tagId) {
            // ابتدا تگ‌ها را load کن
            $contents['files'] = $contents['files']->load('tags');

            // Debug: نمایش تعداد فایل‌ها قبل از فیلتر
            \Log::info('Files before filter: ' . $contents['files']->count());
            \Log::info('Tag ID: ' . $tagId);

            // سپس فیلتر کن
            $contents['files'] = $contents['files']->filter(function($file) use ($tagId) {
                $hasTag = $file->tags->contains('id', $tagId);
                \Log::info('File: ' . $file->name . ' - Has tag: ' . ($hasTag ? 'Yes' : 'No'));
                return $hasTag;
            });

            // Debug: نمایش تعداد فایل‌ها بعد از فیلتر
            \Log::info('Files after filter: ' . $contents['files']->count());

            // در حالت فیلتر، پوشه‌ها را نمایش نده
            $contents['folders'] = collect([]);
        } else {
            $contents['files'] = $contents['files']->load('tags');
        }

        $files = $contents['files'];
        $folders = $contents['folders'];

        return view('admin.file-manager.index', [
            'project' => $project,
            'currentFolder' => $currentFolder,
            'folders' => $folders,
            'files' => $files,
            'breadcrumb' => $this->getBreadcrumb($currentFolder),
            'selectedTag' => $tagId
        ]);
    }
}
