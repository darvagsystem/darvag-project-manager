@extends('admin.layout')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <div class="breadcrumb-trail">
                <a href="{{ route('panel.clients.index') }}" class="breadcrumb-link">کارفرمایان</a>
                <span class="breadcrumb-separator">←</span>
                <span class="breadcrumb-current">دفترچه تلفن {{ $client->name }}</span>
            </div>
            <h1 class="page-title">دفترچه تلفن {{ $client->name }}</h1>
            <p class="page-subtitle">مدیریت مخاطبین و شماره تماس‌های {{ $client->name }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('panel.clients.phonebook.create', $client->id) }}" class="btn btn-primary">
                <i class="mdi mdi-plus me-1"></i>
                افزودن مخاطب جدید
            </a>
            <a href="{{ route('panel.clients.edit', $client->id) }}" class="btn btn-secondary">
                <i class="mdi mdi-arrow-right me-1"></i>
                بازگشت به کارفرما
            </a>
        </div>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('panel.clients.phonebook.index', $client->id) }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">جستجو</label>
                <input type="text" class="form-control" id="search" name="search"
                       value="{{ $search }}" placeholder="نام، تلفن، سمت، بخش...">
            </div>
            <div class="col-md-3">
                <label for="region" class="form-label">منطقه</label>
                <select class="form-select" id="region" name="region">
                    <option value="">همه مناطق</option>
                    @foreach($regions as $regionItem)
                        <option value="{{ $regionItem }}" {{ $region == $regionItem ? 'selected' : '' }}>
                            {{ $regionItem }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="department" class="form-label">بخش</label>
                <select class="form-select" id="department" name="department">
                    <option value="">همه بخش‌ها</option>
                    @foreach($departments as $departmentItem)
                        <option value="{{ $departmentItem }}" {{ $department == $departmentItem ? 'selected' : '' }}>
                            {{ $departmentItem }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-1">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="mdi mdi-magnify"></i>
                    </button>
                    <a href="{{ route('panel.clients.phonebook.index', $client->id) }}" class="btn btn-outline-secondary flex-fill" title="پاک کردن فیلترها">
                        <i class="mdi mdi-refresh"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Results Info -->
@if($search || $region || $department)
    <div class="alert alert-info mb-4">
        <i class="mdi mdi-information me-1"></i>
        <strong>نتایج جستجو:</strong>
        {{ $phonebook->total() }} مخاطب یافت شد
        @if($search)
            برای عبارت "{{ $search }}"
        @endif
    </div>
@endif

<!-- Phonebook Entries -->
@if($phonebook->count() > 0)
    <div class="row">
        @foreach($phonebook as $entry)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card phonebook-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title mb-1">{{ $entry->person_name }}</h5>
                                @if($entry->position)
                                    <p class="text-muted mb-0 small">{{ $entry->position }}</p>
                                @endif
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('panel.clients.phonebook.edit', [$client->id, $entry->id]) }}">
                                        <i class="mdi mdi-pencil me-1"></i> ویرایش
                                    </a></li>
                                    <li>
                                        <form action="{{ route('panel.clients.phonebook.toggle-status', [$client->id, $entry->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="mdi mdi-{{ $entry->is_active ? 'eye-off' : 'eye' }} me-1"></i>
                                                {{ $entry->is_active ? 'غیرفعال' : 'فعال' }}
                                            </button>
                                        </form>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('panel.clients.phonebook.destroy', [$client->id, $entry->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا از حذف این مخاطب اطمینان دارید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="mdi mdi-delete me-1"></i> حذف
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        @if($entry->hierarchy_path)
                            <div class="mb-2">
                                <small class="text-muted">
                                    <i class="mdi mdi-account-group me-1"></i>
                                    {{ $entry->hierarchy_path }}
                                </small>
                            </div>
                        @endif

                        <div class="contact-info">
                            <div class="contact-item">
                                <i class="mdi mdi-phone me-2"></i>
                                <a href="tel:{{ $entry->phone }}" class="text-decoration-none">{{ $entry->phone }}</a>
                            </div>
                            @if($entry->mobile)
                                <div class="contact-item">
                                    <i class="mdi mdi-cellphone me-2"></i>
                                    <a href="tel:{{ $entry->mobile }}" class="text-decoration-none">{{ $entry->mobile }}</a>
                                </div>
                            @endif
                        </div>

                        @if($entry->notes)
                            <div class="mt-3">
                                <small class="text-muted">{{ Str::limit($entry->notes, 100) }}</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $phonebook->appends(request()->query())->links() }}
    </div>
@else
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="mdi mdi-phone-missed" style="font-size: 4rem; color: #6c757d;"></i>
        </div>
        <h3>هیچ مخاطبی ثبت نشده</h3>
        <p class="text-muted mb-4">برای این کارفرما هنوز مخاطبی در دفترچه تلفن ثبت نشده است.</p>
        <a href="{{ route('panel.clients.phonebook.create', $client->id) }}" class="btn btn-primary">
            <i class="mdi mdi-plus me-1"></i>
            افزودن اولین مخاطب
        </a>
    </div>
@endif
@endsection

@push('styles')
<style>
.phonebook-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: 1px solid #e9ecef;
}

.phonebook-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.contact-info {
    margin-top: 1rem;
}

.contact-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.contact-item i {
    color: #6c757d;
    width: 16px;
}

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
</style>
@endpush
