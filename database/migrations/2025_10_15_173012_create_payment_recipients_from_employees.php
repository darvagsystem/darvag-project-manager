<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create payment recipients from existing employees
        $employees = DB::table('employees')->get();

        foreach ($employees as $employee) {
            // Get the first bank account for this employee
            $bankAccount = DB::table('employee_bank_accounts')
                ->where('employee_id', $employee->id)
                ->first();

            // Check if recipient already exists
            $existing = DB::table('payment_recipients')
                ->where('type', 'employee')
                ->where('recipient_id', $employee->id)
                ->first();

            if (!$existing) {
                DB::table('payment_recipients')->insert([
                    'type' => 'employee',
                    'recipient_id' => $employee->id,
                    'recipient_name' => $employee->first_name . ' ' . $employee->last_name,
                    'recipient_code' => $employee->employee_code,
                    'bank_name' => $bankAccount?->bank_name,
                    'account_number' => $bankAccount?->account_number,
                    'iban' => $bankAccount?->iban,
                    'card_number' => $bankAccount?->card_number,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove payment recipients created from employees
        DB::table('payment_recipients')
            ->where('type', 'employee')
            ->delete();
    }
};
