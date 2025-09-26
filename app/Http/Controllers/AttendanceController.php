<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Attendance;
use App\Models\ProjectEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of attendance records for a project.
     */
    public function index(Project $project)
    {
        $selectedDate = request('date', Carbon::today()->format('Y-m-d'));
        $projectEmployees = $project->projectEmployees()
            ->with('employee')
            ->where('is_active', true)
            ->get();

        $attendances = Attendance::where('project_id', $project->id)
            ->where('attendance_date', $selectedDate)
            ->with('employee')
            ->get()
            ->keyBy('employee_id');

        return view('admin.projects.attendance.index', compact(
            'project',
            'projectEmployees',
            'attendances',
            'selectedDate'
        ));
    }

    /**
     * Show the form for creating attendance records.
     */
    public function create(Project $project)
    {
        $selectedDate = request('date', Carbon::today()->format('Y-m-d'));
        $projectEmployees = $project->projectEmployees()
            ->with('employee')
            ->where('is_active', true)
            ->get();

        $attendances = Attendance::where('project_id', $project->id)
            ->where('attendance_date', $selectedDate)
            ->get()
            ->keyBy('employee_id');

        return view('admin.projects.attendance.create', compact(
            'project',
            'projectEmployees',
            'attendances',
            'selectedDate'
        ));
    }

    /**
     * Store attendance records for a specific date.
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'attendance_date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.employee_id' => 'required|exists:employees,id',
            'attendances.*.status' => 'required|in:present,absent,late,half_day',
            'attendances.*.check_in_time' => 'nullable|date_format:H:i',
            'attendances.*.check_out_time' => 'nullable|date_format:H:i',
            'attendances.*.notes' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            $attendanceDate = $request->attendance_date;

            foreach ($request->attendances as $attendanceData) {
                // Calculate hours worked if both check-in and check-out times are provided
                $hoursWorked = null;
                if ($attendanceData['check_in_time'] && $attendanceData['check_out_time']) {
                    $checkIn = Carbon::createFromFormat('H:i', $attendanceData['check_in_time']);
                    $checkOut = Carbon::createFromFormat('H:i', $attendanceData['check_out_time']);
                    $hoursWorked = $checkOut->diffInMinutes($checkIn);
                }

                // Get project employee for salary calculation
                $projectEmployee = ProjectEmployee::where('project_id', $project->id)
                    ->where('employee_id', $attendanceData['employee_id'])
                    ->first();

                // Calculate salary earned
                $salaryEarned = null;
                if ($projectEmployee) {
                    if ($projectEmployee->salary_type === 'daily') {
                        if ($attendanceData['status'] === 'present') {
                            $salaryEarned = $projectEmployee->daily_salary;
                        } elseif ($attendanceData['status'] === 'half_day') {
                            $salaryEarned = $projectEmployee->daily_salary * 0.5;
                        }
                    } else { // monthly
                        $dailySalary = $projectEmployee->salary_amount / $projectEmployee->working_days_per_month;
                        if ($attendanceData['status'] === 'present') {
                            $salaryEarned = $dailySalary;
                        } elseif ($attendanceData['status'] === 'half_day') {
                            $salaryEarned = $dailySalary * 0.5;
                        }
                    }
                }

                // Update or create attendance record
                Attendance::updateOrCreate(
                    [
                        'project_id' => $project->id,
                        'employee_id' => $attendanceData['employee_id'],
                        'attendance_date' => $attendanceDate
                    ],
                    [
                        'status' => $attendanceData['status'],
                        'check_in_time' => $attendanceData['check_in_time'],
                        'check_out_time' => $attendanceData['check_out_time'],
                        'hours_worked' => $hoursWorked,
                        'salary_earned' => $salaryEarned,
                        'notes' => $attendanceData['notes'] ?? null
                    ]
                );
            }

            DB::commit();
            return redirect()->route('projects.attendance.index', $project)
                ->with('success', 'اطلاعات حضور و غیاب با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'خطا در ثبت اطلاعات: ' . $e->getMessage()]);
        }
    }

    /**
     * Display attendance records for a specific date.
     */
    public function show(Project $project, $date)
    {
        $attendanceDate = Carbon::parse($date)->format('Y-m-d');
        $projectEmployees = $project->projectEmployees()
            ->with('employee')
            ->where('is_active', true)
            ->get();

        $attendances = Attendance::where('project_id', $project->id)
            ->where('attendance_date', $attendanceDate)
            ->with('employee')
            ->get()
            ->keyBy('employee_id');

        return view('admin.projects.attendance.show', compact(
            'project',
            'projectEmployees',
            'attendances',
            'attendanceDate'
        ));
    }

    /**
     * Update a specific attendance record.
     */
    public function update(Request $request, Project $project, Attendance $attendance)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late,half_day',
            'check_in_time' => 'nullable|date_format:H:i',
            'check_out_time' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            // Calculate hours worked if both check-in and check-out times are provided
            $hoursWorked = null;
            if ($request->check_in_time && $request->check_out_time) {
                $checkIn = Carbon::createFromFormat('H:i', $request->check_in_time);
                $checkOut = Carbon::createFromFormat('H:i', $request->check_out_time);
                $hoursWorked = $checkOut->diffInMinutes($checkIn);
            }

            // Get project employee for salary calculation
            $projectEmployee = ProjectEmployee::where('project_id', $project->id)
                ->where('employee_id', $attendance->employee_id)
                ->first();

            // Calculate salary earned
            $salaryEarned = null;
            if ($projectEmployee) {
                if ($projectEmployee->salary_type === 'daily') {
                    if ($request->status === 'present') {
                        $salaryEarned = $projectEmployee->daily_salary;
                    } elseif ($request->status === 'half_day') {
                        $salaryEarned = $projectEmployee->daily_salary * 0.5;
                    }
                } else { // monthly
                    $dailySalary = $projectEmployee->salary_amount / $projectEmployee->working_days_per_month;
                    if ($request->status === 'present') {
                        $salaryEarned = $dailySalary;
                    } elseif ($request->status === 'half_day') {
                        $salaryEarned = $dailySalary * 0.5;
                    }
                }
            }

            $attendance->update([
                'status' => $request->status,
                'check_in_time' => $request->check_in_time,
                'check_out_time' => $request->check_out_time,
                'hours_worked' => $hoursWorked,
                'salary_earned' => $salaryEarned,
                'notes' => $request->notes
            ]);

            DB::commit();
            return redirect()->route('projects.attendance.index', $project)
                ->with('success', 'اطلاعات حضور و غیاب با موفقیت به‌روزرسانی شد.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'خطا در به‌روزرسانی: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove a specific attendance record.
     */
    public function destroy(Project $project, Attendance $attendance)
    {
        DB::beginTransaction();
        try {
            $attendance->delete();
            DB::commit();
            return redirect()->route('projects.attendance.index', $project)
                ->with('success', 'رکورد حضور و غیاب حذف شد.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'خطا در حذف: ' . $e->getMessage()]);
        }
    }

    /**
     * Get attendance statistics for a project.
     */
    public function statistics(Project $project)
    {
        $startDate = request('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = request('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $statistics = [];
        $projectEmployees = $project->projectEmployees()
            ->with('employee')
            ->where('is_active', true)
            ->get();

        foreach ($projectEmployees as $projectEmployee) {
            $attendances = Attendance::where('project_id', $project->id)
                ->where('employee_id', $projectEmployee->employee_id)
                ->whereBetween('attendance_date', [$startDate, $endDate])
                ->get();

            $statistics[] = [
                'employee' => $projectEmployee->employee,
                'project_employee' => $projectEmployee,
                'total_days' => $attendances->count(),
                'present_days' => $attendances->where('status', 'present')->count(),
                'absent_days' => $attendances->where('status', 'absent')->count(),
                'late_days' => $attendances->where('status', 'late')->count(),
                'half_days' => $attendances->where('status', 'half_day')->count(),
                'total_salary_earned' => $attendances->sum('salary_earned'),
                'total_hours_worked' => $attendances->sum('hours_worked')
            ];
        }

        return view('admin.projects.attendance.statistics', compact(
            'project',
            'statistics',
            'startDate',
            'endDate'
        ));
    }
}
