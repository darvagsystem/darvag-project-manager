<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectIncome;
use App\Models\ProjectExpense;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class ProjectFinanceController extends Controller
{
    public function dashboard(Project $project)
    {
        // Calculate financial statistics
        $totalIncome = $project->incomes()->where('status', 'received')->sum('amount');
        $totalExpenses = $project->expenses()->where('status', 'paid')->sum('amount');
        $totalPayments = $project->payments()->where('status', 'completed')->sum('amount');

        // Calculate profit/loss
        $grossProfit = $totalIncome - $totalExpenses;
        $netProfit = $totalIncome - $totalPayments;

        // Get recent transactions
        $recentIncomes = $project->incomes()->with('creator')->latest()->take(5)->get();
        $recentExpenses = $project->expenses()->with('creator')->latest()->take(5)->get();
        $recentPayments = $project->payments()->with(['recipient', 'paymentType', 'creator'])->latest()->take(5)->get();

        // Monthly breakdown
        $monthlyData = $this->getMonthlyFinancialData($project);

        // Category breakdown
        $incomeByType = $this->getIncomeByType($project);
        $expenseByType = $this->getExpenseByType($project);

        $statistics = [
            'total_income' => $totalIncome,
            'total_expenses' => $totalExpenses,
            'total_payments' => $totalPayments,
            'gross_profit' => $grossProfit,
            'net_profit' => $netProfit,
            'profit_margin' => $totalIncome > 0 ? ($grossProfit / $totalIncome) * 100 : 0,
            'income_count' => $project->incomes()->count(),
            'expense_count' => $project->expenses()->count(),
            'payment_count' => $project->payments()->count(),
        ];

        return view('admin.projects.finance.dashboard', compact(
            'project',
            'statistics',
            'recentIncomes',
            'recentExpenses',
            'recentPayments',
            'monthlyData',
            'incomeByType',
            'expenseByType'
        ));
    }

    public function incomes(Project $project)
    {
        $incomes = $project->incomes()->with('creator')->latest()->paginate(20);
        return view('admin.projects.finance.incomes', compact('project', 'incomes'));
    }

    public function expenses(Project $project)
    {
        $expenses = $project->expenses()->with('creator')->latest()->paginate(20);
        return view('admin.projects.finance.expenses', compact('project', 'expenses'));
    }

    public function payments(Project $project)
    {
        $payments = $project->payments()
            ->with(['recipient', 'paymentType', 'creator'])
            ->latest()
            ->paginate(20);

        return view('admin.projects.finance.payments', compact('project', 'payments'));
    }

    public function profitLoss(Project $project)
    {
        $startDate = request('start_date', now()->startOfMonth());
        $endDate = request('end_date', now()->endOfMonth());

        // Get financial data for the period
        $incomes = $project->incomes()
            ->whereBetween('income_date', [$startDate, $endDate])
            ->get();

        $expenses = $project->expenses()
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->get();

        $payments = $project->payments()
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->get();

        // Calculate totals
        $totalIncome = $incomes->where('status', 'received')->sum('amount');
        $totalExpenses = $expenses->where('status', 'paid')->sum('amount');
        $totalPayments = $payments->where('status', 'completed')->sum('amount');

        $grossProfit = $totalIncome - $totalExpenses;
        $netProfit = $totalIncome - $totalPayments;

        return view('admin.projects.finance.profit-loss', compact(
            'project',
            'incomes',
            'expenses',
            'payments',
            'totalIncome',
            'totalExpenses',
            'totalPayments',
            'grossProfit',
            'netProfit',
            'startDate',
            'endDate'
        ));
    }

    private function getMonthlyFinancialData(Project $project)
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();

            $income = $project->incomes()
                ->whereBetween('income_date', [$startOfMonth, $endOfMonth])
                ->where('status', 'received')
                ->sum('amount');

            $expense = $project->expenses()
                ->whereBetween('expense_date', [$startOfMonth, $endOfMonth])
                ->where('status', 'paid')
                ->sum('amount');

            $months[] = [
                'month' => $date->format('Y-m'),
                'month_name' => $date->format('M Y'),
                'income' => $income,
                'expense' => $expense,
                'profit' => $income - $expense
            ];
        }

        return $months;
    }

    private function getIncomeByType(Project $project)
    {
        return $project->incomes()
            ->select('income_type', DB::raw('SUM(amount) as total'))
            ->where('status', 'received')
            ->groupBy('income_type')
            ->get()
            ->pluck('total', 'income_type');
    }

    private function getExpenseByType(Project $project)
    {
        return $project->expenses()
            ->select('expense_type', DB::raw('SUM(amount) as total'))
            ->where('status', 'paid')
            ->groupBy('expense_type')
            ->get()
            ->pluck('total', 'expense_type');
    }
}
