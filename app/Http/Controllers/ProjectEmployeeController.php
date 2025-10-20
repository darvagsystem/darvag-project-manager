<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Employee;
use App\Models\ProjectEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\PersianDateService;

class ProjectEmployeeController extends Controller
{
    /**
     * Display a listing of employees assigned to a project.
     */
    public function index(Project $project)
    {
        $projectEmployees = $project->projectEmployees()
            ->with('employee')
            ->get();

        return view('admin.projects.employees.index', compact('project', 'projectEmployees'));
    }

    /**
     * Show the form for assigning employees to a project.
     */
    public function create(Project $project)
    {
        $assignedEmployeeIds = $project->projectEmployees()->pluck('employee_id')->toArray();
        $availableEmployees = Employee::active()
            ->whereNotIn('id', $assignedEmployeeIds)
            ->get();

        return view('admin.projects.employees.create', compact('project', 'availableEmployees'));
    }

    /**
     * Store a newly assigned employee to a project.
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'salary_type' => 'required|in:monthly,daily',
            'salary_amount_raw' => 'required_if:salary_type,monthly|nullable|numeric|min:0',
            'daily_salary_raw' => 'required_if:salary_type,daily|nullable|numeric|min:0',
            'working_days_per_month' => 'required|integer|min:1|max:31',
            'absence_deduction_rate' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|string',
            'end_date' => 'nullable|string',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Convert Persian dates to Gregorian
        $startDate = null;
        $endDate = null;

        try {
            if ($request->start_date) {
                $startDate = PersianDateService::persianToGregorian($request->start_date);
            }

            if ($request->end_date) {
                $endDate = PersianDateService::persianToGregorian($request->end_date);

                // Validate that end date is after start date
                if ($startDate && $endDate && $endDate <= $startDate) {
                    return back()->withErrors(['end_date' => 'تاریخ پایان باید بعد از تاریخ شروع باشد.']);
                }
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'خطا در فرمت تاریخ: ' . $e->getMessage()]);
        }

        // Check if employee is already assigned to this project
        if ($project->projectEmployees()->where('employee_id', $request->employee_id)->exists()) {
            return back()->withErrors(['employee_id' => 'این کارمند قبلاً به این پروژه اختصاص داده شده است.']);
        }

        DB::beginTransaction();
        try {
            ProjectEmployee::create([
                'project_id' => $project->id,
                'employee_id' => $request->employee_id,
                'salary_type' => $request->salary_type,
                'salary_amount' => $request->salary_amount_raw,
                'daily_salary' => $request->daily_salary_raw,
                'working_days_per_month' => $request->working_days_per_month,
                'absence_deduction_rate' => $request->absence_deduction_rate,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'is_active' => true,
                'notes' => $request->notes
            ]);

            DB::commit();
            return redirect()->route('panel.projects.employees.index', $project)
                ->with('success', 'کارمند با موفقیت به پروژه اختصاص داده شد.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'خطا در اختصاص کارمند: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing a project employee assignment.
     */
    public function edit(Project $project, ProjectEmployee $projectEmployee)
    {
        return view('admin.projects.employees.edit', compact('project', 'projectEmployee'));
    }

