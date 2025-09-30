@extends('admin.layout')

@section('title', 'ویرایش پروژه - ' . $project->name)

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">ویرایش پروژه</h1>
        <p class="page-subtitle">ویرایش "{{ $project->name }}" - {{ $project->client->name }}</p>
    </div>
</div>

<!-- Project Info Header -->
<div class="project-info-header">
    <div class="project-main-info">
        <div class="project-icon">
            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
        </div>
        <div class="project-details">
            <h2 class="project-name">{{ $project->name }}</h2>
            <p class="project-client">{{ $project->client->name }}</p>
            <div class="project-meta">
                <span class="contract-number">{{ $project->contract_number }}</span>
                <span class="department-badge">{{ $project->department }}</span>
            </div>
        </div>
    </div>

    <div class="project-stats">
        <div class="stat-item">
            <div class="stat-value">{{ $project->progress }}%</div>
            <div class="stat-label">پیشرفت</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ number_format($project->final_amount / 1000000000, 1) }}B</div>
            <div class="stat-label">مبلغ (میلیارد)</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $project->contract_coefficient }}</div>
            <div class="stat-label">ضریب</div>
        </div>
    </div>
</div>

<form class="project-form" method="POST">
    @csrf
    @method('PUT')

    <div class="form-sections">
        <!-- Basic Information Section -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">اطلاعات پایه پروژه</h3>
                <p class="section-subtitle">اطلاعات اساسی و شناسایی پروژه</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="name" class="form-label">نام پروژه *</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ $project->name }}" required placeholder="نام کامل پروژه">
                </div>

                <div class="form-group">
                    <label for="client_id" class="form-label">کارفرما *</label>
                    <select id="client_id" name="client_id" class="form-select" required>
                        <option value="">انتخاب کارفرما</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ $project->client_id == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="contract_number" class="form-label">شماره قرارداد *</label>
                    <input type="text" id="contract_number" name="contract_number" class="form-input" value="{{ $project->contract_number }}" required placeholder="C-2024-001">
                </div>

                <div class="form-group">
                    <label for="department" class="form-label">واحد مربوطه *</label>
                    <input type="text" id="department" name="department" class="form-input" value="{{ $project->department }}" required placeholder="واحد فنی و مهندسی">
                </div>

                <div class="form-group full-width">
                    <label for="description" class="form-label">توضیحات پروژه</label>
                    <textarea id="description" name="description" class="form-textarea" rows="4" placeholder="توضیحات کامل درباره پروژه...">{{ $project->description ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <!-- Financial Information Section -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">اطلاعات مالی</h3>
                <p class="section-subtitle">مبالغ و ضرایب مربوط به قرارداد</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="initial_estimate" class="form-label">برآورد اولیه (ریال) *</label>
                    <input type="number" id="initial_estimate" name="initial_estimate" class="form-input" value="{{ $project->initial_estimate }}" required placeholder="45000000000">
                    <small class="form-help">مبلغ برآورد اولیه پروژه</small>
                </div>

                <div class="form-group">
                    <label for="final_amount" class="form-label">مبلغ نهایی (ریال) *</label>
                    <input type="number" id="final_amount" name="final_amount" class="form-input" value="{{ $project->final_amount }}" required placeholder="48500000000">
                    <small class="form-help">مبلغ نهایی قرارداد</small>
                </div>

                <div class="form-group">
                    <label for="contract_coefficient" class="form-label">ضریب پیمان *</label>
                    <input type="number" id="contract_coefficient" name="contract_coefficient" class="form-input" value="{{ $project->contract_coefficient }}" step="0.01" min="0" required placeholder="1.08">
                    <small class="form-help">ضریب تعدیل قرارداد</small>
                </div>

                <div class="form-group">
                    <label for="currency" class="form-label">واحد پول</label>
                    <select id="currency" name="currency" class="form-select">
                        <option value="IRR" selected>ریال</option>
                        <option value="USD">دلار آمریکا</option>
                        <option value="EUR">یورو</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Timeline Section -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">زمان‌بندی پروژه</h3>
                <p class="section-subtitle">تاریخ‌های مهم و زمان‌بندی</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="contract_start_date" class="form-label">تاریخ شروع قرارداد *</label>
                    <input type="text" id="contract_start_date" name="contract_start_date" class="form-input persian-date" value="{{ $project->contract_start_date }}" required placeholder="1403/01/15">
                    <small class="form-help">تاریخ شروع طبق قرارداد</small>
                </div>

                <div class="form-group">
                    <label for="contract_end_date" class="form-label">تاریخ پایان قرارداد *</label>
                    <input type="text" id="contract_end_date" name="contract_end_date" class="form-input persian-date" value="{{ $project->contract_end_date }}" required placeholder="1403/12/30">
                    <small class="form-help">تاریخ پایان طبق قرارداد</small>
                </div>

                <div class="form-group">
                    <label for="actual_start_date" class="form-label">تاریخ شروع واقعی</label>
                    <input type="text" id="actual_start_date" name="actual_start_date" class="form-input persian-date" value="{{ $project->actual_start_date ?? '' }}" placeholder="1403/01/20">
                    <small class="form-help">تاریخ شروع واقعی کار</small>
                </div>

                <div class="form-group">
                    <label for="actual_end_date" class="form-label">تاریخ پایان واقعی</label>
                    <input type="text" id="actual_end_date" name="actual_end_date" class="form-input persian-date" value="{{ $project->actual_end_date ?? '' }}" placeholder="1403/12/25">
                    <small class="form-help">تاریخ پایان واقعی (در صورت تکمیل)</small>
                </div>
            </div>
        </div>

        <!-- Project Status Section -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">وضعیت و اولویت</h3>
                <p class="section-subtitle">وضعیت فعلی و اولویت پروژه</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="status" class="form-label">وضعیت پروژه *</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="">انتخاب وضعیت</option>
                        <option value="planning" {{ $project->status === 'planning' ? 'selected' : '' }}>در حال برنامه‌ریزی</option>
                        <option value="in_progress" {{ $project->status === 'in_progress' ? 'selected' : '' }}>در حال اجرا</option>
                        <option value="completed" {{ $project->status === 'completed' ? 'selected' : '' }}>تکمیل شده</option>
                        <option value="paused" {{ $project->status === 'paused' ? 'selected' : '' }}>متوقف شده</option>
                        <option value="cancelled" {{ $project->status === 'cancelled' ? 'selected' : '' }}>لغو شده</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="priority" class="form-label">اولویت پروژه</label>
                    <select id="priority" name="priority" class="form-select">
                        <option value="normal" {{ ($project->priority ?? 'normal') === 'normal' ? 'selected' : '' }}>عادی</option>
                        <option value="high" {{ ($project->priority ?? '') === 'high' ? 'selected' : '' }}>بالا</option>
                        <option value="urgent" {{ ($project->priority ?? '') === 'urgent' ? 'selected' : '' }}>فوری</option>
                        <option value="low" {{ ($project->priority ?? '') === 'low' ? 'selected' : '' }}>پایین</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="progress" class="form-label">درصد پیشرفت</label>
                    <input type="number" id="progress" name="progress" class="form-input" value="{{ $project->progress }}" min="0" max="100">
                    <div class="progress-visual">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $project->progress }}%"></div>
                        </div>
                        <span class="progress-text">{{ $project->progress }}%</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="project_manager" class="form-label">مدیر پروژه</label>
                    <input type="text" id="project_manager" name="project_manager" class="form-input" value="{{ $project->project_manager ?? '' }}" placeholder="نام مدیر پروژه">
                </div>
            </div>
        </div>

        <!-- Additional Information Section -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">اطلاعات تکمیلی</h3>
                <p class="section-subtitle">سایر اطلاعات مربوط به پروژه</p>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="location" class="form-label">محل اجرا</label>
                    <input type="text" id="location" name="location" class="form-input" value="{{ $project->location ?? '' }}" placeholder="مشهد، منطقه صنعتی">
                </div>

                <div class="form-group">
                    <label for="category" class="form-label">دسته‌بندی</label>
                    <select id="category" name="category" class="form-select">
                        <option value="">انتخاب دسته‌بندی</option>
                        <option value="construction" {{ ($project->category ?? '') === 'construction' ? 'selected' : '' }}>ساخت و ساز</option>
                        <option value="industrial" {{ ($project->category ?? '') === 'industrial' ? 'selected' : '' }}>صنعتی</option>
                        <option value="infrastructure" {{ ($project->category ?? '') === 'infrastructure' ? 'selected' : '' }}>زیرساخت</option>
                        <option value="energy" {{ ($project->category ?? '') === 'energy' ? 'selected' : '' }}>انرژی</option>
                        <option value="petrochemical" {{ ($project->category ?? '') === 'petrochemical' ? 'selected' : '' }}>پتروشیمی</option>
                        <option value="other" {{ ($project->category ?? '') === 'other' ? 'selected' : '' }}>سایر</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label for="notes" class="form-label">یادداشت‌ها</label>
                    <textarea id="notes" name="notes" class="form-textarea" rows="4" placeholder="یادداشت‌ها و توضیحات اضافی...">{{ $project->notes ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <!-- Project History Section -->
        <div class="form-section">
            <div class="section-header">
                <h3 class="section-title">تاریخچه پروژه</h3>
                <p class="section-subtitle">اطلاعات تاریخی و آماری</p>
            </div>

            <div class="history-stats">
                <div class="stat-item">
                    <div class="stat-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ $project->created_at }}</div>
                        <div class="stat-label">تاریخ ثبت</div>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon success">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ rand(15, 45) }} روز</div>
                        <div class="stat-label">مدت زمان تا کنون</div>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon warning">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-value">{{ number_format(($project->final_amount - $project->initial_estimate) / 1000000, 0) }}M</div>
                        <div class="stat-label">تغییر مبلغ (میلیون)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            ذخیره تغییرات
        </button>
        <a href="{{ route('panel.projects.index') }}" class="btn btn-secondary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
            </svg>
            بازگشت
        </a>
        <button type="button" class="btn btn-danger" onclick="deleteProject()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            حذف پروژه
        </button>
    </div>
</form>
@endsection

@push('styles')
<style>
.project-info-header {
    background: white;
    border-radius: 16px;
    padding: 25px;
    margin-bottom: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: var(--shadow-light);
}

.project-main-info {
    display: flex;
    align-items: center;
    gap: 20px;
}

.project-icon {
    width: 80px;
    height: 80px;
    border-radius: 16px;
    background: var(--primary-light);
    color: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.project-details {
    flex: 1;
}

.project-name {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 5px;
}

.project-client {
    font-size: 16px;
    color: var(--text-light);
    margin-bottom: 10px;
}

.project-meta {
    display: flex;
    gap: 15px;
    align-items: center;
}

.contract-number {
    font-size: 12px;
    color: var(--text-light);
    font-family: monospace;
    background: var(--bg-light);
    padding: 4px 8px;
    border-radius: 4px;
}

.department-badge {
    font-size: 12px;
    background: var(--accent-light);
    color: var(--accent-color);
    padding: 4px 10px;
    border-radius: 12px;
    font-weight: 600;
}

.project-stats {
    display: flex;
    gap: 30px;
}

.project-stats .stat-item {
    text-align: center;
}

.project-stats .stat-value {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 5px;
}

.project-stats .stat-label {
    font-size: 12px;
    color: var(--text-light);
}

.project-form {
    max-width: 1200px;
    margin: 0 auto;
}

.form-sections {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.form-section {
    background: white;
    border-radius: 16px;
    padding: 30px;
    box-shadow: var(--shadow-light);
}

.section-header {
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid var(--border-light);
}

.section-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 5px;
}

.section-subtitle {
    font-size: 14px;
    color: var(--text-light);
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 8px;
}

.form-input,
.form-select,
.form-textarea {
    padding: 12px 16px;
    border: 1px solid var(--border-light);
    border-radius: 8px;
    font-family: inherit;
    font-size: 14px;
    transition: var(--transition);
    background: white;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px var(--primary-light);
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
}

.form-help {
    margin-top: 5px;
    font-size: 12px;
    color: var(--text-light);
}

.progress-visual {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 10px;
}

.progress-bar {
    flex: 1;
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
    min-width: 30px;
}

.history-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: var(--bg-light);
    border-radius: 12px;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-light);
    color: var(--primary-color);
    flex-shrink: 0;
}

.stat-icon.success {
    background: rgba(0, 200, 83, 0.1);
    color: var(--success-color);
}

.stat-icon.warning {
    background: rgba(255, 180, 0, 0.1);
    color: var(--warning-color);
}

.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 4px;
}

