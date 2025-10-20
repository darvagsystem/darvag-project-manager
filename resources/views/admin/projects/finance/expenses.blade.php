@extends('admin.layout')

@section('title', 'هزینه‌های پروژه - ' . $project->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-trending-down text-danger mr-2"></i>
                        هزینه‌های پروژه
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

    <!-- Expenses List -->
    <div class="card shadow-sm">
        <div class="card-header bg-white border-0">
            <h5 class="card-title mb-0 text-dark">
                <i class="fas fa-list text-danger mr-2"></i>
                لیست هزینه‌ها
                @if($expenses->total() > 0)
                    <span class="badge badge-light ml-2">{{ $expenses->total() }} هزینه</span>
                @endif
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
                                <th class="border-0 text-center">دسته‌بندی</th>
                                <th class="border-0 text-center">مبلغ</th>
                                <th class="border-0 text-center">تاریخ</th>
                                <th class="border-0 text-center">وضعیت</th>
                                <th class="border-0 text-center">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenses as $expense)
                                <tr>
                                    <td class="align-middle">
                                        <div>
                                            <div class="font-weight-bold text-dark">{{ $expense->title }}</div>
                                            @if($expense->description)
                                                <small class="text-muted">{{ Str::limit($expense->description, 50) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-info px-2 py-1">{{ $expense->type_text }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-secondary px-2 py-1">{{ $expense->category_text }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="font-weight-bold text-danger">{{ number_format($expense->amount, 0, '.', ',') }}</span>
                                        <br>
                                        <small class="text-muted">{{ $expense->currency }}</small>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="text-muted">{{ $expense->expense_date->format('Y/m/d') }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-{{ $expense->status_color }} px-3 py-2">
                                            {{ $expense->status_text }}
                                        </span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group" role="group">
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-primary"
                                                    title="مشاهده"
                                                    onclick="showExpenseDetails({{ $expense->id }})">
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
                                                    onclick="confirmDelete({{ $expense->id }}, '{{ $expense->title }}')">
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
                            نمایش {{ $expenses->firstItem() }} تا {{ $expenses->lastItem() }} از {{ $expenses->total() }} هزینه
                        </span>
                    </div>
                    <div>
                        {{ $expenses->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-trending-down fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted mb-3">هیچ هزینه‌ای یافت نشد</h5>
                    <p class="text-muted">برای این پروژه هنوز هزینه‌ای ثبت نشده است.</p>
                    <button class="btn btn-danger" onclick="showAddExpenseModal()">
                        <i class="fas fa-plus mr-1"></i>
                        ثبت اولین هزینه
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Expense Modal -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExpenseModalLabel">ثبت هزینه جدید</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addExpenseForm" method="POST" action="{{ route('panel.projects.finance.expenses', $project) }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title" class="form-label">عنوان هزینه <span class="text-danger">*</span></label>
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
                                <label for="expense_type" class="form-label">نوع هزینه <span class="text-danger">*</span></label>
                                <select name="expense_type" id="expense_type" class="form-control" required>
                                    <option value="">انتخاب کنید...</option>
                                    <option value="material">مواد</option>
                                    <option value="labor">دستمزد</option>
                                    <option value="equipment">تجهیزات</option>
                                    <option value="transportation">حمل و نقل</option>
                                    <option value="utilities">آب و برق</option>
                                    <option value="rent">اجاره</option>
                                    <option value="other">سایر</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category" class="form-label">دسته‌بندی <span class="text-danger">*</span></label>
                                <select name="category" id="category" class="form-control" required>
                                    <option value="">انتخاب کنید...</option>
                                    <option value="operational">عملیاتی</option>
                                    <option value="administrative">اداری</option>
                                    <option value="marketing">بازاریابی</option>
                                    <option value="maintenance">نگهداری</option>
                                    <option value="other">سایر</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="expense_date" class="form-label">تاریخ هزینه <span class="text-danger">*</span></label>
                                <input type="date" name="expense_date" id="expense_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status" class="form-label">وضعیت</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="pending">در انتظار</option>
                                    <option value="approved">تایید شده</option>
                                    <option value="paid">پرداخت شده</option>
                                    <option value="cancelled">لغو شده</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">توضیحات</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="reference_number" class="form-label">شماره مرجع</label>
                        <input type="text" name="reference_number" id="reference_number" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-danger">ثبت هزینه</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Expense Details Modal -->
<div class="modal fade" id="expenseDetailsModal" tabindex="-1" aria-labelledby="expenseDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="expenseDetailsModalLabel">جزئیات هزینه</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="expenseDetailsContent">
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
                <p>آیا از حذف این هزینه اطمینان دارید؟</p>
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
function showAddExpenseModal() {
    $('#addExpenseModal').modal('show');
}

function showExpenseDetails(expenseId) {
    // This would typically load expense details via AJAX
    $('#expenseDetailsContent').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> در حال بارگذاری...</div>');
    $('#expenseDetailsModal').modal('show');
}

function confirmDelete(expenseId, expenseTitle) {
    document.getElementById('deleteModalLabel').textContent = 'تایید حذف هزینه - ' + expenseTitle;
    document.getElementById('deleteForm').action = '{{ route("panel.projects.finance.expenses", $project) }}/' + expenseId;
    $('#deleteModal').modal('show');
}
</script>
@endsection
