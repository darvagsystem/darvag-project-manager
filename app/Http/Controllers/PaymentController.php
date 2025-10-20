<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentRecipient;
use App\Models\PaymentType;
use App\Models\Project;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request, Project $project)
    {
        $query = $project->payments()->with(['recipient', 'creator', 'receipts']);

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }
        if ($request->filled('recipient_type')) {
            $query->whereHas('recipient', function($q) use ($request) {
                $q->where('type', $request->recipient_type);
            });
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('payment_date', [$request->start_date, $request->end_date]);
        }

        $payments = $query->orderBy('payment_date', 'desc')->paginate(20);

        // Debug: Log payments data (remove in production)
        // \Log::info('Payments data', [
        //     'count' => $payments->count(),
        //     'total' => $payments->total(),
        //     'first_payment' => $payments->first() ? $payments->first()->toArray() : null
        // ]);

        // Statistics
        $totalAmount = $project->payments()->sum('amount');
        $completedAmount = $project->payments()->where('status', 'completed')->sum('amount');
        $pendingAmount = $project->payments()->where('status', 'pending')->sum('amount');

        $statistics = [
            'total_payments' => $project->payments()->count(),
            'total_amount' => $totalAmount,
            'completed_amount' => $completedAmount,
            'pending_amount' => $pendingAmount,
            'completed_count' => $project->payments()->where('status', 'completed')->count(),
            'pending_count' => $project->payments()->where('status', 'pending')->count(),
        ];

        return view('admin.projects.payments.index', compact('project', 'payments', 'statistics'));
    }

    public function create(Project $project)
    {
        $recipients = PaymentRecipient::active()->get();
        $paymentTypes = PaymentType::getActiveTypes();
        $employees = Employee::whereHas('projectEmployees', function($query) use ($project) {
            $query->where('project_id', $project->id)->where('is_active', true);
        })->with('bankAccounts')->get();

        return view('admin.projects.payments.create', compact('project', 'recipients', 'paymentTypes', 'employees'));
    }

    public function store(Request $request, Project $project)
    {
        // Debug: Log request data (remove in production)
        // \Log::info('Payment form submitted', $request->all());

        try {
            $request->validate([
                'recipient_id' => 'required|exists:payment_recipients,id',
                'payment_type_id' => 'required|exists:payment_types,id',
                'amount' => 'required|numeric|min:0',
                'currency' => 'required|string|max:3',
                'payment_method' => 'required|string',
                'description' => 'nullable|string',
                'payment_date' => 'required|string',
                'reference_number' => 'nullable|string',
                'notes' => 'nullable|string',
                'receipts.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        }

        // Convert Persian date to Gregorian
        $persianDate = $request->payment_date;
        try {
            $gregorianDate = \Morilog\Jalali\Jalalian::fromFormat('Y/m/d', $persianDate)->toCarbon()->format('Y-m-d');
            // \Log::info('Date conversion successful', ['persian' => $persianDate, 'gregorian' => $gregorianDate]);
        } catch (\Exception $e) {
            \Log::error('Date conversion failed', ['persian' => $persianDate, 'error' => $e->getMessage()]);
            return back()->with('error', 'فرمت تاریخ صحیح نیست. لطفاً تاریخ را به فرمت 1403/01/01 وارد کنید.')->withInput();
        }

        DB::beginTransaction();
        try {
            // Get payment type name for the old field
            $paymentType = \App\Models\PaymentType::find($request->payment_type_id);

            $payment = $project->payments()->create([
                'recipient_id' => $request->recipient_id,
                'payment_type_id' => $request->payment_type_id,
                'payment_type' => $paymentType ? $paymentType->name : null, // For backward compatibility
                'amount' => $request->amount,
                'currency' => $request->currency,
                'payment_method' => $request->payment_method,
                'description' => $request->description,
                'payment_date' => $gregorianDate,
                'reference_number' => $request->reference_number,
                'notes' => $request->notes,
                'created_by' => auth()->id(),
            ]);

            // \Log::info('Payment created successfully', ['payment_id' => $payment->id]);

            // Handle receipt uploads
            if ($request->hasFile('receipts')) {
                foreach ($request->file('receipts') as $file) {
                    $path = $file->store('payment-receipts', 'public');

                    $payment->receipts()->create([
                        'receipt_type' => $this->getReceiptType($file->getMimeType()),
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'file_size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('panel.projects.payments.index', $project)
                ->with('success', 'پرداخت با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'خطا در ثبت پرداخت: ' . $e->getMessage());
        }
    }

    public function show(Project $project, Payment $payment)
    {
        $payment->load(['recipient', 'creator', 'receipts.verifier']);
        return view('admin.projects.payments.show', compact('project', 'payment'));
    }

    public function edit(Project $project, Payment $payment)
    {
        $recipients = PaymentRecipient::active()->get();
        return view('admin.projects.payments.edit', compact('project', 'payment', 'recipients'));
    }

    public function update(Request $request, Project $project, Payment $payment)
    {
        $request->validate([
            'recipient_id' => 'required|exists:payment_recipients,id',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'payment_method' => 'required|string',
            'payment_type' => 'required|string',
            'description' => 'nullable|string',
            'payment_date' => 'required|date',
            'reference_number' => 'nullable|string',
            'status' => 'required|in:pending,completed,failed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $payment->update($request->all());

        return redirect()->route('panel.projects.payments.index', $project)
            ->with('success', 'پرداخت با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(Project $project, Payment $payment)
    {
        // Delete receipts files
        foreach ($payment->receipts as $receipt) {
            Storage::disk('public')->delete($receipt->file_path);
        }

        $payment->delete();

        return redirect()->route('panel.projects.payments.index', $project)
            ->with('success', 'پرداخت با موفقیت حذف شد.');
    }

    public function updateStatus(Request $request, Project $project, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,failed,cancelled'
        ]);

        $payment->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'وضعیت پرداخت به‌روزرسانی شد.',
            'status_text' => $payment->status_text,
            'status_color' => $payment->status_color
        ]);
    }

    private function getReceiptType($mimeType)
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        } elseif ($mimeType === 'application/pdf') {
            return 'pdf';
        } else {
            return 'document';
        }
    }
}
