<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeBankAccount;
use App\Models\Bank;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\DB;

class EmployeeBankAccountController extends Controller
{
    /**
     * Display employee bank accounts
     */
    public function index(Employee $employee)
    {
        $bankAccounts = EmployeeBankAccount::where('employee_id', $employee->id)
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


            $bankAccount = EmployeeBankAccount::create($data);

            // Log the activity
            ActivityLogService::logActivity('bank_account_created', [
                'employee_id' => $bankAccount->employee_id,
                'employee_name' => $bankAccount->employee->full_name,
                'bank_account_id' => $bankAccount->id,
                'bank_name' => $bankAccount->bank->name,
                'account_holder' => $bankAccount->account_holder_name,
                'is_default' => $bankAccount->is_default
            ]);

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
                'iban' => 'nullable|string|max:26',
                'card_number' => 'nullable|string|max:19',
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

            // Clean IBAN format if provided
            if (!empty($data['iban'])) {
                $data['iban'] = strtoupper(str_replace(' ', '', $data['iban']));
            }

            // Clean card number if provided
            if (!empty($data['card_number'])) {
                $data['card_number'] = str_replace([' ', '-'], '', $data['card_number']);
            }

            $bankAccount->update($data);

            DB::commit();

            // Always return JSON for AJAX requests
            return response()->json([
                'success' => true,
                'message' => 'حساب بانکی با موفقیت به‌روزرسانی شد'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Bank account update error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطا در به‌روزرسانی اطلاعات: ' . $e->getMessage()
            ], 500);
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

            return redirect()->route('panel.employees.bank-accounts', $employeeId)
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
     * Show edit form for bank account
     */
    public function edit($id)
    {
        try {
            $bankAccount = EmployeeBankAccount::with('bank')->findOrFail($id);
            $employee = $bankAccount->employee;
            $banks = Bank::active()->get();

            return view('admin.employees.bank-accounts-edit', compact('bankAccount', 'employee', 'banks'));

        } catch (\Exception $e) {
            \Log::error('Bank account edit error: ' . $e->getMessage());
            return redirect()->route('panel.employees.index')
                           ->with('error', 'حساب بانکی یافت نشد');
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

    /**
     * دریافت اطلاعات بانک از شماره کارت
     */
    public function getBankInfoFromCard(Request $request)
    {
        try {
            $request->validate([
                'card_number' => 'required|string|min:16|max:19'
            ]);

            $cardNumber = preg_replace('/[^0-9]/', '', $request->input('card_number'));

            // استفاده از CardToIbanController موجود
            $cardToIbanController = new \App\Http\Controllers\CardToIbanController();
            $result = $cardToIbanController->convert($request);

            // Get the data from the response
            $data = $result->getData(true);

            if ($data['success']) {
                // تبدیل پاسخ به فرمت مورد نیاز
                $bankData = $data['data'];

                // پیدا کردن بانک بر اساس کد بانک
                $bank = Bank::where('code', $bankData['bank_code'])->first();

                return response()->json([
                    'success' => true,
                    'data' => [
                        'card_number' => $bankData['card_number'],
                        'iban' => $bankData['iban'],
                        'account_holder_name' => $bankData['owner'],
                        'bank_name' => $bankData['bank_name'],
                        'bank_id' => $bank ? $bank->id : null,
                        'bank_code' => $bankData['bank_code']
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $data['message'] ?? 'خطا در دریافت اطلاعات'
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('getBankInfoFromCard error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'خطا در دریافت اطلاعات: ' . $e->getMessage()
            ], 500);
        }
    }
}
