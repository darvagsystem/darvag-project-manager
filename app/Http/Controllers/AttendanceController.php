<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\ProjectEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\PersianDateService;

class AttendanceController extends Controller
{
    /**
     * Display attendance for a specific project and date.
     */
    public function index(Project $project)
    {
        return view('admin.projects.attendance.index', compact('project'));
    }

    /**
     * Store or update attendance for multiple employees.
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'date' => 'required|string',
            'attendance' => 'required|array',
            'attendance.*.employee_id' => 'required|exists:employees,id',
            'attendance.*.status' => 'required|in:present,absent,late,half_day,vacation,sick_leave',
            'attendance.*.check_in_time' => 'nullable|date_format:H:i',
            'attendance.*.check_out_time' => 'nullable|date_format:H:i',
            'attendance.*.notes' => 'nullable|string|max:1000'
        ]);

        // Convert date to Gregorian
        $gregorianDate = \Carbon\Carbon::parse($request->date);

        // Convert to Persian for storage
        $persianDate = PersianDateService::carbonToPersian($gregorianDate);

        DB::beginTransaction();
        try {
            foreach ($request->attendance as $attendanceData) {
                $employeeId = $attendanceData['employee_id'];
                $status = $attendanceData['status'];

                // Get project employee record
                $projectEmployee = $project->projectEmployees()
                    ->where('employee_id', $employeeId)
                    ->where('is_active', true)
                    ->first();

                if (!$projectEmployee) {
                    continue; // Skip if employee is not active in this project
                }

                // Calculate working hours if both times are provided
                $workingHours = null;
                if (!empty($attendanceData['check_in_time']) && !empty($attendanceData['check_out_time'])) {
                    $checkIn = \Carbon\Carbon::parse($attendanceData['check_in_time']);
                    $checkOut = \Carbon\Carbon::parse($attendanceData['check_out_time']);

                    if ($checkOut->lessThan($checkIn)) {
                        $checkOut->addDay();
                    }

                    $workingHours = $checkOut->diffInMinutes($checkIn);
                }

                // Update or create attendance record
                EmployeeAttendance::updateOrCreate(
                    [
                        'project_id' => $project->id,
                        'employee_id' => $employeeId,
                        'attendance_date' => $gregorianDate->format('Y-m-d')
                    ],
                    [
                        'project_employee_id' => $projectEmployee->id,
                        'persian_date' => $persianDate,
                        'status' => $status,
                        'check_in_time' => $attendanceData['check_in_time'] ?? null,
                        'check_out_time' => $attendanceData['check_out_time'] ?? null,
                        'working_hours' => $workingHours,
                        'notes' => $attendanceData['notes'] ?? null
                    ]
                );
            }

            DB::commit();
            return redirect()->route('panel.projects.attendance.index', $project)
                ->with('success', 'حضور و غیاب با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'خطا در ثبت حضور و غیاب: ' . $e->getMessage()]);
        }
    }

    /**
     * Show attendance report for a project.
     */
    public function report(Request $request, Project $project)
    {
        $startDate = $request->get('start_date', PersianDateService::getCurrentPersianDate());
        $endDate = $request->get('end_date', PersianDateService::getCurrentPersianDate());

        // Convert Persian dates to Gregorian
        $gregorianStartDate = PersianDateService::persianToCarbon($startDate);
        $gregorianEndDate = PersianDateService::persianToCarbon($endDate);

        if (!$gregorianStartDate || !$gregorianEndDate) {
            return back()->withErrors(['error' => 'تاریخ‌های انتخاب شده نامعتبر است.']);
        }

        // Get attendance data for the date range
        $attendanceData = EmployeeAttendance::forProject($project->id)
            ->forDateRange($gregorianStartDate->format('Y-m-d'), $gregorianEndDate->format('Y-m-d'))
            ->with(['employee', 'projectEmployee'])
            ->orderBy('attendance_date')
            ->orderBy('employee_id')
            ->get();

        // Group by employee
        $employeeAttendance = $attendanceData->groupBy('employee_id');

        // Calculate statistics
        $totalDays = $gregorianStartDate->diffInDays($gregorianEndDate) + 1;
        $statistics = [];

        foreach ($employeeAttendance as $employeeId => $records) {
            $employee = $records->first()->employee;
            $presentDays = $records->where('status', 'present')->count();
            $absentDays = $records->where('status', 'absent')->count();
            $lateDays = $records->where('status', 'late')->count();
            $halfDays = $records->where('status', 'half_day')->count();
            $vacationDays = $records->where('status', 'vacation')->count();
            $sickLeaveDays = $records->where('status', 'sick_leave')->count();

            $totalWorkingHours = $records->sum('working_hours');
            $averageWorkingHours = $records->where('working_hours', '>', 0)->avg('working_hours');
            $totalOvertimeHours = $records->sum('overtime_hours');
            $averageOvertimeHours = $records->where('overtime_hours', '>', 0)->avg('overtime_hours');

            $statistics[$employeeId] = [
                'employee' => $employee,
                'total_days' => $totalDays,
                'present_days' => $presentDays,
                'absent_days' => $absentDays,
                'late_days' => $lateDays,
                'half_days' => $halfDays,
                'vacation_days' => $vacationDays,
                'sick_leave_days' => $sickLeaveDays,
                'attendance_rate' => $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 2) : 0,
                'total_working_hours' => $totalWorkingHours,
                'average_working_hours' => round($averageWorkingHours ?? 0, 2),
                'total_overtime_hours' => $totalOvertimeHours,
                'average_overtime_hours' => round($averageOvertimeHours ?? 0, 2),
                'records' => $records
            ];
        }

