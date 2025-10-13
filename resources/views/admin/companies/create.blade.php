@extends('admin.layout')

@section('title', 'افزودن شرکت جدید')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">افزودن شرکت جدید</h3>
                </div>
                <div class="card-body">
                    <!-- جستجو در ساجر -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">جستجو در ساجر</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="sajar-search" placeholder="نام شرکت را وارد کنید...">
                                        <button class="btn btn-outline-primary" type="button" id="search-sajar-btn">
                                            <i class="fas fa-search"></i> جستجو
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- نتایج جستجو -->
                            <div id="sajar-results" class="mt-3" style="display: none;">
                                <h6>نتایج جستجو:</h6>
                                <div id="sajar-companies-list" class="list-group">
                                    <!-- نتایج اینجا نمایش داده می‌شود -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('panel.companies.store') }}" method="POST" id="company-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">نام شرکت <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="national_id" class="form-label">شناسه ملی <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('national_id') is-invalid @enderror"
                                           id="national_id" name="national_id" value="{{ old('national_id') }}" required>
                                    @error('national_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="registration_number" class="form-label">شماره ثبت</label>
                                    <input type="text" class="form-control @error('registration_number') is-invalid @enderror"
                                           id="registration_number" name="registration_number" value="{{ old('registration_number') }}">
                                    @error('registration_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="economic_code" class="form-label">کد اقتصادی</label>
                                    <input type="text" class="form-control @error('economic_code') is-invalid @enderror"
                                           id="economic_code" name="economic_code" value="{{ old('economic_code') }}">
                                    @error('economic_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">تلفن</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                           id="phone" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">ایمیل</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="website" class="form-label">وب‌سایت</label>
                                    <input type="url" class="form-control @error('website') is-invalid @enderror"
                                           id="website" name="website" value="{{ old('website') }}">
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">وضعیت <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="">انتخاب کنید</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>فعال</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غیرفعال</option>
                                        <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>معلق</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">آدرس</label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address" name="address" rows="3">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">توضیحات</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('panel.companies.index') }}" class="btn btn-secondary me-2">انصراف</a>
                            <button type="submit" class="btn btn-primary">ذخیره</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript برای جستجو در ساجر -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchBtn = document.getElementById('search-sajar-btn');
    const searchInput = document.getElementById('sajar-search');
    const resultsDiv = document.getElementById('sajar-results');
    const companiesList = document.getElementById('sajar-companies-list');
    const companyForm = document.getElementById('company-form');

    // جستجو در ساجر
    searchBtn.addEventListener('click', function() {
        const query = searchInput.value.trim();
        if (!query) {
            alert('لطفاً نام شرکت را وارد کنید');
            return;
        }

        // نمایش لودینگ
        searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> در حال جستجو...';
        searchBtn.disabled = true;

        // درخواست AJAX
        fetch(`/panel/companies/search-sajar?q=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                displayResults(data);
            })
            .catch(error => {
                console.error('Error:', error);
                // نمایش پیام خطا و یک نمونه
                displayResults([{
                    'LatestCompanyName': query + ' (خطا در جستجو)',
                    'NationalCode': '00000000000',
                    'TaxNumber': '0000000000',
                    'CompanyID': 0
                }]);
            })
            .finally(() => {
                searchBtn.innerHTML = '<i class="fas fa-search"></i> جستجو';
                searchBtn.disabled = false;
            });
    });

    // نمایش نتایج
    function displayResults(companies) {
        if (companies.length === 0) {
            companiesList.innerHTML = '<div class="alert alert-info">هیچ شرکتی یافت نشد</div>';
        } else {
            companiesList.innerHTML = companies.map(company => `
                <div class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">${company.LatestCompanyName || 'نامشخص'}</h6>
                        <button class="btn btn-sm btn-primary" onclick="selectCompany(${JSON.stringify(company).replace(/"/g, '&quot;')})">
                            انتخاب
                        </button>
                    </div>
                    <p class="mb-1">
                        <strong>شناسه ملی:</strong> ${company.NationalCode || 'نامشخص'}<br>
                        <strong>شماره مالیاتی:</strong> ${company.TaxNumber || 'نامشخص'}<br>
                        <strong>نوع گواهینامه:</strong> ${company.CertificateTypeName || 'نامشخص'}<br>
                        <strong>وضعیت:</strong> ${company.CertificateStatusName || 'نامشخص'}
                    </p>
                </div>
            `).join('');
        }
        resultsDiv.style.display = 'block';
    }

    // انتخاب شرکت
    window.selectCompany = function(company) {
        // پر کردن فرم
        document.getElementById('name').value = company.LatestCompanyName || '';
        document.getElementById('national_id').value = company.NationalCode || '';
        document.getElementById('economic_code').value = company.TaxNumber || '';

        // مخفی کردن نتایج
        resultsDiv.style.display = 'none';
        searchInput.value = '';

        // نمایش پیام موفقیت
        alert('اطلاعات شرکت انتخاب شد. می‌توانید سایر فیلدها را تکمیل کنید.');
    };
});
</script>
@endsection
