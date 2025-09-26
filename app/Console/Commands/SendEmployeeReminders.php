<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use App\Jobs\SendEmployeeNotification;
use Carbon\Carbon;

class SendEmployeeReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-employee-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders to employees for various tasks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Sending employee reminders...');

        $sentCount = 0;

        // Get active employees
        $employees = Employee::where('status', 'active')->get();

        foreach ($employees as $employee) {
            $reminders = $this->getRemindersForEmployee($employee);

            foreach ($reminders as $reminder) {
                // Dispatch notification job
                SendEmployeeNotification::dispatch($employee, $reminder['message'], $reminder['type']);
                $sentCount++;

                $this->line("Sent reminder to {$employee->first_name} {$employee->last_name}: {$reminder['message']}");
            }
        }

        $this->info("Sent {$sentCount} reminders to employees.");

        return Command::SUCCESS;
    }

    /**
     * Get reminders for a specific employee
     */
    private function getRemindersForEmployee(Employee $employee): array
    {
        $reminders = [];

        // Check for employees without bank accounts
        if (!$employee->bankAccounts()->exists()) {
            $reminders[] = [
                'message' => 'لطفاً اطلاعات حساب بانکی خود را تکمیل کنید.',
                'type' => 'warning'
            ];
        }

        // Check for employees without documents
        if (!$employee->documents()->exists()) {
            $reminders[] = [
                'message' => 'لطفاً مدارک مورد نیاز را آپلود کنید.',
                'type' => 'warning'
            ];
        }

        // Check for employees created more than 30 days ago without complete profile
        if ($employee->created_at->diffInDays(now()) > 30) {
            $incompleteFields = $this->getIncompleteFields($employee);
            if (!empty($incompleteFields)) {
                $reminders[] = [
                    'message' => 'لطفاً اطلاعات پروفایل خود را تکمیل کنید: ' . implode(', ', $incompleteFields),
                    'type' => 'info'
                ];
            }
        }

        // Weekly general reminder
        if (Carbon::now()->isMonday()) {
            $reminders[] = [
                'message' => 'هفته کاری جدید شروع شده است. موفق باشید!',
                'type' => 'info'
            ];
        }

        return $reminders;
    }

    /**
     * Get incomplete fields for an employee
     */
    private function getIncompleteFields(Employee $employee): array
    {
        $incomplete = [];

        if (empty($employee->phone) && empty($employee->mobile)) {
            $incomplete[] = 'شماره تماس';
        }

        if (empty($employee->email)) {
            $incomplete[] = 'ایمیل';
        }

        if (empty($employee->address)) {
            $incomplete[] = 'آدرس';
        }

        if (empty($employee->emergency_contact)) {
            $incomplete[] = 'اطلاعات تماس اضطراری';
        }

        return $incomplete;
    }
}
