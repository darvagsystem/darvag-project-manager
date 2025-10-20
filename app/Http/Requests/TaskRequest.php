<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\PersianDateService;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,normal,high,urgent',
            'due_date' => 'nullable|string',
            'start_date' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
            'category_id' => 'nullable|exists:task_categories,id',
            'estimated_hours' => 'nullable|numeric|min:0',
            'actual_hours' => 'nullable|numeric|min:0',
            'progress' => 'required|integer|min:0|max:100',
            'notes' => 'nullable|string'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Convert Persian dates to Carbon instances
        if ($this->has('due_date') && $this->due_date) {
            $convertedDate = $this->convertPersianToCarbon($this->due_date);
            if ($convertedDate) {
                $this->merge([
                    'due_date' => $convertedDate
                ]);
            }
        }

        if ($this->has('start_date') && $this->start_date) {
            $convertedDate = $this->convertPersianToCarbon($this->start_date);
            if ($convertedDate) {
                $this->merge([
                    'start_date' => $convertedDate
                ]);
            }
        }
    }

    /**
     * Convert Persian date string to Carbon instance
     */
    private function convertPersianToCarbon($persianDate)
    {
        try {
            // Parse Persian date format: YYYY/MM/DD HH:MM
            if (preg_match('/^(\d{4})\/(\d{1,2})\/(\d{1,2})\s+(\d{1,2}):(\d{1,2})$/', $persianDate, $matches)) {
                $year = (int)$matches[1];
                $month = (int)$matches[2];
                $day = (int)$matches[3];
                $hour = (int)$matches[4];
                $minute = (int)$matches[5];

                // Convert Persian date to Gregorian using the service
                $carbon = PersianDateService::persianToCarbon($year . '/' . $month . '/' . $day, $hour . ':' . $minute);

                return $carbon;
            }
        } catch (\Exception $e) {
            \Log::error('Persian date conversion error: ' . $e->getMessage(), [
                'persian_date' => $persianDate
            ]);
        }

        return null;
    }
}
