<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Employee;
use Illuminate\Support\Facades\Log;

class SendEmployeeNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120;
    public $tries = 3;

    protected $employee;
    protected $message;
    protected $type;

    /**
     * Create a new job instance.
     */
    public function __construct(Employee $employee, string $message, string $type = 'info')
    {
        $this->employee = $employee;
        $this->message = $message;
        $this->type = $type;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info("Sending notification to employee: {$this->employee->employee_code}", [
                'employee_id' => $this->employee->id,
                'message' => $this->message,
                'type' => $this->type
            ]);

            // Here you would implement the actual notification logic
            // For now, we'll just log it
            $this->sendNotification();

        } catch (\Exception $e) {
            Log::error("Failed to send notification to employee {$this->employee->employee_code}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Send the actual notification
     */
    private function sendNotification(): void
    {
        // Simulate notification sending
        // In a real application, you might send SMS, email, or push notification
        $notificationData = [
            'employee_code' => $this->employee->employee_code,
            'employee_name' => $this->employee->first_name . ' ' . $this->employee->last_name,
            'message' => $this->message,
            'type' => $this->type,
            'sent_at' => now()
        ];

        Log::info("Notification sent successfully", $notificationData);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("Employee notification job failed", [
            'employee_id' => $this->employee->id,
            'employee_code' => $this->employee->employee_code,
            'error' => $exception->getMessage()
        ]);
    }
}
