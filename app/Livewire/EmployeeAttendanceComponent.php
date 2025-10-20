<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Services\PersianDateService;
use Illuminate\Support\Facades\DB;

class EmployeeAttendanceComponent extends Component
{
    public $employee;
    public $projects = [];
    public $attendanceRecords = [];
    public $statistics = [];
    
    // Filters
    public $projectId = '';
    public $startDate = '';
    public $endDate = '';
    
    // Pagination
    public $perPage = 20;
    public $currentPage = 1;
    public $totalRecords = 0;

    protected $rules = [
        'projectId' => 'nullable|exists:projects,id',
        'startDate' => 'required|string',
        'endDate' => 'required|string',
    ];

    public function mount(Employee $employee)
    {
        $this->employee = $employee;
        
        // Set default dates
        $today = \Carbon\Carbon::now();
        $this->startDate = PersianDateService::carbonToPersian($today->copy()->subDays(30));
        $this->endDate = PersianDateService::carbonToPersian($today);
        
        $this->loadData();
    }

    public function updatedProjectId()
    {
        $this->currentPage = 1;
        $this->loadData();
    }

    public function updatedStartDate()
    {
        $this->currentPage = 1;
        $this->loadData();
    }

    public function updatedEndDate()
    {
        $this->currentPage = 1;
        $this->loadData();
    }

    public function loadData()
    {
        // Load employee projects
        $this->projects = $this->employee->projectEmployees()
            ->with('project')
            ->where('is_active', true)
            ->get();

        // Convert Persian dates to Gregorian
        $startGregorian = PersianDateService::persianToCarbon($this->startDate);
        $endGregorian = PersianDateService::persianToCarbon($this->endDate);

        if (!$startGregorian || !$endGregorian) {
            $this->addError('startDate', 'تاریخ‌های وارد شده نامعتبر است.');
            return;
        }

        // Get attendance data with pagination
        $query = EmployeeAttendance::where('employee_id', $this->employee->id)
            ->whereBetween('attendance_date', [$startGregorian->format('Y-m-d'), $endGregorian->format('Y-m-d')])
            ->with('project');

        if ($this->projectId) {
            $query->where('project_id', $this->projectId);
        }

        // Get total count for pagination
        $this->totalRecords = $query->count();

        // Get paginated records
        $this->attendanceRecords = $query->orderBy('attendance_date', 'desc')
            ->skip(($this->currentPage - 1) * $this->perPage)
            ->take($this->perPage)
            ->get();

        // Calculate statistics
        $this->calculateStatistics($startGregorian, $endGregorian);
    }

    private function calculateStatistics($startGregorian, $endGregorian)
    {
        $query = EmployeeAttendance::where('employee_id', $this->employee->id)
            ->whereBetween('attendance_date', [$startGregorian->format('Y-m-d'), $endGregorian->format('Y-m-d')]);

        if ($this->projectId) {
            $query->where('project_id', $this->projectId);
        }

        $records = $query->get();

        $totalDays = $startGregorian->diffInDays($endGregorian) + 1;
        $presentDays = $records->where('status', 'present')->count();
        $absentDays = $records->where('status', 'absent')->count();
        $lateDays = $records->where('status', 'late')->count();
        $halfDays = $records->where('status', 'half_day')->count();
        $vacationDays = $records->where('status', 'vacation')->count();
        $sickLeaveDays = $records->where('status', 'sick_leave')->count();

        $totalWorkingHours = $records->sum('working_hours');
        $totalOvertimeHours = $records->sum('overtime_hours');
        $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100, 2) : 0;

        $this->statistics = [
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
    }

    public function nextPage()
    {
        if ($this->currentPage < $this->getTotalPages()) {
            $this->currentPage++;
            $this->loadData();
        }
    }

    public function previousPage()
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
            $this->loadData();
        }
    }

    public function goToPage($page)
    {
        if ($page >= 1 && $page <= $this->getTotalPages()) {
            $this->currentPage = $page;
            $this->loadData();
        }
    }

    public function getTotalPages()
    {
        return ceil($this->totalRecords / $this->perPage);
    }

    public function getStatusText($status)
    {
        $statusMap = [
            'present' => 'حاضر',
            'absent' => 'غایب',
            'late' => 'تأخیر',
            'half_day' => 'نیم روز',
            'vacation' => 'مرخصی',
            'sick_leave' => 'مرخصی استعلاجی'
        ];
        return $statusMap[$status] ?? $status;
    }

    public function getStatusColor($status)
    {
        $colorMap = [
            'present' => 'success',
            'absent' => 'danger',
            'late' => 'warning',
            'half_day' => 'info',
            'vacation' => 'primary',
            'sick_leave' => 'secondary'
        ];
        return $colorMap[$status] ?? 'secondary';
    }

    public function getFormattedWorkingHours($workingHours)
    {
        if (!$workingHours) return '-';
        
        $hours = floor($workingHours / 60);
        $minutes = $workingHours % 60;
        
        if ($hours > 0 && $minutes > 0) {
            return "{$hours} ساعت و {$minutes} دقیقه";
        } elseif ($hours > 0) {
            return "{$hours} ساعت";
        } else {
            return "{$minutes} دقیقه";
        }
    }

    public function render()
    {
        return view('livewire.employee-attendance-component');
    }
}
