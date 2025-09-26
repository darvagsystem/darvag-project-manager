@extends('admin.layout')

@section('title', 'مدیریت بانک‌ها')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">مدیریت بانک‌ها</h1>
            <p class="page-subtitle">مدیریت و تنظیمات بانک‌های سیستم</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.settings.banks.create') }}" class="btn btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                افزودن بانک جدید
            </a>
            @if($banks->count() == 0)
            <form action="{{ route('admin.settings.banks.seed') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-secondary" onclick="return confirm('آیا می‌خواهید بانک‌های پیش‌فرض ایران را اضافه کنید؟')">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    افزودن بانک‌های پیش‌فرض
                </button>
            </form>
            @endif
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger mb-4">
        {{ session('error') }}
    </div>
@endif

<div class="content-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="card-title">لیست بانک‌ها</h3>
                <p class="card-subtitle">مجموع {{ count($banks) }} بانک</p>
            </div>
            <a href="{{ route('admin.settings.banks.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                افزودن بانک جدید
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        @if($banks->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="60">لوگو</th>
                            <th>نام بانک</th>
                            <th width="100">وضعیت</th>
                            <th width="150">تاریخ ایجاد</th>
                            <th width="120">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banks as $bank)
                            <tr>
                                <td>
                                    @if($bank->logo)
                                        <img src="{{ asset('storage/' . $bank->logo) }}" alt="{{ $bank->name }}" class="bank-logo">
                                    @else
                                        <div class="bank-logo-placeholder">
                                            <i class="fas fa-university"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="bank-name">{{ $bank->name }}</div>
                                </td>
                                <td>
                                    <span class="badge {{ $bank->is_active ? 'badge-success' : 'badge-secondary' }}">
                                        {{ $bank->is_active ? 'فعال' : 'غیرفعال' }}
                                    </span>
                                </td>
                                <td class="text-muted">
                                    {{ $bank->created_at->format('Y/m/d') }}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.settings.banks.edit', $bank->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.settings.banks.destroy', $bank->id) }}" style="display: inline;"
                                              onsubmit="return confirm('آیا از حذف این بانک اطمینان دارید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state p-5">
                <div class="empty-state-icon">
                    <i class="fas fa-university"></i>
                </div>
                <h3>هیچ بانکی یافت نشد</h3>
                <p>برای شروع، یک بانک جدید اضافه کنید</p>
                <a href="{{ route('admin.settings.banks.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    افزودن بانک جدید
                </a>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.bank-logo {
    width: 40px;
    height: 40px;
    object-fit: contain;
    border-radius: 8px;
    border: 1px solid var(--border-light);
}

.bank-logo-placeholder {
    width: 40px;
    height: 40px;
    background: var(--bg-light);
    border: 1px solid var(--border-light);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-light);
}

.bank-name {
    font-weight: 600;
    color: var(--text-dark);
}

.badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-success {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-color);
}

.badge-secondary {
    background: var(--bg-light);
    color: var(--text-light);
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    background: var(--primary-light);
    color: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 32px;
}

.empty-state h3 {
    color: var(--text-dark);
    margin-bottom: 10px;
}

.empty-state p {
    color: var(--text-light);
    margin-bottom: 30px;
}

.alert {
    padding: 16px 20px;
    border-radius: 8px;
    border: none;
    margin-bottom: 20px;
}

.alert-success {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-color);
}

.alert-danger {
    background: rgba(239, 68, 68, 0.1);
    color: var(--error-color);
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 16px 20px;
    text-align: right;
    border-bottom: 1px solid var(--border-light);
}

.table th {
    background: var(--bg-light);
    font-weight: 600;
    color: var(--text-dark);
    font-size: 14px;
}

.table tr:hover {
    background: var(--bg-light);
}

.btn-group {
    display: flex;
    gap: 5px;
}
</style>
@endpush
@endsection
