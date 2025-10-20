@extends('admin.layout')

@section('title', 'گزارش سود/زیان - ' . $project->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-calculator text-primary mr-2"></i>
                        گزارش سود/زیان پروژه
                    </h1>
                    <p class="text-muted mb-0">{{ $project->name }} - {{ $project->contract_number }}</p>
                </div>
                <div>
                    <a href="{{ route('panel.projects.finance.dashboard', $project) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right mr-1"></i>
                        بازگشت به داشبورد
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Date Filter -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('panel.projects.finance.profit-loss', $project) }}">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">تاریخ شروع</label>
                        <input type="date" name="start_date" id="start_date" class="form-control"
                               value="{{ $startDate->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">تاریخ پایان</label>
                        <input type="date" name="end_date" id="end_date" class="form-control"
                               value="{{ $endDate->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search mr-1"></i>
                            فیلتر
                        </button>
                    </div>
                    <div class="col-md-3 text-left">
                        <a href="{{ route('panel.projects.finance.profit-loss', $project) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-refresh mr-1"></i>
                            بازنشانی
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-success text-white shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-trending-up fa-2x mb-2 opacity-75"></i>
                    <div class="h4 mb-0">{{ number_format($totalIncome, 0, '.', ',') }}</div>
                    <div class="text-white-50 small">کل درآمد</div>
                    <div class="text-white-50 small">{{ $incomes->where('status', 'received')->count() }} مورد دریافت شده</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-danger text-white shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-trending-down fa-2x mb-2 opacity-75"></i>
                    <div class="h4 mb-0">{{ number_format($totalExpenses, 0, '.', ',') }}</div>
                    <div class="text-white-50 small">کل هزینه‌ها</div>
                    <div class="text-white-50 small">{{ $expenses->where('status', 'paid')->count() }} مورد پرداخت شده</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-info text-white shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-credit-card fa-2x mb-2 opacity-75"></i>
                    <div class="h4 mb-0">{{ number_format($totalPayments, 0, '.', ',') }}</div>
                    <div class="text-white-50 small">کل پرداخت‌ها</div>
                    <div class="text-white-50 small">{{ $payments->where('status', 'completed')->count() }} مورد تکمیل شده</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card {{ $netProfit >= 0 ? 'bg-success' : 'bg-warning' }} text-white shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calculator fa-2x mb-2 opacity-75"></i>
                    <div class="h4 mb-0">{{ number_format($netProfit, 0, '.', ',') }}</div>
                    <div class="text-white-50 small">{{ $netProfit >= 0 ? 'سود خالص' : 'زیان خالص' }}</div>
                    <div class="text-white-50 small">
                        @if($totalIncome > 0)
                            {{ number_format(($netProfit / $totalIncome) * 100, 1) }}% حاشیه
                        @else
                            0% حاشیه
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Incomes Table -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-trending-up text-success mr-2"></i>
                        درآمدها ({{ $incomes->count() }} مورد)
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($incomes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0">عنوان</th>
                                        <th class="border-0 text-center">نوع</th>
                                        <th class="border-0 text-center">مبلغ</th>
                                        <th class="border-0 text-center">وضعیت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($incomes as $income)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="font-weight-bold text-dark">{{ $income->title }}</div>
                                                <small class="text-muted">{{ $income->income_date->format('Y/m/d') }}</small>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="badge badge-info px-2 py-1">{{ $income->type_text }}</span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="font-weight-bold text-success">{{ number_format($income->amount, 0, '.', ',') }}</span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="badge badge-{{ $income->status_color }} px-2 py-1">
                                                    {{ $income->status_text }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-trending-up fa-3x text-muted mb-2"></i>
                            <p class="text-muted">هیچ درآمدی در این بازه زمانی یافت نشد</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Expenses Table -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-trending-down text-danger mr-2"></i>
                        هزینه‌ها ({{ $expenses->count() }} مورد)
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($expenses->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0">عنوان</th>
                                        <th class="border-0 text-center">نوع</th>
                                        <th class="border-0 text-center">مبلغ</th>
                                        <th class="border-0 text-center">وضعیت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expenses as $expense)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="font-weight-bold text-dark">{{ $expense->title }}</div>
                                                <small class="text-muted">{{ $expense->expense_date->format('Y/m/d') }}</small>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="badge badge-info px-2 py-1">{{ $expense->type_text }}</span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="font-weight-bold text-danger">{{ number_format($expense->amount, 0, '.', ',') }}</span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="badge badge-{{ $expense->status_color }} px-2 py-1">
                                                    {{ $expense->status_text }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-trending-down fa-3x text-muted mb-2"></i>
                            <p class="text-muted">هیچ هزینه‌ای در این بازه زمانی یافت نشد</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-credit-card text-info mr-2"></i>
                        پرداخت‌ها ({{ $payments->count() }} مورد)
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($payments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0">دریافت‌کننده</th>
                                        <th class="border-0 text-center">نوع پرداخت</th>
                                        <th class="border-0 text-center">مبلغ</th>
                                        <th class="border-0 text-center">تاریخ</th>
                                        <th class="border-0 text-center">وضعیت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-2"
                                                         style="width: 35px; height: 35px; font-size: 14px; font-weight: bold;">
                                                        {{ substr($payment->recipient->recipient_name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="font-weight-bold text-dark">{{ $payment->recipient->recipient_name }}</div>
                                                        <small class="text-muted">{{ $payment->recipient->recipient_code }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
                                                @if($payment->paymentType)
                                                    <span class="badge" style="background-color: {{ $payment->paymentType->color }}; color: white;">
                                                        {{ $payment->paymentType->name }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-secondary">نامشخص</span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="font-weight-bold text-dark">{{ number_format($payment->amount, 0, '.', ',') }}</span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="text-muted">{{ $payment->payment_date->format('Y/m/d') }}</span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="badge badge-{{ $payment->status_color }} px-2 py-1">
                                                    {{ $payment->status_text }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-credit-card fa-3x text-muted mb-2"></i>
                            <p class="text-muted">هیچ پرداختی در این بازه زمانی یافت نشد</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Print Button -->
    <div class="row mt-4">
        <div class="col-12 text-center">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print mr-1"></i>
                چاپ گزارش
            </button>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .card-header, .modal, .navbar, .sidebar {
        display: none !important;
    }

    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
    }

    .container-fluid {
        padding: 0 !important;
    }

    .row {
        margin: 0 !important;
    }

    .col-lg-3, .col-lg-6, .col-md-6, .col-12 {
        padding: 5px !important;
    }

    .card-body {
        padding: 10px !important;
    }

    .table {
        font-size: 12px !important;
    }

    .h3, .h4, .h5 {
        margin: 5px 0 !important;
    }
}
</style>
@endsection
