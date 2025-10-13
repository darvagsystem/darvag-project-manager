@extends('admin.layout')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <div class="breadcrumb-trail">
                <a href="{{ route('panel.clients.index') }}" class="breadcrumb-link">کارفرمایان</a>
                <span class="breadcrumb-separator">←</span>
                <a href="{{ route('panel.clients.phonebook.index', $client->id) }}" class="breadcrumb-link">دفترچه تلفن {{ $client->name }}</a>
                <span class="breadcrumb-separator">←</span>
                <span class="breadcrumb-current">افزودن مخاطب جدید</span>
            </div>
            <h1 class="page-title">افزودن مخاطب جدید</h1>
            <p class="page-subtitle">ثبت اطلاعات مخاطب جدید برای {{ $client->name }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('panel.clients.phonebook.index', $client->id) }}" class="btn btn-secondary">
                <i class="mdi mdi-arrow-right me-1"></i>
                بازگشت به دفترچه تلفن
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">اطلاعات مخاطب</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('panel.clients.phonebook.store', $client->id) }}" class="phonebook-form">
                    @csrf

                    <div class="row">
                        <!-- منطقه -->
                        <div class="col-md-6 mb-3">
                            <label for="region" class="form-label">منطقه <span class="text-muted">(اختیاری)</span></label>
                            <input type="text" class="form-control" id="region" name="region"
                                   value="{{ old('region') }}" placeholder="مشهد، سرخس، تهران...">
                            @error('region')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- بخش -->
                        <div class="col-md-6 mb-3">
                            <label for="department" class="form-label">بخش <span class="text-muted">(اختیاری)</span></label>
                            <input type="text" class="form-control" id="department" name="department"
                                   value="{{ old('department') }}" placeholder="حسابداری، تولید، فروش...">
                            @error('department')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- واحد -->
                        <div class="col-md-6 mb-3">
                            <label for="unit" class="form-label">واحد <span class="text-muted">(اختیاری)</span></label>
                            <input type="text" class="form-control" id="unit" name="unit"
                                   value="{{ old('unit') }}" placeholder="حسابداری کالا، حسابداری مالی...">
                            @error('unit')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- نام شخص -->
                        <div class="col-md-6 mb-3">
                            <label for="person_name" class="form-label">نام شخص <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="person_name" name="person_name"
                                   value="{{ old('person_name') }}" required placeholder="نام و نام خانوادگی">
                            @error('person_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- سمت -->
                        <div class="col-md-6 mb-3">
                            <label for="position" class="form-label">سمت <span class="text-muted">(اختیاری)</span></label>
                            <input type="text" class="form-control" id="position" name="position"
                                   value="{{ old('position') }}" placeholder="مدیر، کارشناس، مسئول...">
                            @error('position')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- تلفن ثابت -->
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">تلفن ثابت <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                   value="{{ old('phone') }}" required placeholder="05112345678">
                            @error('phone')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- تلفن همراه -->
                        <div class="col-md-6 mb-3">
                            <label for="mobile" class="form-label">تلفن همراه <span class="text-muted">(اختیاری)</span></label>
                            <input type="tel" class="form-control" id="mobile" name="mobile"
                                   value="{{ old('mobile') }}" placeholder="09123456789">
                            @error('mobile')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- یادداشت‌ها -->
                        <div class="col-12 mb-3">
                            <label for="notes" class="form-label">یادداشت‌ها <span class="text-muted">(اختیاری)</span></label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"
                                      placeholder="اطلاعات اضافی درباره این مخاطب...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('panel.clients.phonebook.index', $client->id) }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-right me-1"></i>
                            انصراف
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-check me-1"></i>
                            ثبت مخاطب
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">راهنما</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-primary">ساختار سلسله‌مراتبی</h6>
                    <p class="small text-muted mb-2">
                        می‌توانید ساختار سلسله‌مراتبی زیر را برای سازماندهی مخاطبین استفاده کنید:
                    </p>
                    <ul class="small text-muted">
                        <li><strong>منطقه:</strong> مشهد، سرخس، تهران</li>
                        <li><strong>بخش:</strong> حسابداری، تولید، فروش</li>
                        <li><strong>واحد:</strong> حسابداری کالا، حسابداری مالی</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h6 class="text-primary">فیلدهای اجباری</h6>
                    <ul class="small text-muted">
                        <li>نام شخص</li>
                        <li>تلفن ثابت</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h6 class="text-primary">فیلدهای اختیاری</h6>
                    <ul class="small text-muted">
                        <li>منطقه، بخش، واحد</li>
                        <li>سمت</li>
                        <li>تلفن همراه</li>
                        <li>یادداشت‌ها</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.querySelector('.phonebook-form');
    form.addEventListener('submit', function(e) {
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

        if (hasError) {
            e.preventDefault();
            alert('لطفاً تمام فیلدهای اجباری را پر کنید.');
        }
    });

    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    const mobileInput = document.getElementById('mobile');

    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0 && !value.startsWith('0')) {
            value = '0' + value;
        }
        e.target.value = value;
    });

    mobileInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0 && !value.startsWith('09')) {
            if (value.startsWith('9')) {
                value = '0' + value;
            } else if (!value.startsWith('0')) {
                value = '09' + value;
            }
        }
        e.target.value = value;
    });
});
</script>
@endpush

@push('styles')
<style>
.breadcrumb-trail {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.breadcrumb-link {
    color: #6c757d;
    text-decoration: none;
}

.breadcrumb-link:hover {
    color: #495057;
}

.breadcrumb-separator {
    margin: 0 0.5rem;
    color: #6c757d;
}

.breadcrumb-current {
    color: #495057;
    font-weight: 500;
}

.header-actions {
    display: flex;
    gap: 0.5rem;
}

@media (max-width: 768px) {
    .header-actions {
        flex-direction: column;
        width: 100%;
        margin-top: 1rem;
    }

    .header-actions .btn {
        width: 100%;
    }
}

:root {
    --error-color: #dc3545;
    --border-light: #ced4da;
}
</style>
@endpush
