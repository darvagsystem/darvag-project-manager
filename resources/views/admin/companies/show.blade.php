@extends('admin.layout')

@section('title', 'مشاهده شرکت: ' . $company->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">مشاهده شرکت: {{ $company->name }}</h3>
                    <div>
                        <form action="{{ route('panel.companies.sync-sajar', $company) }}" method="POST" class="d-inline me-2" onsubmit="return confirm('آیا مطمئن هستید که می‌خواهید این شرکت را از ساجر همگام‌سازی کنید؟')">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-sync"></i> همگام‌سازی از ساجر
                            </button>
                        </form>
                        <a href="{{ route('panel.companies.edit', $company) }}" class="btn btn-warning me-2">
                            <i class="fas fa-edit"></i> ویرایش
                        </a>
                        <a href="{{ route('panel.companies.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right"></i> بازگشت
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-muted">برای مشاهده جزئیات کامل، از تب‌های زیر استفاده کنید.</p>
                </div>
            </div>

            <!-- تب‌ها -->
            <div class="card mt-4">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="companyTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active bg-primary text-white" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                                اطلاعات شرکت
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link bg-secondary text-white" id="certificates-tab" data-bs-toggle="tab" data-bs-target="#certificates" type="button" role="tab">
                                گواهینامه‌ها
                                @if($company->certificates->count() > 0)
                                    <span class="badge bg-light text-dark ms-1">{{ $company->certificates->count() }}</span>
                                @endif
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link bg-info text-white" id="contracts-tab" data-bs-toggle="tab" data-bs-target="#contracts" type="button" role="tab">
                                قراردادها
                                @if($company->contracts->count() > 0)
                                    <span class="badge bg-light text-dark ms-1">{{ $company->contracts->count() }}</span>
                                @endif
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="companyTabsContent">
                        <!-- تب اطلاعات شرکت -->
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="30%">نام شرکت:</th>
                                            <td>{{ $company->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>شناسه ملی:</th>
                                            <td>{{ $company->national_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>شماره ثبت:</th>
                                            <td>{{ $company->registration_number ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>کد اقتصادی:</th>
                                            <td>{{ $company->economic_code ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>وضعیت:</th>
                                            <td>
                                                @if($company->status == 'active')
                                                    <span class="badge bg-success">فعال</span>
                                                @elseif($company->status == 'inactive')
                                                    <span class="badge bg-secondary">غیرفعال</span>
                                                @else
                                                    <span class="badge bg-warning">معلق</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="30%">تلفن:</th>
                                            <td>{{ $company->phone ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>ایمیل:</th>
                                            <td>{{ $company->email ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>وب‌سایت:</th>
                                            <td>
                                                @if($company->website)
                                                    <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>تاریخ ثبت:</th>
                                            <td>{{ $company->created_at->format('Y/m/d H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>آخرین به‌روزرسانی:</th>
                                            <td>{{ $company->updated_at->format('Y/m/d H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>آخرین همگام‌سازی ساجر:</th>
                                            <td>{{ $company->last_sajar_sync ? $company->last_sajar_sync->format('Y/m/d H:i') : 'هیچ‌گاه' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if($company->ceo_name || $company->ceo_national_id || $company->postal_code || $company->fax)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h5>اطلاعات تکمیلی:</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if($company->ceo_name)
                                            <p><strong>نام مدیر عامل:</strong> {{ $company->ceo_name }}</p>
                                            @endif
                                            @if($company->ceo_national_id)
                                            <p><strong>کد ملی مدیر عامل:</strong> {{ $company->ceo_national_id }}</p>
                                            @endif
                                            @if($company->postal_code)
                                            <p><strong>کد پستی:</strong> {{ $company->postal_code }}</p>
                                            @endif
                                            @if($company->fax)
                                            <p><strong>فکس:</strong> {{ $company->fax }}</p>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            @if($company->registration_authority)
                                            <p><strong>مرجع ثبت:</strong> {{ $company->registration_authority }}</p>
                                            @endif
                                            @if($company->registration_date)
                                            <p><strong>تاریخ ثبت:</strong> {{ $company->registration_date }}</p>
                                            @endif
                                            @if($company->company_type)
                                            <p><strong>نوع شرکت:</strong> {{ $company->company_type }}</p>
                                            @endif
                                            @if($company->capital)
                                            <p><strong>سرمایه:</strong> {{ $company->capital }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($company->full_address)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h5>آدرس کامل:</h5>
                                    <p class="text-muted">{{ $company->full_address }}</p>
                                </div>
                            </div>
                            @endif

                            @if($company->activity_description)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h5>شرح فعالیت:</h5>
                                    <p class="text-muted">{{ $company->activity_description }}</p>
                                </div>
                            </div>
                            @endif

                            @if($company->address)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h5>آدرس:</h5>
                                    <p class="text-muted">{{ $company->address }}</p>
                                </div>
                            </div>
                            @endif

                            @if($company->description)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h5>توضیحات:</h5>
                                    <p class="text-muted">{{ $company->description }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- تب گواهینامه‌ها -->
                        <div class="tab-pane fade" id="certificates" role="tabpanel">
                            @if($company->certificates->count() > 0)
                                <!-- آمار کلی گواهینامه‌ها -->
                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <div class="card bg-primary text-white">
                                            <div class="card-body text-center">
                                                <i class="mdi mdi-certificate" style="font-size: 2rem;"></i>
                                                <h4 class="mt-2">{{ $company->certificates->count() }}</h4>
                                                <p class="mb-0">کل گواهینامه‌ها</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-success text-white">
                                            <div class="card-body text-center">
                                                <i class="mdi mdi-check-circle" style="font-size: 2rem;"></i>
                                                <h4 class="mt-2">{{ $company->certificates->where('certificate_status_id', 1)->count() }}</h4>
                                                <p class="mb-0">گواهینامه‌های معتبر</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-danger text-white">
                                            <div class="card-body text-center">
                                                <i class="mdi mdi-close-circle" style="font-size: 2rem;"></i>
                                                <h4 class="mt-2">{{ $company->certificates->where('certificate_status_id', '!=', 1)->count() }}</h4>
                                                <p class="mb-0">گواهینامه‌های نامعتبر</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-warning text-white">
                                            <div class="card-body text-center">
                                                <i class="mdi mdi-alert-circle" style="font-size: 2rem;"></i>
                                                <h4 class="mt-2">{{ $company->certificates->filter(function($cert) { return $cert->expire_date && \Carbon\Carbon::createFromTimestamp($cert->expire_date)->isBefore(\Carbon\Carbon::now()->addDays(30)); })->count() }}</h4>
                                                <p class="mb-0">در حال انقضا (30 روز)</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- لیست گواهینامه‌ها -->
                                <div class="row">
                                    @foreach($company->certificates as $certificate)
                                    <div class="col-lg-6 mb-4">
                                        <div class="card certificate-card h-100">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <i class="mdi mdi-certificate me-2" style="font-size: 1.5rem; color: {{ $certificate->certificate_status_id == 1 ? '#28a745' : '#dc3545' }};"></i>
                                                    <div>
                                                        <h5 class="mb-0">{{ $certificate->certificate_type_name }}</h5>
                                                        <small class="text-muted">{{ $certificate->registration_province_name }}</small>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    @if($certificate->certificate_status_id == 1)
                                                        <span class="badge bg-success fs-6">معتبر</span>
                                                    @else
                                                        <span class="badge bg-danger fs-6">نامعتبر</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <!-- اطلاعات اصلی -->
                                                <div class="row mb-3">
                                                    <div class="col-6">
                                                        <div class="info-item">
                                                            <i class="mdi mdi-calendar-plus text-primary me-1"></i>
                                                            <strong>تاریخ صدور:</strong>
                                                            <span class="text-muted">{{ $certificate->issue_date ? \Carbon\Carbon::createFromTimestamp($certificate->issue_date)->format('Y/m/d') : 'نامشخص' }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="info-item">
                                                            <i class="mdi mdi-calendar-remove text-danger me-1"></i>
                                                            <strong>تاریخ انقضا:</strong>
                                                            <span class="text-muted">{{ $certificate->expire_date ? \Carbon\Carbon::createFromTimestamp($certificate->expire_date)->format('Y/m/d') : 'نامشخص' }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- اطلاعات تکمیلی -->
                                                <div class="row mb-3">
                                                    <div class="col-6">
                                                        <div class="info-item">
                                                            <i class="mdi mdi-map-marker text-info me-1"></i>
                                                            <strong>سازمان:</strong>
                                                            <span class="text-muted">{{ $certificate->province_name }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="info-item">
                                                            <i class="mdi mdi-identifier text-secondary me-1"></i>
                                                            <strong>شماره مالیاتی:</strong>
                                                            <span class="text-muted">{{ $certificate->tax_number }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- فیلدهای گواهینامه -->
                                                @if($certificate->fields->count() > 0)
                                                <div class="certificate-fields">
                                                    <h6 class="mb-3">
                                                        <i class="mdi mdi-format-list-bulleted me-1"></i>
                                                        فیلدهای گواهینامه
                                                    </h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-hover">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>نام فیلد</th>
                                                                    <th>درجه</th>
                                                                    <th>امتیاز</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($certificate->fields as $field)
                                                                <tr>
                                                                    <td>
                                                                        <strong>{{ $field->certificate_field_name }}</strong>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge bg-info">{{ $field->certificate_field_grade }}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge bg-primary">{{ $field->score }}</span>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <!-- ظرفیت‌ها -->
                                                    @foreach($certificate->fields as $field)
                                                    @php
                                                        // ظرفیت مالی مجاز (در ریال)
                                                        $allowedCapacity = $field->allowed_rated_capacity;

                                                        // ظرفیت مالی مشغول (تبدیل از میلیون ریال به ریال)
                                                        $busyCapacityInMillion = $field->busy_rated_capacity;
                                                        $busyCapacity = $busyCapacityInMillion * 1000000;

                                                        // ظرفیت مالی آزاد (محاسبه شده)
                                                        $freeCapacity = $allowedCapacity - $busyCapacity;

                                                        // درصد استفاده
                                                        $usagePercentage = $allowedCapacity > 0 ? round(($busyCapacity / $allowedCapacity) * 100, 1) : 0;
                                                    @endphp
                                                    <div class="capacity-info mt-3">
                                                        <h6 class="text-muted mb-2">{{ $field->certificate_field_name }} - ظرفیت‌ها</h6>
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <div class="capacity-item">
                                                                    <div class="capacity-label">ظرفیت مجاز</div>
                                                                    <div class="capacity-value">{{ number_format($field->allowed_work_capacity) }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="capacity-item">
                                                                    <div class="capacity-label">ظرفیت مشغول</div>
                                                                    <div class="capacity-value text-warning">{{ number_format($field->busy_work_capacity) }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="capacity-item">
                                                                    <div class="capacity-label">ظرفیت آزاد</div>
                                                                    <div class="capacity-value text-success">{{ number_format($field->free_work_capacity) }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-4">
                                                                <div class="capacity-item">
                                                                    <div class="capacity-label">ظرفیت مالی مجاز</div>
                                                                    <div class="capacity-value">{{ number_format($allowedCapacity) }} ریال</div>
                                                                    <small class="text-muted">({{ number_format($allowedCapacity / 1000000, 1) }} میلیون)</small>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="capacity-item">
                                                                    <div class="capacity-label">ظرفیت مالی مشغول</div>
                                                                    <div class="capacity-value text-warning">{{ number_format($busyCapacity) }} ریال</div>
                                                                    <small class="text-muted">({{ number_format($busyCapacityInMillion, 1) }} میلیون)</small>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="capacity-item">
                                                                    <div class="capacity-label">ظرفیت مالی آزاد</div>
                                                                    <div class="capacity-value text-success">{{ number_format($freeCapacity) }} ریال</div>
                                                                    <small class="text-muted">({{ number_format($freeCapacity / 1000000, 1) }} میلیون)</small>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- نوار پیشرفت درصد استفاده -->
                                                        <div class="row mt-3">
                                                            <div class="col-12">
                                                                <div class="capacity-usage">
                                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                                        <span class="text-muted">درصد استفاده از ظرفیت مالی:</span>
                                                                        <span class="badge {{ $usagePercentage >= 80 ? 'bg-danger' : ($usagePercentage >= 60 ? 'bg-warning' : 'bg-success') }}">
                                                                            {{ $usagePercentage }}%
                                                                        </span>
                                                                    </div>
                                                                    <div class="progress" style="height: 8px;">
                                                                        <div class="progress-bar {{ $usagePercentage >= 80 ? 'bg-danger' : ($usagePercentage >= 60 ? 'bg-warning' : 'bg-success') }}"
                                                                             role="progressbar"
                                                                             style="width: {{ $usagePercentage }}%"
                                                                             aria-valuenow="{{ $usagePercentage }}"
                                                                             aria-valuemin="0"
                                                                             aria-valuemax="100">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @endif

                                                <!-- آخرین همگام‌سازی -->
                                                <div class="mt-3 pt-3 border-top">
                                                    <small class="text-muted">
                                                        <i class="mdi mdi-sync me-1"></i>
                                                        آخرین همگام‌سازی: {{ $certificate->last_synced_at ? $certificate->last_synced_at->format('Y/m/d H:i') : 'هیچ‌گاه' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="mdi mdi-certificate-outline" style="font-size: 4rem; color: #6c757d;"></i>
                                    <h4 class="mt-3 text-muted">هیچ گواهینامه‌ای یافت نشد</h4>
                                    <p class="text-muted">برای دریافت اطلاعات گواهینامه‌ها، دکمه "همگام‌سازی از ساجر" را کلیک کنید.</p>
                                    <button class="btn btn-primary mt-3" onclick="syncCertificates({{ $company->id }})">
                                        <i class="mdi mdi-sync me-1"></i>
                                        همگام‌سازی گواهینامه‌ها
                                    </button>
                                </div>
                            @endif

                        <!-- تب قراردادها -->
                        <div class="tab-pane fade" id="contracts" role="tabpanel">
                            @if($company->contracts->count() > 0)
                                <div class="row">
                                    @foreach($company->contracts as $contract)
                                    <div class="col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">{{ $contract->contract_title }}</h6>
                                                <span class="badge
                                                    @if($contract->status == 'active') bg-success
                                                    @elseif($contract->status == 'completed') bg-primary
                                                    @elseif($contract->status == 'cancelled') bg-danger
                                                    @elseif($contract->status == 'suspended') bg-warning
                                                    @else bg-secondary
                                                    @endif">
                                                    {{ $contract->status_text }}
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <p><strong>شماره قرارداد:</strong> {{ $contract->contract_number }}</p>
                                                @if($contract->amount)
                                                    <p><strong>مبلغ:</strong> {{ $contract->formatted_amount }} {{ $contract->currency }}</p>
                                                @endif
                                                @if($contract->start_date)
                                                    <p><strong>تاریخ شروع:</strong> {{ $contract->start_date->format('Y/m/d') }}</p>
                                                @endif
                                                @if($contract->end_date)
                                                    <p><strong>تاریخ پایان:</strong> {{ $contract->end_date->format('Y/m/d') }}</p>
                                                @endif
                                                @if($contract->contract_type)
                                                    <p><strong>نوع قرارداد:</strong> {{ $contract->contract_type }}</p>
                                                @endif
                                                @if($contract->description)
                                                    <p><strong>توضیحات:</strong> {{ Str::limit($contract->description, 100) }}</p>
                                                @endif
                                                @if($contract->last_synced_at)
                                                    <small class="text-muted">
                                                        آخرین همگام‌سازی: {{ $contract->last_synced_at->format('Y/m/d H:i') }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <h5>هیچ قراردادی یافت نشد</h5>
                                    <p>هنوز قراردادی برای این شرکت ثبت نشده است.</p>
                                    <button class="btn btn-primary" onclick="syncContracts({{ $company->id }})">
                                        <i class="fas fa-sync"></i> همگام‌سازی قراردادها
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Certificate Cards Styling */
.certificate-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.certificate-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.certificate-card .card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 2px solid #dee2e6;
}

.info-item {
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.info-item i {
    font-size: 1.1rem;
}

.certificate-fields {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1rem;
    margin-top: 1rem;
}

.capacity-info {
    background: white;
    border-radius: 6px;
    padding: 1rem;
    border: 1px solid #e9ecef;
}

.capacity-item {
    text-align: center;
    padding: 0.5rem;
}

.capacity-label {
    font-size: 0.8rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.capacity-value {
    font-size: 1.1rem;
    font-weight: 600;
    color: #495057;
    line-height: 1.2;
}

.capacity-item small {
    display: block;
    margin-top: 0.25rem;
    font-size: 0.75rem;
}

.capacity-usage {
    background: #f8f9fa;
    border-radius: 6px;
    padding: 1rem;
    border: 1px solid #e9ecef;
}

.progress {
    background-color: #e9ecef;
    border-radius: 4px;
}

.progress-bar {
    transition: width 0.3s ease;
}

/* Stats Cards */
.card.bg-primary,
.card.bg-success,
.card.bg-danger,
.card.bg-warning {
    border: none;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.card.bg-primary:hover,
.card.bg-success:hover,
.card.bg-danger:hover,
.card.bg-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

/* Table Improvements */
.table-hover tbody tr:hover {
    background-color: rgba(0,123,255,0.05);
}

.table-sm th,
.table-sm td {
    padding: 0.5rem;
}

/* Badge Improvements */
.badge.fs-6 {
    font-size: 0.9rem !important;
    padding: 0.5rem 0.75rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .capacity-item {
        margin-bottom: 1rem;
    }

    .info-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .info-item i {
        margin-bottom: 0.25rem;
    }
}
</style>

<script>
function syncContracts(companyId) {
    if (confirm('آیا می‌خواهید قراردادهای این شرکت را از سامانه جامع قراردادها همگام‌سازی کنید؟')) {
        // درخواست همگام‌سازی قراردادها
        fetch(`/panel/companies/${companyId}/sync-contracts`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('قراردادها با موفقیت همگام‌سازی شدند.');
                location.reload();
            } else {
                alert('خطا در همگام‌سازی قراردادها: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('خطا در همگام‌سازی قراردادها');
        });
    }
}

function syncCertificates(companyId) {
    if (confirm('آیا می‌خواهید گواهینامه‌های این شرکت را از ساجر همگام‌سازی کنید؟')) {
        // درخواست همگام‌سازی گواهینامه‌ها
        fetch(`/panel/companies/${companyId}/sync-sajar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('گواهینامه‌ها با موفقیت همگام‌سازی شدند.');
                location.reload();
            } else {
                alert('خطا در همگام‌سازی گواهینامه‌ها: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('خطا در همگام‌سازی گواهینامه‌ها');
        });
    }
}
</script>
@endsection