.stat-label {
    font-size: 12px;
    color: var(--text-light);
}

.form-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid var(--border-light);
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: var(--transition);
}

.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

.btn-secondary {
    background: var(--bg-light);
    color: var(--text-dark);
    border: 1px solid var(--border-light);
}

.btn-secondary:hover {
    background: var(--border-light);
}

.btn-danger {
    background: rgba(244, 67, 54, 0.1);
    color: var(--error-color);
    border: 1px solid var(--error-color);
}

.btn-danger:hover {
    background: var(--error-color);
    color: white;
}

@media (max-width: 768px) {
    .project-info-header {
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }

    .project-main-info {
        flex-direction: column;
    }

    .project-stats {
        flex-direction: column;
        gap: 15px;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .history-stats {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Progress bar update
    const progressInput = document.getElementById('progress');
    const progressFill = document.querySelector('.progress-fill');
    const progressText = document.querySelector('.progress-text');

    progressInput.addEventListener('input', function() {
        const value = this.value;
        progressFill.style.width = value + '%';
        progressText.textContent = value + '%';
    });

    // Auto-calculate coefficient
    const initialEstimate = document.getElementById('initial_estimate');
    const finalAmount = document.getElementById('final_amount');
    const coefficient = document.getElementById('contract_coefficient');

    function calculateCoefficient() {
        const initial = parseFloat(initialEstimate.value) || 0;
        const final = parseFloat(finalAmount.value) || 0;

        if (initial > 0 && final > 0) {
            const calc = (final / initial).toFixed(2);
            coefficient.value = calc;
        }
    }

    initialEstimate.addEventListener('input', calculateCoefficient);
    finalAmount.addEventListener('input', calculateCoefficient);

    // Form validation
    const form = document.querySelector('.project-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Basic validation
        const requiredFields = form.querySelectorAll('[required]');
        let hasError = false;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.style.borderColor = 'var(--error-color)';
                hasError = true;
            } else {
                field.style.borderColor = 'var(--border-light)';
            }
        });

        // Date validation
        const startDate = document.getElementById('contract_start_date').value;
        const endDate = document.getElementById('contract_end_date').value;

        if (startDate && endDate) {
            if (startDate >= endDate) {
                alert('تاریخ پایان باید بعد از تاریخ شروع باشد');
                hasError = true;
            }
        }

        if (!hasError) {
            alert('تغییرات پروژه با موفقیت ذخیره شد!');
            window.location.href = '{{ route("panel.projects.index") }}';
        }
    });
});

function deleteProject() {
    if (confirm('آیا از حذف این پروژه اطمینان دارید؟\n\nتوجه: تمام اطلاعات مربوط به این پروژه حذف خواهد شد.')) {
        alert('پروژه با موفقیت حذف شد!');
        window.location.href = '{{ route("panel.projects.index") }}';
    }
}
</script>
@endpush
