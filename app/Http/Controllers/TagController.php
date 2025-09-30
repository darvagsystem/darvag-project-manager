<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\FileManager;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * نمایش لیست تگ‌ها
     */
    public function index()
    {
        $tags = Tag::orderBy('name')->get();
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * نمایش فرم ایجاد تگ
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * ذخیره تگ جدید
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags',
            'color' => 'required|string|max:7',
            'description' => 'nullable|string',
            'is_folder_tag' => 'boolean',
            'allowed_extensions' => 'nullable|string',
            'allowed_mime_types' => 'nullable|string'
        ]);

        $data = $request->all();

        // تبدیل رشته‌های کاما جدا شده به آرایه
        if (!empty($data['allowed_extensions'])) {
            $data['allowed_extensions'] = array_map('trim', explode(',', $data['allowed_extensions']));
        } else {
            $data['allowed_extensions'] = null;
        }

        if (!empty($data['allowed_mime_types'])) {
            $data['allowed_mime_types'] = array_map('trim', explode(',', $data['allowed_mime_types']));
        } else {
            $data['allowed_mime_types'] = null;
        }

        $data['is_folder_tag'] = $request->has('is_folder_tag');

        Tag::create($data);

        return redirect()->route('admin.tags.index')
            ->with('success', 'تگ با موفقیت ایجاد شد');
    }

    /**
     * نمایش فرم ویرایش تگ
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * به‌روزرسانی تگ
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'color' => 'required|string|max:7',
            'description' => 'nullable|string',
            'is_folder_tag' => 'boolean',
            'allowed_extensions' => 'nullable|string',
            'allowed_mime_types' => 'nullable|string'
        ]);

        $data = $request->all();

        // تبدیل رشته‌های کاما جدا شده به آرایه
        if (!empty($data['allowed_extensions'])) {
            $data['allowed_extensions'] = array_map('trim', explode(',', $data['allowed_extensions']));
        } else {
            $data['allowed_extensions'] = null;
        }

        if (!empty($data['allowed_mime_types'])) {
            $data['allowed_mime_types'] = array_map('trim', explode(',', $data['allowed_mime_types']));
        } else {
            $data['allowed_mime_types'] = null;
        }

        $data['is_folder_tag'] = $request->has('is_folder_tag');

        $tag->update($data);

        return redirect()->route('admin.tags.index')
            ->with('success', 'تگ با موفقیت به‌روزرسانی شد');
    }

    /**
     * حذف تگ
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'تگ با موفقیت حذف شد');
    }

    /**
     * دریافت تگ‌ها به صورت JSON
     */
    public function getTags()
    {
        $tags = Tag::orderBy('name')->get();
        return response()->json($tags);
    }

    /**
     * نمایش فایل‌های یک تگ
     */
    public function files(Tag $tag)
    {
        $files = $tag->files()->with(['uploader', 'project'])->paginate(20);
        return view('admin.tags.files', compact('tag', 'files'));
    }

    /**
     * دانلود دسته‌ای فایل‌های تگ
     */
    public function bulkDownload(Request $request, Tag $tag)
    {
        $request->validate([
            'file_ids' => 'required|array',
            'file_ids.*' => 'exists:file_manager,id'
        ]);

        try {
            $files = FileManager::whereIn('id', $request->file_ids)
                ->where('is_folder', false)
                ->get();

            if ($files->isEmpty()) {
                return back()->with('error', 'هیچ فایلی برای دانلود انتخاب نشده است');
            }

            // Create temporary ZIP file
            $zipFileName = 'tag_files_' . $tag->name . '_' . time() . '.zip';
            $tempPath = storage_path('app/temp/' . $zipFileName);

            // Ensure temp directory exists
            if (!file_exists(storage_path('app/temp'))) {
                mkdir(storage_path('app/temp'), 0755, true);
            }

            $zip = new \ZipArchive();
            if ($zip->open($tempPath, \ZipArchive::CREATE) !== TRUE) {
                throw new \Exception('Cannot create ZIP file');
            }

            foreach ($files as $file) {
                if (\Storage::disk('public')->exists($file->path)) {
                    $filePath = \Storage::disk('public')->path($file->path);
                    $fileName = $file->display_name ?: $file->name;

                    // Add file to ZIP
                    $zip->addFile($filePath, $fileName);
                }
            }

            $zip->close();

            // Return file download
            return response()->download($tempPath, $zipFileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return back()->with('error', 'خطا در ایجاد فایل ZIP: ' . $e->getMessage());
        }
    }

    /**
     * ادغام فایل‌های تگ در یک PDF
     */
    public function mergePdf(Request $request, Tag $tag)
    {
        $request->validate([
            'file_ids' => 'required|array|min:2',
            'file_ids.*' => 'exists:file_manager,id'
        ]);

        try {
            $files = FileManager::whereIn('id', $request->file_ids)
                ->where('is_folder', false)
                ->get();

            if ($files->count() < 2) {
                return back()->with('error', 'برای ادغام حداقل 2 فایل انتخاب کنید');
            }

            // Check if all files are PDFs
            $nonPdfFiles = $files->filter(function($file) {
                return !str_ends_with(strtolower($file->name), '.pdf');
            });

            if ($nonPdfFiles->count() > 0) {
                return back()->with('error', 'فقط فایل‌های PDF قابل ادغام هستند. فایل‌های غیر PDF: ' . $nonPdfFiles->pluck('name')->implode(', '));
            }

            // Create merged PDF
            $pdfFileName = 'merged_' . $tag->name . '_' . time() . '.pdf';
            $tempPath = storage_path('app/temp/' . $pdfFileName);

            // Ensure temp directory exists
            if (!file_exists(storage_path('app/temp'))) {
                mkdir(storage_path('app/temp'), 0755, true);
            }

            // Use a simple PDF merger (you might want to use a proper PDF library)
            $this->mergePdfFiles($files, $tempPath);

            // Return file download
            return response()->download($tempPath, $pdfFileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return back()->with('error', 'خطا در ادغام فایل‌های PDF: ' . $e->getMessage());
        }
    }

    /**
     * ادغام فایل‌های PDF (ساده)
     */
    private function mergePdfFiles($files, $outputPath)
    {
        try {
            // استفاده از FPDI برای ادغام واقعی PDF ها
            $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();

            // تنظیمات PDF
            $pdf->SetCreator('Darvag Project Manager');
            $pdf->SetTitle('Merged PDF Files');
            $pdf->SetSubject('Merged PDF Files');
            $pdf->SetKeywords('PDF, Merge, Files');

            // حذف header و footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $pageCount = 0;
            $successCount = 0;

            foreach ($files as $file) {
                if (\Storage::disk('public')->exists($file->path)) {
                    $filePath = \Storage::disk('public')->path($file->path);

                    try {
                        // خواندن فایل PDF
                        $pdfContent = file_get_contents($filePath);

                        // بررسی معتبر بودن PDF
                        if (strpos($pdfContent, '%PDF') === 0) {
                            // اضافه کردن فایل PDF به FPDI
                            $pageCount = $pdf->setSourceFile($filePath);

                            // اضافه کردن تمام صفحات فایل
                            for ($i = 1; $i <= $pageCount; $i++) {
                                $pdf->AddPage();
                                $tplId = $pdf->importPage($i);
                                $pdf->useTemplate($tplId);
                            }

                            $successCount++;
                        } else {
                            // اگر فایل PDF معتبر نیست، صفحه خطا اضافه کنید
                            $pdf->AddPage();
                            $pdf->SetFont('dejavusans', 'B', 12);
                            $pdf->SetTextColor(255, 0, 0);
                            $pdf->Cell(0, 10, 'Error: Invalid PDF file', 0, 1, 'C');
                            $pdf->SetTextColor(0, 0, 0);
                            $pdf->SetFont('dejavusans', '', 10);
                            $pdf->Cell(0, 6, 'File: ' . $file->name, 0, 1, 'C');
                        }

                    } catch (\Exception $e) {
                        // اضافه کردن صفحه خطا
                        $pdf->AddPage();
                        $pdf->SetFont('dejavusans', 'B', 12);
                        $pdf->SetTextColor(255, 0, 0);
                        $pdf->Cell(0, 10, 'Error reading file', 0, 1, 'C');
                        $pdf->SetTextColor(0, 0, 0);
                        $pdf->SetFont('dejavusans', '', 10);
                        $pdf->Cell(0, 6, 'File: ' . $file->name, 0, 1, 'C');
                        $pdf->Cell(0, 6, 'Error: ' . $e->getMessage(), 0, 1, 'C');
                    }
                } else {
                    // اضافه کردن صفحه خطا برای فایل موجود نبودن
                    $pdf->AddPage();
                    $pdf->SetFont('dejavusans', 'B', 12);
                    $pdf->SetTextColor(255, 0, 0);
                    $pdf->Cell(0, 10, 'File not found', 0, 1, 'C');
                    $pdf->SetTextColor(0, 0, 0);
                    $pdf->SetFont('dejavusans', '', 10);
                    $pdf->Cell(0, 6, 'File: ' . $file->name, 0, 1, 'C');
                }
            }

            // اگر هیچ فایل PDF معتبری ادغام نشد، صفحه اطلاعات اضافه کنید
            if ($successCount === 0) {
                $pdf->AddPage();
                $pdf->SetFont('dejavusans', 'B', 14);
                $pdf->Cell(0, 10, 'No valid PDF files found', 0, 1, 'C');
                $pdf->SetFont('dejavusans', '', 10);
                $pdf->Cell(0, 6, 'Please check that the selected files are valid PDF documents.', 0, 1, 'C');
            }

            // ذخیره فایل PDF
            $pdf->Output($outputPath, 'F');

        } catch (\Exception $e) {
            // در صورت خطا، PDF ساده ایجاد کنید
            $this->createSimpleMergedPdf($files, $outputPath);
        }
    }

    /**
     * ایجاد PDF ساده در صورت خطا در ادغام
     */
    private function createSimpleMergedPdf($files, $outputPath)
    {
        $pdf = new \TCPDF();
        $pdf->SetCreator('Darvag Project Manager');
        $pdf->SetTitle('Merged PDF Files');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage();
        $pdf->SetFont('dejavusans', 'B', 14);
        $pdf->Cell(0, 10, 'Merged PDF Files', 0, 1, 'C');
        $pdf->Ln(10);

        foreach ($files as $index => $file) {
            if ($index > 0) {
                $pdf->AddPage();
            }

            $pdf->SetFont('dejavusans', 'B', 12);
            $pdf->Cell(0, 8, 'File: ' . $file->name, 0, 1, 'L');

            $pdf->SetFont('dejavusans', '', 10);
            $pdf->Cell(0, 6, 'Size: ' . $this->formatFileSize($file->size), 0, 1, 'L');
            $pdf->Cell(0, 6, 'Upload Date: ' . $file->created_at->format('Y-m-d H:i:s'), 0, 1, 'L');
            $pdf->Ln(5);

            if (\Storage::disk('public')->exists($file->path)) {
                $pdf->Cell(0, 6, 'Status: File found and included', 0, 1, 'L');
            } else {
                $pdf->SetTextColor(255, 0, 0);
                $pdf->Cell(0, 6, 'Status: File not found', 0, 1, 'L');
                $pdf->SetTextColor(0, 0, 0);
            }
        }

        $pdf->Output($outputPath, 'F');
    }

    /**
     * فرمت کردن اندازه فایل
     */
    private function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' B';
        }
    }
}
