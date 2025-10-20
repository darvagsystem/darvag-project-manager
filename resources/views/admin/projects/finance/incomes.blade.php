@extends('admin.layout')

@section('title', 'درآمدهای پروژه - ' . $project->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-trending-up text-success mr-2"></i>
                        درآمدهای پروژه
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

    <!-- Incomes List -->
    <div class="card shadow-sm">
        <div class="card-header bg-white border-0">
            <h5 class="card-title mb-0 text-dark">
                <i class="fas fa-list text-success mr-2"></i>
                لیست درآمدها
                @if($incomes->total() > 0)
                    <span class="badge badge-light ml-2">{{ $incomes->total() }} درآمد</span>
                @endif
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
                                <th class="border-0 text-center">تاریخ</th>
                                <th class="border-0 text-center">وضعیت</th>
                                <th class="border-0 text-center">شماره مرجع</th>
                                <th class="border-0 text-center">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($incomes as $income)
                                <tr>
                                    <td class="align-middle">
                                        <div>
                                            <div class="font-weight-bold text-dark">{{ $income->title }}</div>
                                            @if($income->description)
                                                <small class="text-muted">{{ Str::limit($income->description, 50) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-info px-2 py-1">{{ $income->type_text }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="font-weight-bold text-success">{{ number_format($income->amount, 0, '.', ',') }}</span>
                                        <br>
                                        <small class="text-muted">{{ $income->currency }}</small>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="text-muted">{{ $income->income_date->format('Y/m/d') }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-{{ $income->status_color }} px-3 py-2">
                                            {{ $income->status_text }}
                                        </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="text-muted">{{ $income->reference_number ?: '-' }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group" role="group">
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-primary"
                                                    title="مشاهده"
                                                    onclick="showIncomeDetails({{ $income->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-warning"
                                                    title="ویرایش">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="حذف"
                                                    onclick="confirmDelete({{ $income->id }}, '{{ $income->title }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center p-3 border-top">
                    <div>
                        <span class="text-muted small">
                            نمایش {{ $incomes->firstItem() }} تا {{ $incomes->lastItem() }} از {{ $incomes->total() }} درآمد
                        </span>
                    </div>
                    <div>
                        {{ $incomes->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-trending-up fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted mb-3">هیچ درآمدی یافت نشد</h5>
                    <p class="text-muted">برای این پروژه هنوز درآمدی ثبت نشده است.</p>
                    <button class="btn btn-success" onclick="showAddIncomeModal()">
                        <i class="fas fa-plus mr-1"></i>
                        ثبت اولین درآمد
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Income Modal -->
<div class="modal fade" id="addIncomeModal" tabindex="-1" aria-labelledby="addIncomeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addIncomeModalLabel">ثبت درآمد جدید</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addIncomeForm" method="POST" action="{{ route('panel.projects.finance.incomes', $project) }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title" class="form-label">عنوان درآمد <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount" class="form-label">مبلغ <span class="text-danger">*</span></label>
                                <input type="number" name="amount" id="amount" class="form-control" step="0.01" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="income_type" class="form-label">نوع درآمد <span class="text-danger">*</span></label>
                                <select name="income_type" id="income_type" class="form-control" required>
                                    <option value="">انتخاب کنید...</option>
                                    <option value="invoice">فاکتور</option>
                                    <option value="advance">پیش‌پرداخت</option>
                                    <option value="milestone">مرحله‌ای</option>
                                    <option value="final">نهایی</option>
                                    <option value="other">سایر</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="income_date" class="form-label">تاریخ درآمد <span class="text-danger">*</span></label>
                                <input type="date" name="income_date" id="income_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">توضیحات</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reference_number" class="form-label">شماره مرجع</label>
                                <input type="text" name="reference_number" id="reference_number" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status" class="form-label">وضعیت</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="pending">در انتظار</option>
                                    <option value="received">دریافت شده</option>
                                    <option value="partial">جزئی</option>
                                    <option value="cancelled">لغو شده</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-success">ثبت درآمد</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Income Details Modal -->
<div class="modal fade" id="incomeDetailsModal" tabindex="-1" aria-labelledby="incomeDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="incomeDetailsModalLabel">جزئیات درآمد</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="incomeDetailsContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">تایید حذف</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>آیا از حذف این درآمد اطمینان دارید؟</p>
                <p class="text-muted small">این عمل قابل بازگشت نیست.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">حذف</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showAddIncomeModal() {
    $('#addIncomeModal').modal('show');
}

function showIncomeDetails(incomeId) {
    // This would typically load income details via AJAX
    $('#incomeDetailsContent').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> در حال بارگذاری...</div>');
    $('#incomeDetailsModal').modal('show');
}

function confirmDelete(incomeId, incomeTitle) {
    document.getElementById('deleteModalLabel').textContent = 'تایید حذف درآمد - ' + incomeTitle;
    document.getElementById('deleteForm').action = '{{ route("panel.projects.finance.incomes", $project) }}/' + incomeId;
    $('#deleteModal').modal('show');
}
</script>
@endsection
