<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\ProjectEmployee;
use App\Services\PersianDateService;
use Illuminate\Support\Facades\DB;

class AttendanceComponent extends Component
{
    public $project;
    public $selectedDate;
    public $persianDateInput;
    public $attendanceData = [];
    public $persianDate;
    public $gregorianDate;
    public $existingAttendance = [];

    protected $rules = [
        'attendanceData.*.status' => 'required|in:present,absent,late,half_day,vacation,sick_leave',
        'attendanceData.*.check_in_time' => 'nullable|date_format:H:i',
        'attendanceData.*.check_out_time' => 'nullable|date_format:H:i',
        'attendanceData.*.overtime_hours' => 'nullable|numeric|min:0',
        'attendanceData.*.useful_hours' => 'nullable|numeric|min:0',
        'attendanceData.*.notes' => 'nullable|string|max:1000',
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
        // Start with today's Persian date
        $today = \Carbon\Carbon::now();
        $this->persianDateInput = PersianDateService::carbonToPersian($today);
        $this->selectedDate = $today->format('Y-m-d');
        $this->persianDate = $this->persianDateInput;
        $this->loadAttendanceData();
    }

    public function updatedPersianDateInput()
    {
        // Convert Persian date to Gregorian
        try {
            $gregorianDate = PersianDateService::persianToCarbon($this->persianDateInput);

            if ($gregorianDate) {
                $this->selectedDate = $gregorianDate->format('Y-m-d');
                $this->persianDate = $this->persianDateInput;
                $this->loadAttendanceData();
            } else {
                session()->flash('error', 'تاریخ وارد شده نامعتبر است. لطفاً تاریخ را به فرمت 1403/01/01 وارد کنید.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'خطا در تبدیل تاریخ: ' . $e->getMessage());
        }
    }

    public function updatedSelectedDate()
    {
        $this->loadAttendanceData();
    }

    public function loadAttendanceData()
    {
        try {
            // Convert to Gregorian for database query
            $this->gregorianDate = \Carbon\Carbon::parse($this->selectedDate);

            // Convert to Persian for display
            $this->persianDate = PersianDateService::carbonToPersian($this->gregorianDate);

            // If Persian date is not set, use the input
            if (!$this->persianDate) {
                $this->persianDate = $this->persianDateInput;
            }
        } catch (\Exception $e) {
            session()->flash('error', 'خطا در بارگذاری داده‌ها: ' . $e->getMessage());
            return;
        }

        // Get all active employees for this project
        $projectEmployees = $this->project->projectEmployees()
            ->with(['employee'])
            ->where('is_active', true)
            ->get();

        // Get existing attendance records for the selected date
        $existingAttendance = EmployeeAttendance::forProject($this->project->id)
            ->forDate($this->gregorianDate->format('Y-m-d'))
            ->with('employee')
            ->get()
            ->keyBy('employee_id');

        // Store existing attendance for display
        $this->existingAttendance = $existingAttendance->map(function($attendance) {
            return [
                'id' => $attendance->id,
                'employee_id' => $attendance->employee_id,
                'status' => $attendance->status,
                'check_in_time' => $attendance->check_in_time ? $attendance->check_in_time->format('H:i') : null,
                'check_out_time' => $attendance->check_out_time ? $attendance->check_out_time->format('H:i') : null,
                'working_hours' => $attendance->working_hours,
                'overtime_hours' => $attendance->overtime_hours ?? 0,
                'useful_hours' => $attendance->useful_hours ?? 8,
                'notes' => $attendance->notes,
                'employee' => [
                    'full_name' => $attendance->employee->full_name ?? 'نامشخص',
                    'employee_code' => $attendance->employee->employee_code ?? 'نامشخص'
                ]
            ];
        })->values()->toArray();

        // Prepare attendance data for all active project employees
        $this->attendanceData = [];
        foreach ($projectEmployees as $projectEmployee) {
            $attendance = $existingAttendance->get($projectEmployee->employee_id);

            $this->attendanceData[] = [
                'employee_id' => $projectEmployee->employee_id,
                'project_employee_id' => $projectEmployee->id,
                'employee_name' => $projectEmployee->employee->full_name,
                'employee_code' => $projectEmployee->employee->employee_code,
                'status' => $attendance ? $attendance->status : 'present', // Default to present
                'check_in_time' => $attendance && $attendance->check_in_time ? $attendance->check_in_time->format('H:i') : '07:15',
                'check_out_time' => $attendance && $attendance->check_out_time ? $attendance->check_out_time->format('H:i') : '17:00',
                'working_hours' => $attendance ? $attendance->working_hours : 480, // 8 hours in minutes
                'overtime' => $attendance ? max(0, ($attendance->working_hours ?? 0) - 480) : 0,
                'overtime_hours' => $attendance ? ($attendance->overtime_hours ?? 0) : 0,
                'useful_hours' => $attendance ? ($attendance->useful_hours ?? 8) : 8, // Default 8 hours
                'notes' => $attendance ? $attendance->notes : '',
                'attendance_id' => $attendance ? $attendance->id : null,
            ];
        }
    }

    public function updateStatus($index, $status)
    {
        $this->attendanceData[$index]['status'] = $status;

        // Disable time inputs if absent
        if ($status === 'absent') {
            $this->attendanceData[$index]['check_in_time'] = '';
            $this->attendanceData[$index]['check_out_time'] = '';
            $this->attendanceData[$index]['working_hours'] = 0;
            $this->attendanceData[$index]['overtime'] = 0;
            $this->attendanceData[$index]['overtime_hours'] = 0;
            $this->attendanceData[$index]['useful_hours'] = 0;
        }
        // Set half day to 4 hours
        elseif ($status === 'half_day') {
            $this->attendanceData[$index]['working_hours'] = 240; // 4 hours in minutes
            $this->attendanceData[$index]['useful_hours'] = 240; // 4 hours in minutes
            $this->attendanceData[$index]['overtime'] = 0;
            $this->attendanceData[$index]['overtime_hours'] = 0;
        }

        $this->calculateWorkingHours($index);
    }

    public function updateTime($index, $field, $value)
    {
        $this->attendanceData[$index][$field] = $value;
        $this->calculateWorkingHours($index);
    }

    public function calculateWorkingHours($index)
    {
        // If status is absent, set everything to zero
        if ($this->attendanceData[$index]['status'] === 'absent') {
            $this->attendanceData[$index]['working_hours'] = 0;
            $this->attendanceData[$index]['overtime'] = 0;
            $this->attendanceData[$index]['overtime_hours'] = 0;
            $this->attendanceData[$index]['useful_hours'] = 0;
            return;
        }

        // If status is half day, set to 4 hours and return
        if ($this->attendanceData[$index]['status'] === 'half_day') {
            $this->attendanceData[$index]['working_hours'] = 240; // 4 hours in minutes
            $this->attendanceData[$index]['useful_hours'] = 240; // 4 hours in minutes
            $this->attendanceData[$index]['overtime'] = 0;
            $this->attendanceData[$index]['overtime_hours'] = 0;
            return;
        }

        $checkIn = $this->attendanceData[$index]['check_in_time'];
        $checkOut = $this->attendanceData[$index]['check_out_time'];

        if ($checkIn && $checkOut) {
            // Parse time strings
            $startMinutes = $this->timeToMinutes($checkIn);
            $endMinutes = $this->timeToMinutes($checkOut);

            // Handle overnight shifts
            if ($endMinutes < $startMinutes) {
                $endMinutes += 24 * 60; // Add 24 hours
            }

            $totalMinutes = $endMinutes - $startMinutes;
            $this->attendanceData[$index]['working_hours'] = $totalMinutes;

            // Calculate overtime (more than 8 hours = 480 minutes)
            $overtime = max(0, $totalMinutes - 480);
            $this->attendanceData[$index]['overtime'] = $overtime;
            $this->attendanceData[$index]['overtime_hours'] = round($overtime / 60, 2);
            $this->attendanceData[$index]['useful_hours'] = 8 + round($overtime / 60, 2);
        } else {
            $this->attendanceData[$index]['working_hours'] = 0;
            $this->attendanceData[$index]['overtime'] = 0;
            $this->attendanceData[$index]['overtime_hours'] = 0;
            $this->attendanceData[$index]['useful_hours'] = 8;
        }
    }

    private function timeToMinutes($time)
    {
        if (!$time) return 0;
        list($hours, $minutes) = explode(':', $time);
        return (int)$hours * 60 + (int)$minutes;
    }

    public function getFormattedWorkingHours($workingHours, $overtime = 0)
    {
        if (!$workingHours) return '-';

        $hours = floor($workingHours / 60);
        $minutes = $workingHours % 60;

        $overtimeHours = floor($overtime / 60);
        $overtimeMinutes = $overtime % 60;

        $result = '';
        if ($hours > 0 && $minutes > 0) {
            $result = "{$hours} ساعت و {$minutes} دقیقه";
        } elseif ($hours > 0) {
            $result = "{$hours} ساعت";
        } else {
            $result = "{$minutes} دقیقه";
        }

        // Add overtime info
        if ($overtime > 0) {
            if ($overtimeHours > 0 && $overtimeMinutes > 0) {
                $result .= " (+{$overtimeHours}:{$overtimeMinutes} اضافه)";
            } elseif ($overtimeHours > 0) {
                $result .= " (+{$overtimeHours} ساعت اضافه)";
            } else {
                $result .= " (+{$overtimeMinutes} دقیقه اضافه)";
            }
        }

        return $result;
    }

    public function saveAttendance()
    {
        $this->validate();

        // Additional validation: prevent overtime for absent employees
        foreach ($this->attendanceData as $index => $data) {
            if ($data['status'] === 'absent' && ($data['overtime_hours'] > 0 || $data['working_hours'] > 0)) {
                $this->addError("attendanceData.{$index}.status", 'کارمندان غایب نمی‌توانند اضافه کاری یا ساعات کاری داشته باشند.');
                return;
            }
        }

        DB::beginTransaction();
        try {
            foreach ($this->attendanceData as $data) {
                $projectEmployee = ProjectEmployee::find($data['project_employee_id']);

                if (!$projectEmployee) {
                    continue;
                }

                // For absent employees, set everything to zero
                if ($data['status'] === 'absent') {
                    $workingHours = 0;
                    $overtimeHours = 0;
                    $usefulHours = 0;
                    $checkInTime = null;
                    $checkOutTime = null;
                } elseif ($data['status'] === 'half_day') {
                    // Half day = 4 hours
                    $workingHours = 240; // 4 hours in minutes
                    $overtimeHours = 0;
                    $usefulHours = 4; // 4 hours
                    $checkInTime = null;
                    $checkOutTime = null;
                } else {
                    // Calculate working hours for non-absent employees
                    $workingHours = null;
                    if ($data['check_in_time'] && $data['check_out_time']) {
                        $startMinutes = $this->timeToMinutes($data['check_in_time']);
                        $endMinutes = $this->timeToMinutes($data['check_out_time']);

                        if ($endMinutes < $startMinutes) {
                            $endMinutes += 24 * 60;
                        }

                        $workingHours = $endMinutes - $startMinutes;
                    }

                    // Calculate useful hours (8 + overtime)
                    $usefulHours = 8 + ($data['overtime_hours'] ?? 0);
                    $overtimeHours = $data['overtime_hours'] ?? 0;
                    $checkInTime = $data['check_in_time'] ?: null;
                    $checkOutTime = $data['check_out_time'] ?: null;
                }

                // Update or create attendance record
                EmployeeAttendance::updateOrCreate(
                    [
                        'project_id' => $this->project->id,
                        'employee_id' => $data['employee_id'],
                        'attendance_date' => $this->gregorianDate->format('Y-m-d')
                    ],
                    [
                        'project_employee_id' => $data['project_employee_id'],
                        'persian_date' => $this->persianDate,
                        'status' => $data['status'],
                        'check_in_time' => $checkInTime,
                        'check_out_time' => $checkOutTime,
                        'working_hours' => $workingHours,
                        'overtime_hours' => $overtimeHours,
                        'useful_hours' => $usefulHours,
                        'notes' => $data['notes'] ?: null
                    ]
                );
            }

            DB::commit();
            $totalEmployees = count($this->attendanceData);
            $presentCount = collect($this->attendanceData)->where('status', 'present')->count();
            $absentCount = collect($this->attendanceData)->where('status', 'absent')->count();

            $message = "✅ حضور و غیاب با موفقیت ثبت شد!\n";
            $message .= "📅 تاریخ: {$this->persianDate}\n";
            $message .= "👥 تعداد کل کارمندان: {$totalEmployees} نفر\n";
            $message .= "✅ حاضر: {$presentCount} نفر\n";
            $message .= "❌ غایب: {$absentCount} نفر";

            session()->flash('success', $message);
            $this->loadAttendanceData(); // Reload data to show existing records
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'خطا در ثبت حضور و غیاب: ' . $e->getMessage());
        }
    }

    public function bulkUpdateStatus($status)
    {
        foreach ($this->attendanceData as $index => $data) {
            $this->updateStatus($index, $status);
        }

        session()->flash('success', 'وضعیت تمام کارمندان به ' . $this->getStatusText($status) . ' تغییر یافت.');
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

    public function getAttendanceSummary()
    {
        $summary = [
            'total_employees' => count($this->existingAttendance),
            'present' => 0,
            'absent' => 0,
            'late' => 0,
            'half_day' => 0,
            'vacation' => 0,
            'sick_leave' => 0,
            'total_working_hours' => 0,
            'total_overtime' => 0,
        ];

        foreach ($this->existingAttendance as $data) {
            $summary[$data['status']]++;
            if ($data['working_hours']) {
                $summary['total_working_hours'] += $data['working_hours'];
                $overtime = max(0, $data['working_hours'] - 480);
                $summary['total_overtime'] += $overtime;
            }
        }

        return $summary;
    }

    public function render()
    {
        return view('livewire.attendance-component');
    }
}
