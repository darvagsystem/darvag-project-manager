@extends('admin.layout')

@section('title', 'مدیریت پروژه‌ها')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">مدیریت پروژه‌ها</h1>
            <p class="page-subtitle">لیست پروژه‌ها و قراردادهای شرکت</p>
        </div>
        <a href="{{ route('panel.projects.create') }}" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            افزودن پروژه جدید
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid" style="grid-template-columns: repeat(4, 1fr); margin-bottom: 30px;">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ count($projects) }}</div>
        <div class="stat-label">کل پروژه‌ها</div>
    </div>

    <div class="stat-card success">
        <div class="stat-header">
            <div class="stat-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ collect($projects)->where('status', 'in_progress')->count() }}</div>
        <div class="stat-label">در حال اجرا</div>
    </div>

    <div class="stat-card accent">
        <div class="stat-header">
            <div class="stat-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ collect($projects)->where('status', 'completed')->count() }}</div>
        <div class="stat-label">تکمیل شده</div>
    </div>

    <div class="stat-card warning">
        <div class="stat-header">
            <div class="stat-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ number_format(collect($projects)->sum('final_amount') / 1000000000, 0) }}B</div>
        <div class="stat-label">کل مبلغ (میلیارد)</div>
    </div>
</div>

<!-- Projects Table -->
<div class="content-card">
    <div class="card-header">
        <div>
            <h3 class="card-title">لیست پروژه‌ها</h3>
            <p class="card-subtitle">مدیریت پروژه‌ها و قراردادهای شرکت</p>
        </div>
        <div class="filter-buttons">
            <button class="filter-btn active" data-status="all">همه</button>
            <button class="filter-btn" data-status="in_progress">در حال اجرا</button>
            <button class="filter-btn" data-status="completed">تکمیل شده</button>
            <button class="filter-btn" data-status="paused">متوقف</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="projects-table">
                <thead>
                    <tr>
                        <th>پروژه</th>
                        <th>کارفرما</th>
                        <th>مبالغ قرارداد</th>
                        <th>زمان‌بندی</th>
                        <th>وضعیت</th>
                        <th>پیشرفت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                    <tr class="project-row" data-status="{{ $project->status }}">
                        <td>
                            <div class="project-info">
                                <div class="project-icon">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div class="project-details">
                                    <div class="project-name">{{ $project->name }}</div>
                                    <div class="contract-number">{{ $project->contract_number }}</div>
                                    <div class="project-department">{{ $project->department }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="client-info">
                                <div class="client-name">{{ $project->client->name }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="amounts-info">
                                <div class="amount-item">
                                    <span class="amount-label">برآورد اولیه:</span>
                                    <span class="amount-value">{{ number_format($project->initial_estimate) }}</span>
                                </div>
                                <div class="amount-item">
                                    <span class="amount-label">مبلغ نهایی:</span>
                                    <span class="amount-value final">{{ number_format($project->final_amount) }}</span>
                                </div>
                                <div class="amount-item">
                                    <span class="amount-label">ضریب:</span>
                                    <span class="coefficient">{{ $project->contract_coefficient }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="timeline-info">
                                <div class="timeline-item">
                                    <span class="timeline-label">شروع قرارداد:</span>
                                    <span class="timeline-date">{{ $project->contract_start_date }}</span>
                                </div>
                                <div class="timeline-item">
                                    <span class="timeline-label">پایان قرارداد:</span>
                                    <span class="timeline-date">{{ $project->contract_end_date }}</span>
                                </div>
                                @if($project->actual_start_date)
                                <div class="timeline-item">
                                    <span class="timeline-label">شروع واقعی:</span>
                                    <span class="timeline-date actual">{{ $project->actual_start_date }}</span>
                                </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="project-status status-{{ $project->status }}">
                                @if($project->status === 'in_progress')
                                    در حال اجرا
                                @elseif($project->status === 'completed')
                                    تکمیل شده
                                @elseif($project->status === 'paused')
                                    متوقف شده
                                @else
                                    {{ $project->status }}
                                @endif
                            </span>
                        </td>
                        <td>
                            <div class="progress-info">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $project->progress }}%"></div>
                                </div>
                                <span class="progress-text">{{ $project->progress }}%</span>
                            </div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('panel.projects.show', $project->id) }}" class="btn btn-sm btn-view" title="مشاهده پروفایل">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('panel.projects.edit', $project->id) }}" class="btn btn-sm btn-edit" title="ویرایش">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <button class="btn btn-sm btn-delete" title="حذف" onclick="deleteProject({{ $project->id }}, '{{ $project->name }}')">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.btn {
    display: inline-flex;
    align-items: center;
    padding: 12px 20px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

.filter-buttons {
    display: flex;
    gap: 10px;
}

.filter-btn {
    padding: 8px 16px;
    border: 1px solid var(--border-light);
    background: white;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
}

.filter-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.filter-btn:hover {
    background: var(--primary-light);
    color: var(--primary-color);
}

.table-responsive {
    overflow-x: auto;
}

.projects-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.projects-table th,
.projects-table td {
    padding: 15px;
    text-align: right;
    border-bottom: 1px solid var(--border-light);
    vertical-align: top;
}

.projects-table th {
    background: var(--bg-light);
    font-weight: 600;
    color: var(--text-light);
    font-size: 14px;
}

.projects-table tr:hover {
    background: var(--bg-light);
}

.project-info {
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.project-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: var(--primary-light);
    color: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.project-details {
    flex: 1;
    min-width: 200px;
}

.project-name {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 4px;
    line-height: 1.3;
}

.contract-number {
    font-size: 12px;
    color: var(--text-light);
    margin-bottom: 6px;
    font-family: monospace;
}

.project-department {
    font-size: 12px;
    color: var(--accent-color);
    background: var(--accent-light);
    padding: 2px 8px;
    border-radius: 10px;
    display: inline-block;
}

.client-info {
    min-width: 120px;
}

.client-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-dark);
}