    /**
     * Update the specified project employee assignment.
     */
    public function update(Request $request, Project $project, ProjectEmployee $projectEmployee)
    {
        $request->validate([
            'salary_type' => 'required|in:monthly,daily',
            'salary_amount_raw' => 'required_if:salary_type,monthly|nullable|numeric|min:0',
            'daily_salary_raw' => 'required_if:salary_type,daily|nullable|numeric|min:0',
            'working_days_per_month' => 'required|integer|min:1|max:31',
            'absence_deduction_rate' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|string',
            'end_date' => 'nullable|string',
            'is_active' => 'boolean',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Convert Persian dates to Gregorian
        $startDate = null;
        $endDate = null;

        try {
            if ($request->start_date) {
                $startDate = PersianDateService::persianToGregorian($request->start_date);
            }

            if ($request->end_date) {
                $endDate = PersianDateService::persianToGregorian($request->end_date);

                // Validate that end date is after start date
                if ($startDate && $endDate && $endDate <= $startDate) {
                    return back()->withErrors(['end_date' => 'تاریخ پایان باید بعد از تاریخ شروع باشد.']);
                }
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'خطا در فرمت تاریخ: ' . $e->getMessage()]);
        }

        DB::beginTransaction();
        try {
            $projectEmployee->update([
                'salary_type' => $request->salary_type,
                'salary_amount' => $request->salary_amount_raw,
                'daily_salary' => $request->daily_salary_raw,
                'working_days_per_month' => $request->working_days_per_month,
                'absence_deduction_rate' => $request->absence_deduction_rate,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'is_active' => $request->has('is_active'),
                'notes' => $request->notes
            ]);

            DB::commit();
            return redirect()->route('panel.projects.employees.index', $project)
                ->with('success', 'اطلاعات کارمند با موفقیت به‌روزرسانی شد.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'خطا در به‌روزرسانی: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified employee from the project.
     */
    public function destroy(Project $project, ProjectEmployee $projectEmployee)
    {
        DB::beginTransaction();
        try {
            // Delete all attendance records for this employee in this project
            $projectEmployee->attendances()->delete();

            // Delete the project employee assignment
            $projectEmployee->delete();

            DB::commit();
            return redirect()->route('projects.employees.index', $project)
                ->with('success', 'کارمند از پروژه حذف شد.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'خطا در حذف کارمند: ' . $e->getMessage()]);
        }
    }

    /**
     * Toggle the active status of a project employee.
     */
    public function toggleStatus(Project $project, ProjectEmployee $projectEmployee)
    {
        $projectEmployee->update(['is_active' => !$projectEmployee->is_active]);

        $status = $projectEmployee->is_active ? 'فعال' : 'غیرفعال';
        return back()->with('success', "وضعیت کارمند به {$status} تغییر یافت.");
    }

    /**
     * Generate project employees report
     */
    public function report(Project $project)
    {
        $projectEmployees = $project->projectEmployees()
            ->with('employee')
            ->get();

        // Calculate statistics
        $totalEmployees = $projectEmployees->count();
        $activeEmployees = $projectEmployees->where('is_active', true)->count();
        $inactiveEmployees = $projectEmployees->where('is_active', false)->count();

        // Calculate total salaries
        $totalMonthlySalary = $projectEmployees->where('salary_type', 'monthly')->sum('salary_amount');
        $totalDailySalary = $projectEmployees->where('salary_type', 'daily')->sum('daily_salary');
        $totalSalary = $totalMonthlySalary + $totalDailySalary;

        // Group by salary type
        $monthlyEmployees = $projectEmployees->where('salary_type', 'monthly');
        $dailyEmployees = $projectEmployees->where('salary_type', 'daily');

        // Calculate average working days
        $averageWorkingDays = $projectEmployees->avg('working_days_per_month');

        // Calculate average absence deduction rate
        $averageAbsenceDeduction = $projectEmployees->avg('absence_deduction_rate');

        $statistics = [
            'total_employees' => $totalEmployees,
            'active_employees' => $activeEmployees,
            'inactive_employees' => $inactiveEmployees,
            'total_salary' => $totalSalary,
            'total_monthly_salary' => $totalMonthlySalary,
            'total_daily_salary' => $totalDailySalary,
            'average_working_days' => round($averageWorkingDays, 2),
            'average_absence_deduction' => round($averageAbsenceDeduction, 2),
            'monthly_employees_count' => $monthlyEmployees->count(),
            'daily_employees_count' => $dailyEmployees->count(),
        ];

        return view('admin.projects.employees.report', compact(
            'project',
            'projectEmployees',
            'statistics',
            'monthlyEmployees',
            'dailyEmployees'
        ));
    }

    /**
     * Show the form for bulk assigning employees to a project.
     */
    public function bulkCreate(Project $project)
    {
        $assignedEmployeeIds = $project->projectEmployees()->pluck('employee_id')->toArray();
        $availableEmployees = Employee::active()
            ->whereNotIn('id', $assignedEmployeeIds)
            ->orderBy('first_name')
            ->get();

        return view('admin.projects.employees.bulk-create', compact('project', 'availableEmployees'));
    }

    /**
     * Store multiple employees assigned to a project.
     */
    public function bulkStore(Request $request, Project $project)
    {
        $isIndividualMode = $request->has('individual_salary_mode');
        
        if ($isIndividualMode) {
            $request->validate([
                'employee_ids' => 'required|array|min:1',
                'employee_ids.*' => 'exists:employees,id',
                'employee_salary_type.*' => 'required|in:monthly,daily',
                'employee_salary_amount_raw.*' => 'required_if:employee_salary_type.*,monthly|nullable|numeric|min:0',
                'employee_daily_salary_raw.*' => 'required_if:employee_salary_type.*,daily|nullable|numeric|min:0',
                'working_days_per_month' => 'required|integer|min:1|max:31',
                'absence_deduction_rate' => 'required|numeric|min:0|max:100',
                'start_date' => 'required|string',
                'end_date' => 'nullable|string',
                'notes' => 'nullable|string|max:1000',
            ]);
        } else {
            $request->validate([
                'employee_ids' => 'required|array|min:1',
                'employee_ids.*' => 'exists:employees,id',
                'salary_type' => 'required|in:monthly,daily',
                'salary_amount_raw' => 'required_if:salary_type,monthly|nullable|numeric|min:0',
                'daily_salary_raw' => 'required_if:salary_type,daily|nullable|numeric|min:0',
                'working_days_per_month' => 'required|integer|min:1|max:31',
                'absence_deduction_rate' => 'required|numeric|min:0|max:100',
                'start_date' => 'required|string',
                'end_date' => 'nullable|string',
                'notes' => 'nullable|string|max:1000',
            ]);
        }

        // Check if any of the selected employees are already assigned to this project
        $existingAssignments = $project->projectEmployees()
            ->whereIn('employee_id', $request->employee_ids)
            ->pluck('employee_id')
            ->toArray();

        if (!empty($existingAssignments)) {
            $existingEmployeeNames = Employee::whereIn('id', $existingAssignments)
                ->pluck('first_name', 'id')
                ->toArray();

            $names = implode('، ', $existingEmployeeNames);
            return back()->withErrors(['employee_ids' => "کارمندان زیر قبلاً به این پروژه اختصاص یافته‌اند: {$names}"]);
        }

        try {
            DB::beginTransaction();

            $persianDateService = new PersianDateService();
            $startDate = $persianDateService->persianToGregorian($request->start_date);
            $endDate = $request->end_date ? $persianDateService->persianToGregorian($request->end_date) : null;

            $createdCount = 0;
            $errors = [];

            foreach ($request->employee_ids as $employeeId) {
                try {
                    if ($isIndividualMode) {
                        // Individual salary mode
                        $salaryType = $request->input("employee_salary_type.{$employeeId}");
                        $salaryAmount = null;
                        $dailySalary = null;
                        
                        if ($salaryType === 'monthly') {
                            $salaryAmount = $request->input("employee_salary_amount_raw.{$employeeId}");
                        } elseif ($salaryType === 'daily') {
                            $dailySalary = $request->input("employee_daily_salary_raw.{$employeeId}");
                        }
                        
                        $projectEmployee = ProjectEmployee::create([
                            'project_id' => $project->id,
                            'employee_id' => $employeeId,
                            'salary_type' => $salaryType,
                            'salary_amount' => $salaryAmount,
                            'daily_salary' => $dailySalary,
                            'working_days_per_month' => $request->working_days_per_month,
                            'absence_deduction_rate' => $request->absence_deduction_rate,
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                            'notes' => $request->notes,
                            'is_active' => true,
                        ]);
                    } else {
                        // Common salary mode
                        $projectEmployee = ProjectEmployee::create([
                            'project_id' => $project->id,
                            'employee_id' => $employeeId,
                            'salary_type' => $request->salary_type,
                            'salary_amount' => $request->salary_type === 'monthly' ? $request->salary_amount_raw : null,
                            'daily_salary' => $request->salary_type === 'daily' ? $request->daily_salary_raw : null,
                            'working_days_per_month' => $request->working_days_per_month,
                            'absence_deduction_rate' => $request->absence_deduction_rate,
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                            'notes' => $request->notes,
                            'is_active' => true,
                        ]);
                    }

                    $createdCount++;
                } catch (\Exception $e) {
                    $employee = Employee::find($employeeId);
                    $errors[] = "خطا در اختصاص کارمند {$employee->full_name}: " . $e->getMessage();
                }
            }

            if ($createdCount > 0) {
                DB::commit();
                $message = "{$createdCount} کارمند با موفقیت به پروژه اختصاص یافت.";

                if (!empty($errors)) {
                    $message .= " اما خطاهای زیر رخ داد: " . implode(' | ', $errors);
                }

                return redirect()->route('panel.projects.employees.index', $project)
                    ->with('success', $message);
            } else {
                DB::rollBack();
                return back()->withErrors(['employee_ids' => 'هیچ کارمندی اختصاص نیافت. لطفاً دوباره تلاش کنید.']);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'خطا در اختصاص کارمندان: ' . $e->getMessage()]);
        }
    }
}
