<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeBankAccount;
use App\Models\Bank;
use Illuminate\Support\Facades\DB;

class EmployeeReportController extends Controller
{
    /**
     * Display reports index page
     */
    public function index()
    {
        try {
            $banks = Bank::active()->get();
            $totalEmployees = Employee::count();
            $employeesWithBankAccounts = Employee::whereHas('bankAccounts')->count();

            return view('admin.employees.reports.index', compact('banks', 'totalEmployees', 'employeesWithBankAccounts'));
        } catch (\Exception $e) {
            return 'Error in index method: ' . $e->getMessage();
        }
    }

    /**
     * Generate employees list report
     */
    public function employeesList(Request $request)
    {
        $query = Employee::with(['bankAccounts.bank']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('has_bank_account')) {
            if ($request->has_bank_account == 'yes') {
                $query->whereHas('bankAccounts');
            } elseif ($request->has_bank_account == 'no') {
                $query->whereDoesntHave('bankAccounts');
            }
        }

        $employees = $query->orderBy('full_name')->get();

        if ($request->format === 'print') {
            return view('admin.employees.reports.print.employees-list', compact('employees'));
        }

        return view('admin.employees.reports.employees-list', compact('employees'));
    }

    /**
     * Generate employees with bank accounts report
     */
    public function employeesWithBankAccounts(Request $request)
    {
        $query = Employee::with(['bankAccounts.bank'])
            ->whereHas('bankAccounts');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('bank_id')) {
            $query->whereHas('bankAccounts', function($q) use ($request) {
                $q->where('bank_id', $request->bank_id);
            });
        }

        $employees = $query->orderBy('full_name')->get();

        if ($request->format === 'print') {
            return view('admin.employees.reports.print.employees-with-bank-accounts', compact('employees'));
        }

