@extends('admin.layout')

@section('title', 'جزئیات پروژه - ' . $project->name)

@section('content')
    <div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
            <h1 class="page-title">{{ $project->name }}</h1>
            <p class="page-subtitle">{{ $project->contract_number }} - {{ $project->department }}</p>
            </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                بازگشت
            </a>
            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                ویرایش پروژه
            </a>
        </div>
        </div>
    </div>

<!-- Project Stats -->
<div class="stats-grid" style="grid-template-columns: repeat(4, 1fr); margin-bottom: 30px;">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
        <div class="stat-value">{{ $project->progress }}%</div>
        <div class="stat-label">پیشرفت پروژه</div>
            </div>

            <div class="stat-card success">
                <div class="stat-header">
                    <div class="stat-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
        <div class="stat-value">{{ number_format($project->initial_estimate) }}</div>
        <div class="stat-label">بودجه اولیه ({{ $project->currency }})</div>
            </div>

            <div class="stat-card warning">
                <div class="stat-header">
                    <div class="stat-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
        <div class="stat-value">{{ $project->contract_start_date }}</div>
        <div class="stat-label">تاریخ شروع</div>
            </div>

            <div class="stat-card info">
                <div class="stat-header">
                    <div class="stat-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
        <div class="stat-value">{{ $project->contract_end_date }}</div>
        <div class="stat-label">تاریخ پایان</div>
            </div>
        </div>

    <!-- Project Details with Tabs -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="projectTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                                <i class="mdi mdi-information me-1"></i>
                                اطلاعات کلی
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab">
                                <i class="mdi mdi-folder me-1"></i>
                                فایل‌های پروژه
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="employees-tab" data-bs-toggle="tab" data-bs-target="#employees" type="button" role="tab">
                                <i class="mdi mdi-account-group me-1"></i>
                                کارمندان پروژه
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="projectTabsContent">
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">اطلاعات قرارداد</h6>
                                    <div class="info-item">
                                        <span class="info-label">شماره قرارداد:</span>
                                        <span class="info-value">{{ $project->contract_number }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">مبلغ اولیه:</span>
                                        <span class="info-value">{{ number_format($project->initial_estimate) }} {{ $project->currency }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">مبلغ نهایی:</span>
                                        <span class="info-value">{{ number_format($project->final_amount) }} {{ $project->currency }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">ضریب قرارداد:</span>
                                        <span class="info-value">{{ $project->contract_coefficient }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">اطلاعات زمانی</h6>
                                    <div class="info-item">
                                        <span class="info-label">تاریخ شروع قرارداد:</span>
                                        <span class="info-value">{{ $project->contract_start_date }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">تاریخ پایان قرارداد:</span>
                                        <span class="info-value">{{ $project->contract_end_date }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">تاریخ شروع واقعی:</span>
                                        <span class="info-value">{{ $project->actual_start_date ?? 'شروع نشده' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">تاریخ پایان واقعی:</span>
                                        <span class="info-value">{{ $project->actual_end_date ?? 'در حال انجام' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Client Information -->
                            <div class="info-section mt-4">
                                <h6 class="text-muted mb-3">اطلاعات کارفرما</h6>
                                <div class="info-item">
                                    <span class="info-label">نام کارفرما:</span>
                                    <span class="info-value">{{ $project->client->name ?? 'نامشخص' }}</span>
                                </div>
                                @if($project->client)
                                <div class="info-item">
                                    <span class="info-label">وضعیت کارفرما:</span>
                                    <span class="info-value" style="color: {{ $project->client->status === 'active' ? '#10b981' : '#ef4444' }};">
                                        {{ $project->client->formatted_status }}
                                    </span>
                                </div>
                                @endif
                            </div>

                            <!-- Progress Section -->
                            <div class="info-section mt-4">
                                <h6 class="text-muted mb-3">پیشرفت پروژه</h6>
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="flex: 1; height: 12px; background: #e2e8f0; border-radius: 6px; overflow: hidden;">
                                        <div style="height: 100%; background: linear-gradient(90deg, #3b82f6, #10b981); width: {{ $project->progress }}%; transition: width 1s ease; border-radius: 6px;"></div>
                                    </div>
                                    <span style="font-weight: 700; color: #374151; min-width: 50px; text-align: center;">{{ $project->progress }}%</span>
                                </div>
                            </div>

                            <!-- Description and Notes -->
                            @if($project->description || $project->notes)
                            <div class="mt-4">
                                @if($project->description)
                                <div class="mb-3">
                                    <h6 class="text-muted mb-2">توضیحات پروژه:</h6>
                                    <div class="info-section">
                                        {{ $project->description }}
                                    </div>
                                </div>
                                @endif
                                @if($project->notes)
                                <div>
                                    <h6 class="text-muted mb-2">یادداشت‌ها:</h6>
                                    <div class="info-section">
                                        {{ $project->notes }}
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>

                        <!-- Files Tab -->
                        <div class="tab-pane fade" id="files" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">ساختار پوشه‌های پروژه</h6>
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-primary me-2" id="copyStructureBtn">
                                        <i class="mdi mdi-content-copy me-1"></i>
                                        کپی ساختار از پروژه دیگر
                                    </button>
                                    <a href="{{ route('projects.filemanager.index', $project->id) }}" class="btn btn-sm btn-primary">
                                        <i class="mdi mdi-folder-open me-1"></i>
                                        باز کردن فایل منیجر
                                    </a>
                                </div>
                            </div>

                            <!-- Folder Structure -->
                            <div class="row">
                                <div class="col-12">
                                    @livewire('project-folder-structure', ['projectId' => $project->id])
                                </div>
                            </div>
                        </div>

                        <!-- Employees Tab -->
                        <div class="tab-pane fade" id="employees" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">کارمندان پروژه</h6>
                                <div>
                                    <a href="{{ route('projects.employees.create', $project) }}" class="btn btn-sm btn-primary me-2">
                                        <i class="mdi mdi-account-plus me-1"></i>
                                        افزودن کارمند
                                    </a>
                                    <a href="{{ route('projects.employees.index', $project) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="mdi mdi-account-group me-1"></i>
                                        مشاهده همه
                                    </a>
                                </div>
                            </div>

                            @php
                                $projectEmployees = $project->projectEmployees()->with('employee')->limit(5)->get();
                            @endphp

                            @if($projectEmployees->count() > 0)
                                <div class="row">
                                    @foreach($projectEmployees as $projectEmployee)
                                    <div class="col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3">
                                                        <i class="mdi mdi-account" style="font-size: 24px; color: #6c757d;"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">{{ $projectEmployee->employee->full_name }}</h6>
                                                        <p class="text-muted mb-1">{{ $projectEmployee->employee->employee_code }}</p>
                                                        <span class="badge {{ $projectEmployee->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                            {{ $projectEmployee->is_active ? 'فعال' : 'غیرفعال' }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('projects.employees.edit', [$project, $projectEmployee]) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="mdi mdi-pencil"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="mdi mdi-account-group" style="font-size: 48px; color: #6c757d;"></i>
                                    <h6 class="mt-2">هنوز کارمندی به این پروژه اختصاص داده نشده</h6>
                                    <p class="text-muted">برای شروع، اولین کارمند را به پروژه اضافه کنید</p>
                                    <a href="{{ route('projects.employees.create', $project) }}" class="btn btn-primary">
                                        <i class="mdi mdi-account-plus me-1"></i>
                                        افزودن اولین کارمند
                                    </a>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Copy Structure Modal -->
<div class="modal fade" id="copyStructureModal" tabindex="-1" aria-labelledby="copyStructureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="copyStructureModalLabel">کپی ساختار پوشه‌بندی</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="copyStructureForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="sourceProject" class="form-label">انتخاب پروژه مبدأ</label>
                        <select class="form-select" id="sourceProject" name="source_project_id" required>
                            <option value="">پروژه مورد نظر را انتخاب کنید</option>
                            <!-- Options will be populated by JavaScript -->
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <i class="mdi mdi-information me-2"></i>
                        ساختار پوشه‌بندی پروژه انتخاب شده (بدون فایل‌ها) به این پروژه کپی خواهد شد.
                    </div>
                    <div id="structurePreview" class="mt-3" style="display: none;">
                        <h6>پیش‌نمایش ساختار:</h6>
                        <div id="structureTree" class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                            <!-- Structure will be loaded here -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-primary">کپی ساختار</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
@livewireStyles
<style>
.folder-structure-container {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.folder-tree {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.folder-item {
    margin-bottom: 8px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.folder-item:hover {
    background: #f8f9fa;
}

.folder-header {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    cursor: pointer;
    border-radius: 8px;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.folder-header:hover {
    background: #e3f2fd;
    border-color: #2196f3;
    transform: translateX(4px);
}

.folder-header.expanded {
    background: #e8f5e8;
    border-color: #4caf50;
}

.folder-icon {
    font-size: 20px;
    margin-left: 12px;
    color: #ff9800;
    transition: transform 0.3s ease;
}

.folder-header.expanded .folder-icon {
    transform: rotate(90deg);
}

.folder-info {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.folder-name {
    font-weight: 600;
    color: #333;
    margin-bottom: 4px;
    font-size: 15px;
}

.folder-stats {
    display: flex;
    gap: 16px;
    font-size: 12px;
    color: #666;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 4px;
}

.stat-icon {
    font-size: 14px;
}

.folder-children {
    margin-right: 32px;
    border-right: 2px solid #e0e0e0;
    padding-right: 16px;
    margin-top: 8px;
}

.folder-children .folder-item {
    margin-bottom: 6px;
}

.empty-structure {
    text-align: center;
    padding: 40px 20px;
}

.empty-icon {
    font-size: 64px;
    color: #ccc;
    margin-bottom: 16px;
}

.empty-structure h6 {
    color: #666;
    margin-bottom: 8px;
}

.empty-structure p {
    margin-bottom: 20px;
}

.chevron-icon {
    font-size: 16px;
    color: #999;
    transition: transform 0.3s ease;
}

.folder-header.expanded .chevron-icon {
    transform: rotate(90deg);
}

/* Responsive */
@media (max-width: 768px) {
    .folder-structure-container {
        padding: 15px;
    }

    .folder-header {
        padding: 10px 12px;
    }

    .folder-name {
        font-size: 14px;
    }

    .folder-stats {
        flex-direction: column;
        gap: 4px;
    }

    .folder-children {
        margin-right: 20px;
        padding-right: 12px;
    }
}
</style>
@endpush

@push('scripts')
@livewireScripts
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Copy Structure Button
    document.getElementById('copyStructureBtn')?.addEventListener('click', function() {
        loadProjects();
        new bootstrap.Modal(document.getElementById('copyStructureModal')).show();
    });

    // Load projects for copy structure
    function loadProjects() {
        fetch('{{ route("panel.api.projects") }}')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('sourceProject');
                select.innerHTML = '<option value="">پروژه مورد نظر را انتخاب کنید</option>';

                data.projects.forEach(project => {
                    if (project.id !== {{ $project->id }}) { // Exclude current project
                        const option = document.createElement('option');
                        option.value = project.id;
                        option.textContent = project.name;
                        select.appendChild(option);
                    }
                });
            })
            .catch(error => {
                console.error('Error loading projects:', error);
            });
    }

    // Source project change handler
    document.getElementById('sourceProject')?.addEventListener('change', function() {
        const projectId = this.value;
        const preview = document.getElementById('structurePreview');

        if (projectId) {
            // Load structure preview
            loadStructurePreview(projectId);
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    });

    // Load structure preview
    function loadStructurePreview(projectId) {
        // This would load the folder structure from the selected project
        // For now, we'll show a placeholder
        document.getElementById('structureTree').innerHTML = '<p class="text-muted">در حال بارگذاری ساختار...</p>';
    }

    // Copy structure form submission
    document.getElementById('copyStructureForm')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append('target_project_id', '{{ $project->id }}');

        fetch('{{ route("admin.project-templates.create-from-project") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('ساختار پوشه‌بندی با موفقیت کپی شد!');
                bootstrap.Modal.getInstance(document.getElementById('copyStructureModal')).hide();
                // Refresh the page or update the file manager
                location.reload();
            } else {
                alert('خطا در کپی کردن ساختار: ' + (data.message || 'خطای نامشخص'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('خطا در کپی کردن ساختار');
        });
    });
});
</script>
@endpush

<style>
.info-section {
    background: #f8fafc;
    padding: 1.5rem;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
}

.info-grid {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 1rem;
    background: white;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    transition: all 0.2s ease;
}

.info-item:hover {
    background: #f1f5f9;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.info-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
}

.info-value {
    font-size: 0.875rem;
    color: #111827;
    font-weight: 600;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-in_progress {
    background: #dbeafe;
    color: #1d4ed8;
}

.status-completed {
    background: #d1fae5;
    color: #059669;
}

.status-paused {
    background: #fef3c7;
    color: #d97706;
}

.status-planning {
    background: #cffafe;
    color: #0891b2;
}

/* Tab Styles */
.nav-tabs {
    border-bottom: 2px solid #e9ecef;
    margin-bottom: 0;
}

.nav-tabs .nav-link {
    color: #6c757d;
    border: 1px solid transparent;
    border-top-left-radius: 0.375rem;
    border-top-right-radius: 0.375rem;
    padding: 0.75rem 1rem;
    font-weight: 500;
    transition: all 0.2s ease;
    background: transparent;
    position: relative;
}

.nav-tabs .nav-link:hover {
    color: #495057;
    border-color: #e9ecef #e9ecef #dee2e6;
    background-color: #f8f9fa;
}

.nav-tabs .nav-link.active {
    color: #007bff;
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff;
    border-bottom: 2px solid #007bff;
    font-weight: 600;
    box-shadow: 0 -2px 4px rgba(0,123,255,0.1);
}

.nav-tabs .nav-link i {
    margin-left: 0.5rem;
    font-size: 1.1em;
}

.card-header-tabs {
    border-bottom: 1px solid #dee2e6;
    margin-bottom: 0;
    background: #f8f9fa;
    padding: 0.5rem 1rem;
}

.card-header-tabs .nav-tabs {
    border-bottom: 0;
    margin-bottom: 0;
}

.card-header-tabs .nav-tabs .nav-link {
    border-bottom: 1px solid transparent;
    margin-bottom: -1px;
    background: transparent;
}

.card-header-tabs .nav-tabs .nav-link.active {
    border-bottom-color: #fff;
    background: #fff;
    border-radius: 0.375rem 0.375rem 0 0;
}

/* Tab Content */
.tab-content {
    padding: 1.5rem 0;
}

.tab-pane {
    display: none;
}

.tab-pane.active {
    display: block;
}

.tab-pane.fade {
    opacity: 0;
    transition: opacity 0.15s linear;
}

.tab-pane.fade.active {
    opacity: 1;
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr) !important;
    }

    .info-section {
        padding: 1rem;
    }

    .info-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    /* Mobile Tab Styles */
    .nav-tabs {
        flex-wrap: wrap;
    }

    .nav-tabs .nav-link {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .nav-tabs .nav-link i {
        margin-left: 0.25rem;
        font-size: 1em;
    }

    .tab-content {
        padding: 1rem 0;
    }
}
</style>
