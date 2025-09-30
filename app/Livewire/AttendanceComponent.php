<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceComponent extends Component
{
    public $projectId;
    public $project;
    public $selectedDate;
    public $search = '';
    public $employees = [];
    public $attendances = [];
    public $bulkAction = '';
    public $selectedEmployees = [];
    public $selectAll = false;
    public $showBulkActions = false;

    public function mount($projectId)
    {
        $this->projectId = $projectId;
        $this->project = \App\Models\Project::findOrFail($projectId);
        $this->selectedDate = Carbon::today()->format('Y-m-d');
        $this->loadData();
    }

    public function loadData()
    {
        $query = Employee::query();

        // فیلتر بر اساس پروژه
        $query->whereHas('projects', function($q) {
            $q->where('projects.id', $this->projectId);
        });

        // جستجو
        if ($this->search) {
            $query->where(function($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                  ->orWhere('last_name', 'like', '%' . $this->search . '%')
                  ->orWhere('employee_code', 'like', '%' . $this->search . '%');
            });
        }

        $this->employees = $query->orderBy('first_name')->get();

        $this->loadAttendances();
        $this->updateBulkActionsVisibility();
    }

    public function loadAttendances()
    {
        $employeeIds = $this->employees->pluck('id')->toArray();

        $this->attendances = Attendance::where('attendance_date', $this->selectedDate)
            ->where('project_id', $this->projectId)
            ->whereIn('employee_id', $employeeIds)
            ->get()
            ->keyBy('employee_id');
    }

    public function updatedSelectedDate()
    {
        $this->loadAttendances();
        $this->clearSelection();
    }


    public function updatedSearch()
    {
        $this->loadData();
    }

    public function toggleAttendance($employeeId)
    {
        $attendance = $this->attendances->get($employeeId);

        if ($attendance) {
            // اگر حضور وجود دارد، حذف کن
            $attendance->delete();
            $this->attendances->forget($employeeId);
        } else {
            // اگر حضور وجود ندارد، ایجاد کن
            $attendance = Attendance::create([
                'project_id' => $this->projectId,
                'employee_id' => $employeeId,
                'attendance_date' => $this->selectedDate,
                'check_in_time' => Carbon::now()->format('H:i:s'),
                'status' => 'present'
            ]);
            $this->attendances->put($employeeId, $attendance);
        }

        $this->updateBulkActionsVisibility();
    }

    public function updateCheckIn($employeeId, $time)
    {
        $attendance = $this->attendances->get($employeeId);
        if ($attendance) {
            $attendance->update(['check_in_time' => $time]);
        }
    }

    public function updateCheckOut($employeeId, $time)
    {
        $attendance = $this->attendances->get($employeeId);
        if ($attendance) {
            $attendance->update(['check_out_time' => $time]);
        }
    }

    public function updateStatus($employeeId, $status)
    {
        $attendance = $this->attendances->get($employeeId);
        if ($attendance) {
            $attendance->update(['status' => $status]);
        }
    }

    public function addNote($employeeId, $note)
    {
        $attendance = $this->attendances->get($employeeId);
        if ($attendance) {
            $attendance->update(['notes' => $note]);
        }
    }

    public function toggleSelectAll()
    {
        $this->selectAll = !$this->selectAll;

        if ($this->selectAll) {
            $this->selectedEmployees = $this->employees->pluck('id')->toArray();
        } else {
            $this->selectedEmployees = [];
        }

        $this->updateBulkActionsVisibility();
    }

    public function toggleEmployeeSelection($employeeId)
    {
        if (in_array($employeeId, $this->selectedEmployees)) {
            $this->selectedEmployees = array_diff($this->selectedEmployees, [$employeeId]);
        } else {
            $this->selectedEmployees[] = $employeeId;
        }

        $this->selectAll = count($this->selectedEmployees) === $this->employees->count();
        $this->updateBulkActionsVisibility();
    }

    public function updateBulkActionsVisibility()
    {
        $this->showBulkActions = count($this->selectedEmployees) > 0;
    }

    public function bulkMarkPresent()
    {
        foreach ($this->selectedEmployees as $employeeId) {
            $attendance = $this->attendances->get($employeeId);

            if (!$attendance) {
                $attendance = Attendance::create([
                    'project_id' => $this->projectId,
                    'employee_id' => $employeeId,
                    'attendance_date' => $this->selectedDate,
                    'check_in_time' => Carbon::now()->format('H:i:s'),
                    'status' => 'present'
                ]);
                $this->attendances->put($employeeId, $attendance);
            } else {
                $attendance->update(['status' => 'present']);
            }
        }

        $this->clearSelection();
        session()->flash('message', 'حضور کارکنان انتخاب شده ثبت شد.');
    }

    public function bulkMarkAbsent()
    {
        foreach ($this->selectedEmployees as $employeeId) {
            $attendance = $this->attendances->get($employeeId);

            if (!$attendance) {
                $attendance = Attendance::create([
                    'project_id' => $this->projectId,
                    'employee_id' => $employeeId,
                    'attendance_date' => $this->selectedDate,
                    'status' => 'absent'
                ]);
                $this->attendances->put($employeeId, $attendance);
            } else {
                $attendance->update(['status' => 'absent']);
            }
        }

        $this->clearSelection();
        session()->flash('message', 'غیبت کارکنان انتخاب شده ثبت شد.');
    }

    public function bulkMarkLate()
    {
        foreach ($this->selectedEmployees as $employeeId) {
            $attendance = $this->attendances->get($employeeId);

            if (!$attendance) {
                $attendance = Attendance::create([
                    'project_id' => $this->projectId,
                    'employee_id' => $employeeId,
                    'attendance_date' => $this->selectedDate,
                    'check_in_time' => Carbon::now()->format('H:i:s'),
                    'status' => 'late'
                ]);
                $this->attendances->put($employeeId, $attendance);
            } else {
                $attendance->update(['status' => 'late']);
            }
        }

        $this->clearSelection();
        session()->flash('message', 'تأخیر کارکنان انتخاب شده ثبت شد.');
    }

    public function clearSelection()
    {
        $this->selectedEmployees = [];
        $this->selectAll = false;
        $this->showBulkActions = false;
    }

    public function getAttendanceStatus($employeeId)
    {
        $attendance = $this->attendances->get($employeeId);
        return $attendance ? $attendance->status : null;
    }

    public function getAttendanceCheckIn($employeeId)
    {
        $attendance = $this->attendances->get($employeeId);
        return $attendance ? $attendance->check_in_time : '';
    }

    public function getAttendanceCheckOut($employeeId)
    {
        $attendance = $this->attendances->get($employeeId);
        return $attendance ? $attendance->check_out_time : '';
    }

    public function getAttendanceNotes($employeeId)
    {
        $attendance = $this->attendances->get($employeeId);
        return $attendance ? $attendance->notes : '';
    }

    public function isEmployeeSelected($employeeId)
    {
        return in_array($employeeId, $this->selectedEmployees);
    }

    public function render()
    {
        return view('livewire.attendance-component');
    }
}