.amounts-info {
    display: flex;
    flex-direction: column;
    gap: 8px;
    min-width: 150px;
}

.amount-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
}

.amount-label {
    font-size: 11px;
    color: var(--text-light);
    flex-shrink: 0;
}

.amount-value {
    font-size: 12px;
    font-weight: 600;
    color: var(--text-dark);
    text-align: left;
    font-family: monospace;
}

.amount-value.final {
    color: var(--primary-color);
}

.coefficient {
    font-size: 12px;
    font-weight: 700;
    color: var(--accent-color);
    background: var(--accent-light);
    padding: 2px 6px;
    border-radius: 4px;
    font-family: monospace;
}

.timeline-info {
    display: flex;
    flex-direction: column;
    gap: 6px;
    min-width: 140px;
}

.timeline-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
}

.timeline-label {
    font-size: 11px;
    color: var(--text-light);
    flex-shrink: 0;
}

.timeline-date {
    font-size: 11px;
    color: var(--text-dark);
    font-family: monospace;
}

.timeline-date.actual {
    color: var(--success-color);
    font-weight: 600;
}

.project-status {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-align: center;
    min-width: 80px;
}

.status-in_progress {
    background: rgba(33, 150, 243, 0.1);
    color: var(--primary-color);
}

.status-completed {
    background: rgba(0, 200, 83, 0.1);
    color: var(--success-color);
}

.status-paused {
    background: rgba(255, 180, 0, 0.1);
    color: var(--warning-color);
}

.progress-info {
    display: flex;
    flex-direction: column;
    gap: 8px;
    min-width: 80px;
}

.progress-bar {
    width: 100%;
    height: 8px;
    background: var(--border-light);
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-color), var(--success-color));
    transition: width 0.3s ease;
}

.progress-text {
    font-size: 12px;
    font-weight: 600;
    color: var(--text-dark);
    text-align: center;
}

.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-sm {
    padding: 8px;
    border-radius: 6px;
    font-size: 12px;
}

.btn-edit {
    background: var(--primary-light);
    color: var(--primary-color);
}

.btn-edit:hover {
    background: var(--primary-color);
    color: white;
}

.btn-view {
    background: var(--accent-light);
    color: var(--accent-color);
}

.btn-view:hover {
    background: var(--accent-color);
    color: white;
}

.btn-delete {
    background: rgba(244, 67, 54, 0.1);
    color: var(--error-color);
}

.btn-delete:hover {
    background: var(--error-color);
    color: white;
}

@media (max-width: 768px) {
    .projects-table {
        font-size: 12px;
    }

    .project-info {
        flex-direction: column;
        gap: 10px;
    }

    .amounts-info,
    .timeline-info {
        min-width: auto;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const projectRows = document.querySelectorAll('.project-row');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const status = this.dataset.status;

            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Filter rows
            projectRows.forEach(row => {
                if (status === 'all' || row.dataset.status === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
});

function deleteProject(projectId, projectName) {
    if (confirm(`آیا از حذف پروژه "${projectName}" اطمینان دارید؟ این عملیات غیرقابل بازگشت است.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/projects/${projectId}`;

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';

        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
