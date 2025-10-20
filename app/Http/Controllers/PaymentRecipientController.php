<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentRecipient;
use App\Models\Employee;
use App\Models\EmployeeBankAccount;

class PaymentRecipientController extends Controller
{
    public function index()
    {
        $recipients = PaymentRecipient::with('payments')->paginate(20);
        return view('admin.payment-recipients.index', compact('recipients'));
    }

    public function create()
    {
        $employees = Employee::with('bankAccounts')->get();
        return view('admin.payment-recipients.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:employee,contractor,supplier',
            'recipient_id' => 'required|integer',
            'recipient_name' => 'required|string|max:255',
            'recipient_code' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'iban' => 'nullable|string|max:34',
            'card_number' => 'nullable|string|max:20',
        ]);

        // Check if recipient already exists
        $existing = PaymentRecipient::where('type', $request->type)
            ->where('recipient_id', $request->recipient_id)
            ->first();

        if ($existing) {
            return back()->with('error', 'این دریافت‌کننده قبلاً ثبت شده است.');
        }

        PaymentRecipient::create($request->all());

        return redirect()->route('panel.payment-recipients.index')
            ->with('success', 'دریافت‌کننده با موفقیت ثبت شد.');
    }

    public function show(PaymentRecipient $paymentRecipient)
    {
        $paymentRecipient->load(['payments.project', 'payments.creator']);
        return view('admin.payment-recipients.show', compact('paymentRecipient'));
    }

    public function edit(PaymentRecipient $paymentRecipient)
    {
        $employees = Employee::with('bankAccounts')->get();
        return view('admin.payment-recipients.edit', compact('paymentRecipient', 'employees'));
    }

    public function update(Request $request, PaymentRecipient $paymentRecipient)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_code' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'iban' => 'nullable|string|max:34',
            'card_number' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $paymentRecipient->update($request->all());

        return redirect()->route('panel.payment-recipients.index')
            ->with('success', 'دریافت‌کننده با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(PaymentRecipient $paymentRecipient)
    {
        if ($paymentRecipient->payments()->count() > 0) {
            return back()->with('error', 'نمی‌توان این دریافت‌کننده را حذف کرد زیرا دارای پرداخت است.');
        }

        $paymentRecipient->delete();

        return redirect()->route('panel.payment-recipients.index')
            ->with('success', 'دریافت‌کننده با موفقیت حذف شد.');
    }

    public function createFromEmployee(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'bank_account_id' => 'nullable|exists:employee_bank_accounts,id'
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        $bankAccount = $request->bank_account_id ?
            EmployeeBankAccount::findOrFail($request->bank_account_id) : null;

        // Check if already exists
        $existing = PaymentRecipient::where('type', 'employee')
            ->where('recipient_id', $employee->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'این پرسنل قبلاً به عنوان دریافت‌کننده ثبت شده است.');
        }

        PaymentRecipient::createFromEmployee($employee, $bankAccount);

        return back()->with('success', 'پرسنل به عنوان دریافت‌کننده ثبت شد.');
    }

    public function getBankAccounts(PaymentRecipient $recipient)
    {
        if ($recipient->type === 'employee') {
            $bankAccounts = EmployeeBankAccount::where('employee_id', $recipient->recipient_id)->get();
            return response()->json([
                'success' => true,
                'bank_accounts' => $bankAccounts
            ]);
        }

        return response()->json([
            'success' => true,
            'bank_accounts' => []
        ]);
    }
}
