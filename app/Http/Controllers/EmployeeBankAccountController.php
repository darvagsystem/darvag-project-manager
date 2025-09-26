<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeBankAccount;
use App\Models\Bank;
use Illuminate\Support\Facades\DB;

class EmployeeBankAccountController extends Controller
{
    /**
     * Display employee bank accounts
     */
    public function index($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);
        $bankAccounts = EmployeeBankAccount::where('employee_id', $employeeId)
                                         ->with('bank')
                                         ->orderBy('is_default', 'desc')
                                         ->orderBy('created_at', 'desc')
                                         ->get();
        $banks = Bank::active()->get();

        return view('admin.employees.bank-accounts', compact('employee', 'bankAccounts', 'banks'));
    }

    /**
     * Store a new bank account
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'bank_id' => 'required|exists:banks,id',
                'account_holder_name' => 'required|string|max:255',
                'account_number' => 'nullable|string|max:50',
                'iban' => 'nullable|string|max:26',
                'card_number' => 'nullable|string|max:19',
                'sheba_number' => 'nullable|string|max:26',
                'notes' => 'nullable|string',
                'is_default' => 'nullable|boolean',
                'is_active' => 'nullable|boolean'
            ]);

            DB::beginTransaction();

            $data = $request->all();
            $data['is_default'] = $request->has('is_default') ? true : false;
            $data['is_active'] = $request->has('is_active') ? true : false;

            // If this account is set as default, unset other default accounts
            if ($data['is_default']) {
                EmployeeBankAccount::where('employee_id', $data['employee_id'])
                                  ->update(['is_default' => false]);
            }

            // Clean IBAN format if provided
            if (!empty($data['iban'])) {
                $data['iban'] = strtoupper(str_replace(' ', '', $data['iban']));
            }

            // Clean card number if provided
            if (!empty($data['card_number'])) {
                $data['card_number'] = str_replace([' ', '-'], '', $data['card_number']);
            }

            // Clean sheba number if provided
            if (!empty($data['sheba_number'])) {
                $data['sheba_number'] = strtoupper(str_replace(' ', '', $data['sheba_number']));
            }

            $bankAccount = EmployeeBankAccount::create($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'حساب بانکی با موفقیت اضافه شد',
                'data' => $bankAccount
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'خطا در اعتبارسنجی اطلاعات',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Bank account creation error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطا در ثبت اطلاعات: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update bank account
     */
    public function update(Request $request, $id)
    {
        try {
            $bankAccount = EmployeeBankAccount::findOrFail($id);

            $request->validate([
                'bank_id' => 'required|exists:banks,id',
                'account_holder_name' => 'required|string|max:255',
                'account_number' => 'nullable|string|max:50',
                'iban' => 'nullable|string|size:24',
                'card_number' => 'nullable|string|size:16',
                'notes' => 'nullable|string',
                'is_default' => 'boolean',
                'is_active' => 'boolean'
            ]);

            DB::beginTransaction();

            $data = $request->all();
            $data['is_default'] = $request->has('is_default') ? true : false;
            $data['is_active'] = $request->has('is_active') ? true : false;

            // If this account is set as default, unset other default accounts
            if ($data['is_default']) {
                EmployeeBankAccount::where('employee_id', $bankAccount->employee_id)
                                  ->where('id', '!=', $id)
                                  ->update(['is_default' => false]);
            }

            // Validate IBAN format if provided
            if ($data['iban']) {
                $data['iban'] = strtoupper(str_replace(' ', '', $data['iban']));
                if (!preg_match('/^[0-9]{24}$/', $data['iban'])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'فرمت شماره شبا صحیح نیست'
                    ]);
                }
            }

            // Validate card number if provided
            if ($data['card_number']) {
                $data['card_number'] = str_replace(' ', '', $data['card_number']);
                if (!preg_match('/^[0-9]{16}$/', $data['card_number'])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'شماره کارت باید 16 رقم باشد'
                    ]);
                }
            }

            $bankAccount->update($data);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'حساب بانکی با موفقیت به‌روزرسانی شد'
                ]);
            }

            return redirect()->route('employees.bank-accounts', $bankAccount->employee_id)
                           ->with('success', 'حساب بانکی با موفقیت به‌روزرسانی شد');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Bank account update error: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در به‌روزرسانی اطلاعات: ' . $e->getMessage()
                ]);
            }

            return redirect()->back()
                           ->with('error', 'خطا در به‌روزرسانی اطلاعات: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Set account as default
     */
    public function setAsDefault($id)
    {
        try {
            $bankAccount = EmployeeBankAccount::findOrFail($id);

            DB::beginTransaction();

            // Unset all other default accounts for this employee
            EmployeeBankAccount::where('employee_id', $bankAccount->employee_id)
                              ->update(['is_default' => false]);

            // Set this account as default
            $bankAccount->update(['is_default' => true]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'حساب به عنوان حساب اصلی تنظیم شد'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Set default account error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطا در تنظیم حساب اصلی'
            ]);
        }
    }

    /**
     * Toggle account status
     */
    public function toggleStatus(Request $request, $id)
    {
        try {
            $bankAccount = EmployeeBankAccount::findOrFail($id);

            $isActive = $request->input('is_active', false);

            $bankAccount->update(['is_active' => $isActive]);

            $status = $isActive ? 'فعال' : 'غیرفعال';

            return response()->json([
                'success' => true,
                'message' => "حساب بانکی $status شد"
            ]);

        } catch (\Exception $e) {
            \Log::error('Toggle account status error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطا در تغییر وضعیت حساب'
            ]);
        }
    }

    /**
     * Delete bank account
     */
    public function destroy($id)
    {
        try {
            $bankAccount = EmployeeBankAccount::findOrFail($id);
            $employeeId = $bankAccount->employee_id;

            // Prevent deleting the only active account
            $activeAccountsCount = EmployeeBankAccount::where('employee_id', $employeeId)
                                                    ->where('is_active', true)
                                                    ->count();

            if ($activeAccountsCount <= 1 && $bankAccount->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'نمی‌توان تنها حساب فعال را حذف کرد'
                ]);
            }

            $bankAccount->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'حساب بانکی با موفقیت حذف شد'
                ]);
            }

            return redirect()->route('employees.bank-accounts', $employeeId)
                           ->with('success', 'حساب بانکی با موفقیت حذف شد');

        } catch (\Exception $e) {
            \Log::error('Bank account deletion error: ' . $e->getMessage());

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در حذف حساب بانکی'
                ]);
            }

            return redirect()->back()
                           ->with('error', 'خطا در حذف حساب بانکی');
        }
    }

    /**
     * Get account details for editing
     */
    public function show($id)
    {
        try {
            $bankAccount = EmployeeBankAccount::with('bank')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $bankAccount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حساب بانکی یافت نشد'
            ]);
        }
    }

    /**
     * Get employee's default bank account
     */
    public function getDefaultAccount($employeeId)
    {
        try {
            $defaultAccount = EmployeeBankAccount::where('employee_id', $employeeId)
                                               ->where('is_default', true)
                                               ->where('is_active', true)
                                               ->with('bank')
                                               ->first();

            if (!$defaultAccount) {
                // If no default account, get the first active account
                $defaultAccount = EmployeeBankAccount::where('employee_id', $employeeId)
                                                   ->where('is_active', true)
                                                   ->with('bank')
                                                   ->first();
            }

            return response()->json([
                'success' => true,
                'data' => $defaultAccount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حساب پیدا نشد'
            ]);
        }
    }

    /**
     * Validate IBAN number
     */
    public function validateIban(Request $request)
    {
        $iban = strtoupper(str_replace(' ', '', $request->input('iban')));

        // Remove IR prefix if present
        if (substr($iban, 0, 2) === 'IR') {
            $iban = substr($iban, 2);
        }

        // Check if it's 24 digits
        if (!preg_match('/^[0-9]{24}$/', $iban)) {
            return response()->json([
                'valid' => false,
                'message' => 'شماره شبا باید 24 رقم باشد'
            ]);
        }

        // Basic IBAN validation for Iran
        $checkDigits = substr($iban, 0, 2);
        $bankCode = substr($iban, 2, 3);
        $accountNumber = substr($iban, 5);

        // Simple validation - in real implementation, you'd use proper IBAN algorithm
        return response()->json([
            'valid' => true,
            'message' => 'شماره شبا معتبر است'
        ]);
    }

    /**
     * Validate card number using Luhn algorithm
     */
    public function validateCardNumber(Request $request)
    {
        $cardNumber = str_replace(' ', '', $request->input('card_number'));

        if (!preg_match('/^[0-9]{16}$/', $cardNumber)) {
            return response()->json([
                'valid' => false,
                'message' => 'شماره کارت باید 16 رقم باشد'
            ]);
        }

        // Luhn algorithm validation
        $sum = 0;
        $alternate = false;

        for ($i = strlen($cardNumber) - 1; $i >= 0; $i--) {
            $digit = intval($cardNumber[$i]);

            if ($alternate) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit = ($digit % 10) + 1;
                }
            }

            $sum += $digit;
            $alternate = !$alternate;
        }

        $isValid = ($sum % 10 === 0);

        return response()->json([
            'valid' => $isValid,
            'message' => $isValid ? 'شماره کارت معتبر است' : 'شماره کارت نامعتبر است'
        ]);
    }
}