        // Convert statistics array to collection for easier handling
        $statistics = collect($statistics);

        return view('admin.projects.attendance.report', compact(
            'project',
            'startDate',
            'endDate',
            'statistics',
            'attendanceData'
        ));
    }

    /**
     * Print attendance report.
     */
    public function printReport(Request $request, Project $project)
    {
        // Get date range from request
        $startDate = $request->get('start_date', '1404/07/01');
        $endDate = $request->get('end_date', '1404/07/23');

        // Convert Persian dates to Gregorian
        $startGregorian = PersianDateService::persianToCarbon($startDate);
        $endGregorian = PersianDateService::persianToCarbon($endDate);

        if (!$startGregorian || !$endGregorian) {
            return redirect()->back()->with('error', 'تاریخ‌های وارد شده نامعتبر است.');
        }

        // Get attendance data
        $employeeAttendance = EmployeeAttendance::forProject($project->id)
            ->whereBetween('attendance_date', [$startGregorian->format('Y-m-d'), $endGregorian->format('Y-m-d')])
            ->with('employee')
            ->get()
            ->groupBy('employee_id');

        $totalDays = $startGregorian->diffInDays($endGregorian) + 1;

        // Calculate statistics
        $statistics = [];
        foreach ($employeeAttendance as $employeeId => $records) {
            $employee = $records->first()->employee;
            $presentDays = $records->where('status', 'present')->count();
            $absentDays = $records->where('status', 'absent')->count();
            $lateDays = $records->where('status', 'late')->count();
            $halfDays = $records->where('status', 'half_day')->count();
            $vacationDays = $records->where('status', 'vacation')->count();
            $sickLeaveDays = $records->where('status', 'sick_leave')->count();

            $totalWorkingHours = $records->sum('working_hours');
            $averageWorkingHours = $records->where('working_hours', '>', 0)->avg('working_hours');
            $totalOvertimeHours = $records->sum('overtime_hours');
            $averageOvertimeHours = $records->where('overtime_hours', '>', 0)->avg('overtime_hours');

            $statistics[$employeeId] = [
                'employee' => $employee,
                'total_days' => $totalDays,
                'present_days' => $presentDays,
                'absent_days' => $absentDays,
                'late_days' => $lateDays,
                'half_days' => $halfDays,
                'vacation_days' => $vacationDays,
                'sick_leave_days' => $sickLeaveDays,
                'attendance_rate' => $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 2) : 0,
                'total_working_hours' => $totalWorkingHours,
                'average_working_hours' => round($averageWorkingHours ?? 0, 2),
                'total_overtime_hours' => $totalOvertimeHours,
                'average_overtime_hours' => round($averageOvertimeHours ?? 0, 2),
                'records' => $records
            ];
        }

        $statistics = collect($statistics);

        return view('admin.projects.attendance.print', compact(
            'project',
            'startDate',
            'endDate',
            'statistics'
        ));
    }

    /**
     * Get attendance data for a specific date via AJAX.
     */
    public function getAttendanceData(Request $request, Project $project)
    {
        $date = $request->get('date');
        $gregorianDate = PersianDateService::persianToCarbon($date);

        if (!$gregorianDate) {
            return response()->json(['error' => 'تاریخ نامعتبر است.'], 400);
        }

        $attendanceData = EmployeeAttendance::forProject($project->id)
            ->forDate($gregorianDate->format('Y-m-d'))
            ->with('employee')
            ->get()
            ->keyBy('employee_id');

        return response()->json($attendanceData);
    }

    /**
     * Bulk update attendance status for all employees.
     */
    public function bulkUpdate(Request $request, Project $project)
    {
        $request->validate([
            'date' => 'required|string',
            'status' => 'required|in:present,absent,late,half_day,vacation,sick_leave',
            'employee_ids' => 'required|array',
            'employee_ids.*' => 'exists:employees,id'
        ]);

        $gregorianDate = PersianDateService::persianToCarbon($request->date);

        if (!$gregorianDate) {
            return back()->withErrors(['error' => 'تاریخ انتخاب شده نامعتبر است.']);
        }

        DB::beginTransaction();
        try {
            foreach ($request->employee_ids as $employeeId) {
                $projectEmployee = $project->projectEmployees()
                    ->where('employee_id', $employeeId)
                    ->where('is_active', true)
                    ->first();

                if ($projectEmployee) {
                    EmployeeAttendance::updateOrCreate(
                        [
                            'project_id' => $project->id,
                            'employee_id' => $employeeId,
                            'attendance_date' => $gregorianDate->format('Y-m-d')
                        ],
                        [
                            'project_employee_id' => $projectEmployee->id,
                            'persian_date' => $request->date,
                            'status' => $request->status,
                            'notes' => $request->notes ?? null
                        ]
                    );
                }
            }

            DB::commit();
            return back()->with('success', 'وضعیت حضور و غیاب با موفقیت به‌روزرسانی شد.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'خطا در به‌روزرسانی: ' . $e->getMessage()]);
        }
    }
}
