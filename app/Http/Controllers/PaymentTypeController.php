<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentType;
use Illuminate\Support\Facades\DB;

class PaymentTypeController extends Controller
{
    public function index(Request $request)
    {
        $project = $request->route('project');
        $paymentTypes = PaymentType::ordered()->paginate(20);
        return view('admin.projects.settings.payment-types-index', compact('paymentTypes', 'project'));
    }

    public function create(Request $request)
    {
        $project = $request->route('project');
        return view('admin.projects.settings.payment-types-create', compact('project'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_types,code',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'color' => 'required|string|max:7',
            'requires_receipt' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['requires_receipt'] = $request->has('requires_receipt');

        PaymentType::create($data);

        $project = $request->route('project');
        return redirect()->route('panel.projects.settings.payment-types.index', $project)
            ->with('success', 'نوع پرداخت با موفقیت ثبت شد.');
    }

    public function show(Request $request, PaymentType $paymentType)
    {
        $project = $request->route('project');
        $paymentType->load(['payments.project', 'payments.recipient']);
        return view('admin.projects.settings.payment-types-show', compact('paymentType', 'project'));
    }

    public function edit(Request $request, PaymentType $paymentType)
    {
        $project = $request->route('project');
        return view('admin.projects.settings.payment-types-edit', compact('paymentType', 'project'));
    }

    public function update(Request $request, PaymentType $paymentType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_types,code,' . $paymentType->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'color' => 'required|string|max:7',
            'is_active' => 'boolean',
            'requires_receipt' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['requires_receipt'] = $request->has('requires_receipt');

        $paymentType->update($data);

        $project = $request->route('project');
        return redirect()->route('panel.projects.settings.payment-types.index', $project)
            ->with('success', 'نوع پرداخت با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(Request $request, PaymentType $paymentType)
    {
        if ($paymentType->payments()->count() > 0) {
            return back()->with('error', 'نمی‌توان این نوع پرداخت را حذف کرد زیرا دارای پرداخت است.');
        }

        $paymentType->delete();

        $project = $request->route('project');
        return redirect()->route('panel.projects.settings.payment-types.index', $project)
            ->with('success', 'نوع پرداخت با موفقیت حذف شد.');
    }

    public function toggleStatus(Request $request, PaymentType $paymentType)
    {
        $request->validate([
            'is_active' => 'required|boolean'
        ]);

        $paymentType->update(['is_active' => $request->is_active]);

        $status = $paymentType->is_active ? 'فعال' : 'غیرفعال';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "نوع پرداخت {$paymentType->name} {$status} شد.",
                'is_active' => $paymentType->is_active
            ]);
        }

        return back()->with('success', "نوع پرداخت {$paymentType->name} {$status} شد.");
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'types' => 'required|array',
            'types.*.id' => 'required|exists:payment_types,id',
            'types.*.sort_order' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->types as $type) {
                PaymentType::where('id', $type['id'])
                    ->update(['sort_order' => $type['sort_order']]);
            }
        });

        return response()->json(['success' => true, 'message' => 'ترتیب با موفقیت به‌روزرسانی شد.']);
    }
}
