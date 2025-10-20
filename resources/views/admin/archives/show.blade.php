@extends('admin.layout')

@section('title', 'بایگانی: ' . $archive->name)

@push('styles')
<style>
.progress {
    height: 8px;
}

.list-group-item {
    border: 1px solid #dee2e6;
    margin-bottom: 2px;
    border-radius: 6px;
}

.list-group-item.active {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.table th {
    background-color: #f8f9fa;
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.btn-group .btn {
    border-radius: 4px;
    margin-left: 2px;
}

.badge {
    font-size: 0.75em;
    padding: 0.5em 0.75em;
}

.modal.show {
    display: block !important;
    background-color: rgba(0,0,0,0.5);
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="page-title">بایگانی: {{ $archive->name }}</h1>
                        <p class="page-subtitle">{{ $archive->project->name }}</p>
                    </div>
                    <div>
                        <a href="{{ route('archives.edit', $archive) }}" class="btn btn-warning me-2">
                            <i class="mdi mdi-pencil"></i> ویرایش
                        </a>
                        <a href="{{ route('archives.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> بازگشت
                        </a>
                    </div>
                </div>
            </div>

            <!-- Archive Info Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title">اطلاعات بایگانی</h5>
                            <p class="card-text">{{ $archive->description }}</p>
                            <div class="d-flex gap-3">
                                <small class="text-muted">
                                    <i class="mdi mdi-calendar"></i>
                                    ایجاد شده: {{ \App\Helpers\DateHelper::toPersianDateTime($archive->created_at) }}
                                </small>
                                <small class="text-muted">
                                    <i class="mdi mdi-account"></i>
                                    توسط: {{ $archive->creator->name }}
                                </small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h6>وضعیت تکمیل</h6>
                                <div class="progress mb-2" style="height: 12px;">
                                    <div class="progress-bar bg-{{ $archive->is_complete ? 'success' : 'warning' }}"
                                         style="width: {{ $archive->getCompletionPercentage() }}%"></div>
                                </div>
                                <span class="badge bg-{{ $archive->is_complete ? 'success' : 'warning' }} fs-6">
                                    {{ $archive->getCompletionPercentage() }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Livewire Component -->
            @livewire('archive-management-component', ['archive' => $archive])
        </div>
    </div>
</div>
@endsection
