<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeBankAccount;
use App\Models\EmployeeDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EmployeeController extends Controller
{
    /**
     * Test method to verify controller is working
     */
    public function test()
    {
        try {
            // Test database connection
            DB::connection()->getPdo();

            // Test employees table
            $count = Employee::count();

            // Test creating a simple employee
            $testEmployee = Employee::create([
                'employee_code' => 'DVG1234567890',
                'first_name' => 'تست',
                'last_name' => 'کارمند',
                'national_code' => '1234567890',
                'status' => 'active',
                'marital_status' => 'single',
                'education' => 'diploma',
                'avatar' => 'default-avatar.png'
            ]);

            return response()->json([
                'message' => 'Employee controller is working',
                'database_connected' => true,
                'employees_count' => $count,
                'test_employee_created' => $testEmployee ? true : false,
                'test_employee_id' => $testEmployee ? $testEmployee->id : null,
                'table_structure' => Schema::getColumnListing('employees')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage(),
                'database_connected' => false,
                'stack_trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Test form submission
     */
    public function testForm()
    {
        return view('admin.employees.test-form');
    }

    /**

     * Display a listing of employees.
     */
    public function index(Request $request)
    {
        $query = Employee::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('employee_code', 'like', "%{$search}%")
                  ->orWhere('national_code', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Education filter
        if ($request->filled('education') && $request->education !== 'all') {
            $query->where('education', $request->education);
        }

        // Marital status filter
        if ($request->filled('marital_status') && $request->marital_status !== 'all') {
            $query->where('marital_status', $request->marital_status);
        }

        // Sort functionality
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        $allowedSortFields = ['employee_code', 'first_name', 'last_name', 'created_at', 'status'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $employees = $query->with('creator')->get();

        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        return view('admin.employees.create');
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        try {
            \Log::info('Employee creation started', $request->all());

            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'national_code' => 'required|string|size:10|unique:employees',
                'birth_date' => 'nullable|string',
                'marital_status' => 'nullable|in:single,married,divorced,widowed',
                'education' => 'nullable|in:illiterate,elementary,middle_school,high_school,diploma,associate,bachelor,master,phd',
                'status' => 'nullable|in:active,vacation,inactive,terminated',
                'phone' => 'nullable|string|max:20',
                'mobile' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255|unique:employees',
                'address' => 'nullable|string',
                'emergency_contact' => 'nullable|string|max:255',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'notes' => 'nullable|string'
            ]);

            $data = $request->except(['avatar', 'employee_code']);

            // Generate employee code from national code
            $employeeCode = Employee::generateEmployeeCode($request->national_code);
            \Log::info('Generated employee code: ' . $employeeCode);

            // Check if employee code already exists
            if (Employee::employeeCodeExists($employeeCode)) {
                \Log::warning('Employee code already exists: ' . $employeeCode);
                return redirect()->back()
                               ->with('error', 'کد پرسنلی با این کد ملی قبلاً وجود دارد')
                               ->withInput();
            }

            $data['employee_code'] = $employeeCode;
            $data['created_by'] = auth()->id();

            // Handle null/empty values by setting defaults
            $data['marital_status'] = $data['marital_status'] ?: 'single';
            $data['education'] = $data['education'] ?: 'diploma';
            $data['status'] = $data['status'] ?: 'active';

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $data['avatar'] = $avatarPath;
                \Log::info('Avatar uploaded: ' . $avatarPath);
            } else {
                $data['avatar'] = 'default-avatar.png';
            }

            \Log::info('Creating employee with data:', $data);

            $employee = Employee::create($data);

            if ($employee) {
                \Log::info('Employee created successfully with ID: ' . $employee->id);
                return redirect()->route('panel.employees.index')->with('success', 'کارمند با موفقیت اضافه شد');
            } else {
                \Log::error('Employee creation failed');
                return redirect()->back()->with('error', 'خطا در ثبت اطلاعات')->withInput();
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error: ' . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Employee creation error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'خطا در ثبت اطلاعات: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified employee.
     */
    public function show(Employee $employee)
    {

        // آمار حضور و غیاب
        $attendanceStats = DB::table('attendances')
            ->where('employee_id', $employee->id)
            ->selectRaw('
                COUNT(*) as total_days,
                SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_days,
                SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent_days,
                SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late_days,
                SUM(CASE WHEN status = "half_day" THEN 1 ELSE 0 END) as half_days
            ')
            ->first();

        // پروژه‌های فعال
        $activeProjects = $employee->projects()->where('status', 'active')->get();

        // آخرین حضور و غیاب‌ها
        $recentAttendances = DB::table('attendances')
            ->join('projects', 'attendances.project_id', '=', 'projects.id')
            ->where('attendances.employee_id', $employee->id)
            ->orderBy('attendances.attendance_date', 'desc')
            ->limit(10)
            ->select('attendances.*', 'projects.name as project_name')
            ->get();

        // حساب‌های بانکی
        $bankAccounts = $employee->bankAccounts;

        // مدارک
        $documents = $employee->documents;

        return view('admin.employees.show', compact(
            'employee',
            'attendanceStats',
            'activeProjects',
            'recentAttendances',
            'bankAccounts',
            'documents'
        ));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee)
    {
        //پیاده سازی کردن بخش ویرایش پرنسل اگر ایدی وجود نداشت هم پیاده کن
        return view('admin.employees.edit', compact('employee'));


    }

    /**
     * Update the specified employee.
     */
    public function update(Request $request, Employee $employee)
    {

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'national_code' => 'required|string|size:10|unique:employees,national_code,' . $employee->id,
            'birth_date' => 'nullable|string',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'education' => 'nullable|in:illiterate,elementary,middle_school,high_school,diploma,associate,bachelor,master,phd',
            'status' => 'nullable|in:active,vacation,inactive,terminated',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:employees,email,' . $employee->id,
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string'
        ]);

        $data = $request->except(['avatar', 'employee_code']);

        // If national code changed, generate new employee code
        if ($request->national_code !== $employee->national_code) {
            $newEmployeeCode = Employee::generateEmployeeCode($request->national_code);

            // Check if new employee code already exists
            if (Employee::where('employee_code', $newEmployeeCode)->where('id', '!=', $employee->id)->exists()) {
                return redirect()->back()
                               ->with('error', 'کد پرسنلی با این کد ملی قبلاً وجود دارد')
                               ->withInput();
            }

            $data['employee_code'] = $newEmployeeCode;
        }

        // Handle null/empty values by setting defaults
        $data['marital_status'] = $data['marital_status'] ?: 'single';
        $data['education'] = $data['education'] ?: 'diploma';
        $data['status'] = $data['status'] ?: 'active';

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        $employee->update($data);

        return redirect()->route('panel.employees.index')->with('success', 'اطلاعات کارمند با موفقیت به‌روزرسانی شد');
    }

    /**
     * Remove the specified employee.
     */
    public function destroy(Employee $employee)
    {

        // Check if employee has any related data
        if ($employee->bankAccounts()->count() > 0 || $employee->documents()->count() > 0) {
            return redirect()->route('panel.employees.index')
                           ->with('error', 'این کارمند دارای اطلاعات مرتبط است و قابل حذف نیست');
        }

        $employee->delete();

        return redirect()->route('panel.employees.index')->with('success', 'کارمند با موفقیت حذف شد');
    }


    /**
     * Display employee documents.
     */
    public function documents(Employee $employee)
    {
        $documents = $employee->documents()->get();
        $documentTypes = EmployeeDocument::getDocumentTypes();

        return view('admin.employees.documents', compact('employee', 'documents', 'documentTypes'));
    }

    /**
     * Show employee profile
     */
    public function profile(Employee $employee)
    {
        $projects = $employee->projectEmployees()
            ->with('project')
            ->where('is_active', true)
            ->get();

        $totalProjects = $projects->count();
        $totalAttendance = \App\Models\EmployeeAttendance::where('employee_id', $employee->id)->count();
        $presentDays = \App\Models\EmployeeAttendance::where('employee_id', $employee->id)
            ->where('status', 'present')
            ->count();

        return view('admin.employees.profile', compact('employee', 'projects', 'totalProjects', 'totalAttendance', 'presentDays'));
    }

    /**
     * Show employee projects
     */
    public function projects(Employee $employee)
    {
        $projects = $employee->projectEmployees()
            ->with(['project' => function($query) {
                $query->with('client');
            }])
            ->where('is_active', true)
            ->get();

        return view('admin.employees.projects', compact('employee', 'projects'));
    }

    /**
     * Show employee attendance
     */
    public function attendance(Employee $employee)
    {
        return view('admin.employees.attendance-livewire', compact('employee'));
    }

    /**
     * Show employee attendance report
     */
    public function attendanceReport(Request $request, Employee $employee)
    {
        $projectId = $request->get('project_id');
        $startDate = $request->get('start_date', '1404/07/01');
        $endDate = $request->get('end_date', '1404/07/23');

        // Get employee projects
        $projects = $employee->projectEmployees()
            ->with('project')
            ->where('is_active', true)
            ->get();

        // Convert Persian dates to Gregorian
        $startGregorian = \App\Services\PersianDateService::persianToCarbon($startDate);
        $endGregorian = \App\Services\PersianDateService::persianToCarbon($endDate);

        if (!$startGregorian || !$endGregorian) {
            return redirect()->back()->with('error', 'تاریخ‌های وارد شده نامعتبر است.');
        }

        // Get attendance data
        $query = \App\Models\EmployeeAttendance::where('employee_id', $employee->id)
            ->whereBetween('attendance_date', [$startGregorian->format('Y-m-d'), $endGregorian->format('Y-m-d')])
            ->with('project');

        if ($projectId) {
            $query->where('project_id', $projectId);
        }

        $attendanceRecords = $query->orderBy('attendance_date', 'desc')->get();

        // Calculate statistics
        $totalDays = $startGregorian->diffInDays($endGregorian) + 1;
        $presentDays = $attendanceRecords->where('status', 'present')->count();
        $absentDays = $attendanceRecords->where('status', 'absent')->count();
        $lateDays = $attendanceRecords->where('status', 'late')->count();
        $halfDays = $attendanceRecords->where('status', 'half_day')->count();
        $vacationDays = $attendanceRecords->where('status', 'vacation')->count();
        $sickLeaveDays = $attendanceRecords->where('status', 'sick_leave')->count();

        $totalWorkingHours = $attendanceRecords->sum('working_hours');
        $totalOvertimeHours = $attendanceRecords->sum('overtime_hours');
        $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 2) : 0;

        $statistics = [
            'total_days' => $totalDays,
            'present_days' => $presentDays,
            'absent_days' => $absentDays,
            'late_days' => $lateDays,
            'half_days' => $halfDays,
            'vacation_days' => $vacationDays,
            'sick_leave_days' => $sickLeaveDays,
            'attendance_rate' => $attendanceRate,
            'total_working_hours' => $totalWorkingHours,
            'total_overtime_hours' => $totalOvertimeHours,
        ];

        return view('admin.employees.attendance-report', compact(
            'employee',
            'projects',
            'attendanceRecords',
            'statistics',
            'startDate',
            'endDate',
            'projectId'
        ));
    }

    /**
     * Print employee attendance report
     */
    public function attendanceReportPrint(Request $request, Employee $employee)
    {
        $projectId = $request->get('project_id');
        $startDate = $request->get('start_date', '1404/07/01');
        $endDate = $request->get('end_date', '1404/07/23');

        // Get employee projects
        $projects = $employee->projectEmployees()
            ->with('project')
            ->where('is_active', true)
            ->get();

        // Convert Persian dates to Gregorian
        $startGregorian = \App\Services\PersianDateService::persianToCarbon($startDate);
        $endGregorian = \App\Services\PersianDateService::persianToCarbon($endDate);

        if (!$startGregorian || !$endGregorian) {
            return redirect()->back()->with('error', 'تاریخ‌های وارد شده نامعتبر است.');
        }

        // Get attendance data
        $query = \App\Models\EmployeeAttendance::where('employee_id', $employee->id)
            ->whereBetween('attendance_date', [$startGregorian->format('Y-m-d'), $endGregorian->format('Y-m-d')])
            ->with('project');

        if ($projectId) {
            $query->where('project_id', $projectId);
        }

        $attendanceRecords = $query->orderBy('attendance_date', 'desc')->get();

        // Calculate statistics
        $totalDays = $startGregorian->diffInDays($endGregorian) + 1;
        $presentDays = $attendanceRecords->where('status', 'present')->count();
        $absentDays = $attendanceRecords->where('status', 'absent')->count();
        $lateDays = $attendanceRecords->where('status', 'late')->count();
        $halfDays = $attendanceRecords->where('status', 'half_day')->count();
        $vacationDays = $attendanceRecords->where('status', 'vacation')->count();
        $sickLeaveDays = $attendanceRecords->where('status', 'sick_leave')->count();

        $totalWorkingHours = $attendanceRecords->sum('working_hours');
        $totalOvertimeHours = $attendanceRecords->sum('overtime_hours');
        $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 2) : 0;

        $statistics = [
            'total_days' => $totalDays,
            'present_days' => $presentDays,
            'absent_days' => $absentDays,
            'late_days' => $lateDays,
            'half_days' => $halfDays,
            'vacation_days' => $vacationDays,
            'sick_leave_days' => $sickLeaveDays,
            'attendance_rate' => $attendanceRate,
            'total_working_hours' => $totalWorkingHours,
            'total_overtime_hours' => $totalOvertimeHours,
        ];

        return view('admin.employees.attendance-report-print', compact(
            'employee',
            'projects',
            'attendanceRecords',
            'statistics',
            'startDate',
            'endDate',
            'projectId'
        ));
    }
}
