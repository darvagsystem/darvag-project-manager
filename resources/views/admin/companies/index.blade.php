@extends('admin.layout')

@section('title', 'مدیریت شرکت‌ها')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">لیست شرکت‌ها</h3>
                    <div>
                        <form action="{{ route('panel.companies.sync-all-sajar') }}" method="POST" class="d-inline me-2" onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید همه شرکت‌ها را از ساجر همگام‌سازی کنید؟')">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-sync"></i> همگام‌سازی از ساجر
                            </button>
                        </form>
                        <a href="{{ route('panel.companies.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> افزودن شرکت
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>نام شرکت</th>
                                    <th>شناسه ملی</th>
                                    <th>شماره ثبت</th>
                                    <th>کد اقتصادی</th>
                                    <th>وضعیت</th>
                                    <th>تاریخ ثبت</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($companies as $company)
                                <tr>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->national_id }}</td>
                                    <td>{{ $company->registration_number ?? '-' }}</td>
                                    <td>{{ $company->economic_code ?? '-' }}</td>
                                    <td>
                                        @if($company->status == 'active')
                                            <span class="badge bg-success">فعال</span>
                                        @elseif($company->status == 'inactive')
                                            <span class="badge bg-secondary">غیرفعال</span>
                                        @else
                                            <span class="badge bg-warning">معلق</span>
                                        @endif
                                    </td>
                                    <td>{{ $company->created_at->format('Y/m/d') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('panel.companies.show', $company) }}" class="btn btn-sm btn-info" title="مشاهده">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('panel.companies.edit', $company) }}" class="btn btn-sm btn-warning" title="ویرایش">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('panel.companies.sync-sajar', $company) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید این شرکت را از ساجر همگام‌سازی کنید؟')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" title="همگام‌سازی از ساجر">
                                                    <i class="fas fa-sync"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('panel.companies.destroy', $company) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا مطمئن هستید؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">هیچ شرکتی ثبت نشده است</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($companies->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $companies->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