        return view('admin.employees.reports.employees-with-bank-accounts', compact('employees'));
    }

    /**
     * Generate bank-specific employees report
     */
    public function bankEmployees(Request $request)
    {
        $bankId = $request->bank_id;
        $bank = Bank::findOrFail($bankId);

        $query = Employee::with(['bankAccounts' => function($q) use ($bankId) {
            $q->where('bank_id', $bankId)->with('bank');
        }])
        ->whereHas('bankAccounts', function($q) use ($bankId) {
            $q->where('bank_id', $bankId);
        });

        // Apply additional filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $employees = $query->orderBy('full_name')->get();

        if ($request->format === 'print') {
            return view('admin.employees.reports.print.bank-employees', compact('employees', 'bank'));
        }

        return view('admin.employees.reports.bank-employees', compact('employees', 'bank'));
    }

    /**
     * Generate bank accounts summary report
     */
    public function bankAccountsSummary(Request $request)
    {
        $query = EmployeeBankAccount::with(['employee', 'bank']);

        // Apply filters
        if ($request->filled('bank_id')) {
            $query->where('bank_id', $request->bank_id);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->filled('is_default')) {
            $query->where('is_default', $request->is_default);
        }

        $bankAccounts = $query->orderBy('created_at', 'desc')->get();

        // Group by bank
        $groupedByBank = $bankAccounts->groupBy('bank.name');

        if ($request->format === 'print') {
            return view('admin.employees.reports.print.bank-accounts-summary', compact('bankAccounts', 'groupedByBank'));
        }

        return view('admin.employees.reports.bank-accounts-summary', compact('bankAccounts', 'groupedByBank'));
    }

    /**
     * Generate detailed employee report
     */
    public function employeeDetail(Request $request, $employeeId)
    {
        $employee = Employee::with(['bankAccounts.bank'])->findOrFail($employeeId);

        if ($request->format === 'print') {
            return view('admin.employees.reports.print.employee-detail', compact('employee'));
        }

        return view('admin.employees.reports.employee-detail', compact('employee'));
    }

    /**
     * Export data to Excel/CSV
     */
    public function export(Request $request)
    {
        $type = $request->type;
        $format = $request->format ?? 'excel';

        switch ($type) {
            case 'employees_list':
                return $this->exportEmployeesList($request, $format);
            case 'employees_with_bank_accounts':
                return $this->exportEmployeesWithBankAccounts($request, $format);
            case 'bank_employees':
                return $this->exportBankEmployees($request, $format);
            case 'bank_accounts_summary':
                return $this->exportBankAccountsSummary($request, $format);
            default:
                return redirect()->back()->with('error', 'نوع گزارش نامعتبر است');
        }
    }

    /**
     * Export employees list
     */
    private function exportEmployeesList(Request $request, $format)
    {
        $query = Employee::with(['bankAccounts.bank']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('has_bank_account')) {
            if ($request->has_bank_account == 'yes') {
                $query->whereHas('bankAccounts');
            } elseif ($request->has_bank_account == 'no') {
                $query->whereDoesntHave('bankAccounts');
            }
        }

        $employees = $query->orderBy('full_name')->get();

        if ($format === 'csv') {
            return $this->exportToCsv($employees, 'employees_list');
        }

        // For now, return JSON (you can implement Excel export later)
        return response()->json($employees);
    }

    /**
     * Export employees with bank accounts
     */
    private function exportEmployeesWithBankAccounts(Request $request, $format)
    {
        $query = Employee::with(['bankAccounts.bank'])
            ->whereHas('bankAccounts');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('bank_id')) {
            $query->whereHas('bankAccounts', function($q) use ($request) {
                $q->where('bank_id', $request->bank_id);
            });
        }

        $employees = $query->orderBy('full_name')->get();

        if ($format === 'csv') {
            return $this->exportToCsv($employees, 'employees_with_bank_accounts');
        }

        return response()->json($employees);
    }

    /**
     * Export bank employees
     */
    private function exportBankEmployees(Request $request, $format)
    {
        $bankId = $request->bank_id;
        $bank = Bank::findOrFail($bankId);

        $query = Employee::with(['bankAccounts' => function($q) use ($bankId) {
            $q->where('bank_id', $bankId)->with('bank');
        }])
        ->whereHas('bankAccounts', function($q) use ($bankId) {
            $q->where('bank_id', $bankId);
        });

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $employees = $query->orderBy('full_name')->get();

        if ($format === 'csv') {
            return $this->exportToCsv($employees, 'bank_employees_' . $bank->name);
        }

        return response()->json($employees);
    }

    /**
     * Export bank accounts summary
     */
    private function exportBankAccountsSummary(Request $request, $format)
    {
        $query = EmployeeBankAccount::with(['employee', 'bank']);

        if ($request->filled('bank_id')) {
            $query->where('bank_id', $request->bank_id);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->filled('is_default')) {
            $query->where('is_default', $request->is_default);
        }

        $bankAccounts = $query->orderBy('created_at', 'desc')->get();

        if ($format === 'csv') {
            return $this->exportToCsv($bankAccounts, 'bank_accounts_summary');
        }

        return response()->json($bankAccounts);
    }

    /**
     * Export data to CSV
     */
    private function exportToCsv($data, $filename)
    {
        $filename = $filename . '_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fwrite($file, "\xEF\xBB\xBF");

            // Add headers based on data type
            if ($data->first() instanceof Employee) {
                fputcsv($file, [
                    'نام کامل',
                    'کد پرسنلی',
                    'کد ملی',
                    'وضعیت',
                    'بخش',
                    'تاریخ استخدام',
                    'تعداد حساب‌های بانکی',
                    'حساب‌های بانکی'
                ]);

                foreach ($data as $employee) {
                    $bankAccounts = $employee->bankAccounts->pluck('bank.name')->implode(', ');
                    fputcsv($file, [
                        $employee->full_name,
                        $employee->employee_code,
                        $employee->national_code,
                        $employee->formatted_status,
                        $employee->department,
                        $employee->hire_date,
                        $employee->bankAccounts->count(),
                        $bankAccounts
                    ]);
                }
            } elseif ($data->first() instanceof EmployeeBankAccount) {
                fputcsv($file, [
                    'نام کارمند',
                    'کد پرسنلی',
                    'نام بانک',
                    'نام صاحب حساب',
                    'شماره حساب',
                    'شماره کارت',
                    'شماره شبا',
                    'وضعیت',
                    'حساب اصلی',
                    'تاریخ ایجاد'
                ]);

                foreach ($data as $account) {
                    fputcsv($file, [
                        $account->employee->full_name,
                        $account->employee->employee_code,
                        $account->bank->name,
                        $account->account_holder_name,
                        $account->account_number,
                        $account->card_number,
                        $account->iban,
                        $account->is_active ? 'فعال' : 'غیرفعال',
                        $account->is_default ? 'بله' : 'خیر',
                        $account->created_at->format('Y-m-d H:i:s')
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
