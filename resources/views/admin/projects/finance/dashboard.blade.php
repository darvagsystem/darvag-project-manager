@extends('admin.layout')

@section('title', 'داشبورد مالی - ' . $project->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-chart-line text-primary mr-2"></i>
                        داشبورد مالی پروژه
                    </h1>
                    <p class="text-muted mb-0">{{ $project->name }} - {{ $project->contract_number }}</p>
                </div>
                <div>
                    <a href="{{ route('panel.projects.show', $project) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right mr-1"></i>
                        بازگشت به پروژه
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Statistics -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-success text-white shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-trending-up fa-2x mb-2 opacity-75"></i>
                    <div class="h4 mb-0">{{ number_format($statistics['total_income'], 0, '.', ',') }}</div>
                    <div class="text-white-50 small">کل درآمد</div>
                    <div class="text-white-50 small">{{ $statistics['income_count'] }} مورد</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-danger text-white shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-trending-down fa-2x mb-2 opacity-75"></i>
                    <div class="h4 mb-0">{{ number_format($statistics['total_expenses'], 0, '.', ',') }}</div>
                    <div class="text-white-50 small">کل هزینه‌ها</div>
                    <div class="text-white-50 small">{{ $statistics['expense_count'] }} مورد</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-info text-white shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-credit-card fa-2x mb-2 opacity-75"></i>
                    <div class="h4 mb-0">{{ number_format($statistics['total_payments'], 0, '.', ',') }}</div>
                    <div class="text-white-50 small">کل پرداخت‌ها</div>
                    <div class="text-white-50 small">{{ $statistics['payment_count'] }} مورد</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card {{ $statistics['net_profit'] >= 0 ? 'bg-success' : 'bg-warning' }} text-white shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calculator fa-2x mb-2 opacity-75"></i>
                    <div class="h4 mb-0">{{ number_format($statistics['net_profit'], 0, '.', ',') }}</div>
                    <div class="text-white-50 small">{{ $statistics['net_profit'] >= 0 ? 'سود خالص' : 'زیان خالص' }}</div>
                    <div class="text-white-50 small">{{ number_format($statistics['profit_margin'], 1) }}% حاشیه</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Monthly Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-chart-bar text-primary mr-2"></i>
                        روند ماهانه (12 ماه گذشته)
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Category Breakdown -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-pie-chart text-primary mr-2"></i>
                        درآمد بر اساس نوع
                    </h5>
                </div>
                <div class="card-body">
                    @if($incomeByType->count() > 0)
                        @foreach($incomeByType as $type => $amount)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">{{ $type }}</span>
                                <span class="font-weight-bold">{{ number_format($amount, 0, '.', ',') }}</span>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">هیچ درآمدی ثبت نشده</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Incomes -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-trending-up text-success mr-2"></i>
                        آخرین درآمدها
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($recentIncomes->count() > 0)
                        @foreach($recentIncomes as $income)
                            <div class="d-flex align-items-center p-3 border-bottom">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center mr-3"
                                     style="width: 40px; height: 40px;">
                                    <i class="fas fa-arrow-up"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="font-weight-bold text-dark">{{ $income->title }}</div>
                                    <small class="text-muted">{{ $income->income_date->format('Y/m/d') }}</small>
                                </div>
                                <div class="text-left">
                                    <div class="font-weight-bold text-success">{{ number_format($income->amount, 0, '.', ',') }}</div>
                                    <span class="badge badge-{{ $income->status_color }}">{{ $income->status_text }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-trending-up fa-3x text-muted mb-2"></i>
                            <p class="text-muted">هیچ درآمدی ثبت نشده</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Expenses -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-trending-down text-danger mr-2"></i>
                        آخرین هزینه‌ها
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($recentExpenses->count() > 0)
                        @foreach($recentExpenses as $expense)
                            <div class="d-flex align-items-center p-3 border-bottom">
                                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center mr-3"
                                     style="width: 40px; height: 40px;">
                                    <i class="fas fa-arrow-down"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="font-weight-bold text-dark">{{ $expense->title }}</div>
                                    <small class="text-muted">{{ $expense->expense_date->format('Y/m/d') }}</small>
                                </div>
                                <div class="text-left">
                                    <div class="font-weight-bold text-danger">{{ number_format($expense->amount, 0, '.', ',') }}</div>
                                    <span class="badge badge-{{ $expense->status_color }}">{{ $expense->status_text }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-trending-down fa-3x text-muted mb-2"></i>
                            <p class="text-muted">هیچ هزینه‌ای ثبت نشده</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-credit-card text-info mr-2"></i>
                        آخرین پرداخت‌ها
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($recentPayments->count() > 0)
                        @foreach($recentPayments as $payment)
                            <div class="d-flex align-items-center p-3 border-bottom">
                                <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center mr-3"
                                     style="width: 40px; height: 40px;">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="font-weight-bold text-dark">{{ $payment->recipient->recipient_name }}</div>
                                    <small class="text-muted">{{ $payment->payment_date->format('Y/m/d') }}</small>
                                </div>
                                <div class="text-left">
                                    <div class="font-weight-bold text-info">{{ number_format($payment->amount, 0, '.', ',') }}</div>
                                    <span class="badge badge-{{ $payment->status_color }}">{{ $payment->status_text }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-credit-card fa-3x text-muted mb-2"></i>
                            <p class="text-muted">هیچ پرداختی ثبت نشده</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-bolt text-primary mr-2"></i>
                        عملیات سریع
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('panel.projects.finance.incomes', $project) }}" class="btn btn-outline-success btn-block">
                                <i class="fas fa-plus mr-1"></i>
                                ثبت درآمد جدید
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('panel.projects.finance.expenses', $project) }}" class="btn btn-outline-danger btn-block">
                                <i class="fas fa-plus mr-1"></i>
                                ثبت هزینه جدید
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('panel.projects.payments.create', $project) }}" class="btn btn-outline-info btn-block">
                                <i class="fas fa-plus mr-1"></i>
                                ثبت پرداخت جدید
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('panel.projects.finance.profit-loss', $project) }}" class="btn btn-outline-primary btn-block">
                                <i class="fas fa-calculator mr-1"></i>
                                گزارش سود/زیان
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Chart
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyData = @json($monthlyData);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: monthlyData.map(item => item.month_name),
            datasets: [{
                label: 'درآمد',
                data: monthlyData.map(item => item.income),
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4
            }, {
                label: 'هزینه',
                data: monthlyData.map(item => item.expense),
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                tension: 0.4
            }, {
                label: 'سود',
                data: monthlyData.map(item => item.profit),
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection
