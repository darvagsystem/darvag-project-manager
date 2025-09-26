@extends('admin.layout')

@section('title', 'دفترچه تلفن - ' . $client->name)

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <div class="breadcrumb-trail">
                <a href="{{ route('clients.index') }}" class="breadcrumb-link">کارفرمایان</a>
                <span class="breadcrumb-separator">←</span>
                <span class="breadcrumb-current">دفترچه تلفن</span>
            </div>
            <h1 class="page-title">دفترچه تلفن {{ $client->name }}</h1>
            <p class="page-subtitle">مخاطبین و شماره تماس‌های مختلف این کارفرما</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('clients.contacts.create', $client->id) }}" class="btn btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                افزودن مخاطب جدید
            </a>
            <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-secondary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path>
                </svg>
                بازگشت به کارفرما
            </a>
        </div>
    </div>
</div>

<!-- Client Info Card -->
<div class="client-info-card">
    <div class="client-avatar">
        <img src="data:image/svg+xml;base64,{{ base64_encode('<svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="60" rx="12" fill="#e3f2fd"/><text x="30" y="38" font-family="Arial, sans-serif" font-size="18" font-weight="bold" fill="#1976d2" text-anchor="middle">'. substr($client->name, 0, 2) .'</text></svg>') }}" alt="{{ $client->name }}">
    </div>
    <div class="client-details">
        <h3 class="client-name">{{ $client->name }}</h3>
        <p class="contacts-count">{{ count($contacts) }} مخاطب ثبت شده</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid" style="grid-template-columns: repeat(4, 1fr); margin-bottom: 30px;">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ count($contacts) }}</div>
        <div class="stat-label">کل مخاطبین</div>
    </div>

    <div class="stat-card accent">
        <div class="stat-header">
            <div class="stat-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $contacts->unique('department')->count() }}</div>
        <div class="stat-label">واحدهای ثبت شده</div>
    </div>

    <div class="stat-card success">
        <div class="stat-header">
            <div class="stat-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $contacts->whereNotNull('phone')->count() }}</div>
        <div class="stat-label">تلفن ثابت</div>
    </div>

    <div class="stat-card warning">
        <div class="stat-header">
            <div class="stat-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $contacts->whereNotNull('mobile')->count() }}</div>
        <div class="stat-label">موبایل</div>
    </div>
</div>

<!-- Contacts List -->
<div class="contacts-grid">
    @foreach($contacts as $contact)
    <div class="contact-card">
        <div class="contact-header">
            <div class="contact-avatar">
                <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div class="contact-basic-info">
                <h4 class="contact-name">{{ $contact->contact_person }}</h4>
                <p class="contact-position">{{ $contact->position }}</p>
                <span class="department-badge">{{ $contact->department }}</span>
            </div>
        </div>

        <div class="contact-details">
            @if($contact->phone)
            <div class="contact-item">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                <a href="tel:{{ $contact->phone }}" class="contact-link">{{ $contact->phone }}</a>
            </div>
            @endif

            @if($contact->mobile)
            <div class="contact-item">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                <a href="tel:{{ $contact->mobile }}" class="contact-link">{{ $contact->mobile }}</a>
            </div>
            @endif

            @if($contact->email)
            <div class="contact-item">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <a href="mailto:{{ $contact->email }}" class="contact-link">{{ $contact->email }}</a>
            </div>
            @endif

            @if($contact->address)
            <div class="contact-item">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="contact-text">{{ $contact->address }}</span>
            </div>
            @endif

            @if($contact->notes)
            <div class="contact-notes">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                </svg>
                <span class="notes-text">{{ $contact->notes }}</span>
            </div>
            @endif
        </div>

        <div class="contact-actions">
            <a href="{{ route('clients.contacts.edit', [$client->id, $contact->id]) }}" class="btn btn-sm btn-edit" title="ویرایش">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                ویرایش
            </a>
            <button class="btn btn-sm btn-delete" title="حذف">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                حذف
            </button>
        </div>

        <div class="contact-meta">
            <small>تاریخ ثبت: {{ $contact->created_at }}</small>
        </div>
    </div>
    @endforeach
</div>

@if(count($contacts) === 0)
<div class="empty-state">
    <div class="empty-icon">
        <svg width="80" height="80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
    </div>
    <h3>هیچ مخاطبی ثبت نشده</h3>
    <p>برای این کارفرما هنوز مخاطبی در دفترچه تلفن ثبت نشده است.</p>
    <a href="{{ route('clients.contacts.create', $client->id) }}" class="btn btn-primary">افزودن اولین مخاطب</a>
</div>
@endif
@endsection

@push('styles')
<style>
.breadcrumb-trail {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
    font-size: 14px;
}

.breadcrumb-link {
    color: var(--primary-color);
    text-decoration: none;
}

.breadcrumb-link:hover {
    text-decoration: underline;
}

.breadcrumb-separator {
    color: var(--text-light);
}

.breadcrumb-current {
    color: var(--text-dark);
    font-weight: 600;
}

.header-actions {
    display: flex;
    gap: 15px;
}

.client-info-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: var(--shadow-light);
}

.client-avatar {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
}

.client-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.client-details {
    flex: 1;
}

.client-name {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 5px;
}

.contacts-count {
    color: var(--text-light);
    font-size: 16px;
}

.contacts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 25px;
}

.contact-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: var(--shadow-light);
    transition: var(--transition);
    border: 1px solid var(--border-light);
}

.contact-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-medium);
}

.contact-header {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid var(--border-light);
}

.contact-avatar {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    background: var(--primary-light);
    color: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.contact-basic-info {
    flex: 1;
}

.contact-name {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 5px;
}

.contact-position {
    color: var(--text-light);
    font-size: 14px;
    margin-bottom: 8px;
}

.department-badge {
    display: inline-block;
    background: var(--accent-light);
    color: var(--accent-color);
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.contact-details {
    margin-bottom: 20px;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
    font-size: 14px;
}

.contact-item svg {
    color: var(--text-light);
    flex-shrink: 0;
}

.contact-link {
    color: var(--primary-color);
    text-decoration: none;
}

.contact-link:hover {
    text-decoration: underline;
}

.contact-text {
    color: var(--text-dark);
}

.contact-notes {
    background: var(--bg-light);
    padding: 12px;
    border-radius: 8px;
    margin-top: 15px;
    display: flex;
    align-items: flex-start;
    gap: 10px;
}

.contact-notes svg {
    color: var(--text-light);
    flex-shrink: 0;
    margin-top: 2px;
}

.notes-text {
    font-size: 13px;
    color: var(--text-dark);
    line-height: 1.5;
}

.contact-actions {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.contact-meta {
    padding-top: 15px;
    border-top: 1px solid var(--border-light);
}

.contact-meta small {
    color: var(--text-light);
    font-size: 12px;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
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

.btn-sm {
    padding: 8px 12px;
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

.btn-delete {
    background: rgba(244, 67, 54, 0.1);
    color: var(--error-color);
}

.btn-delete:hover {
    background: var(--error-color);
    color: white;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-light);
}

.empty-icon {
    margin-bottom: 20px;
    color: var(--text-light);
}

.empty-state h3 {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 10px;
}

.empty-state p {
    color: var(--text-light);
    margin-bottom: 25px;
}

@media (max-width: 768px) {
    .header-actions {
        flex-direction: column;
    }

    .client-info-card {
        flex-direction: column;
        text-align: center;
    }

    .contacts-grid {
        grid-template-columns: 1fr;
    }

    .contact-actions {
        flex-direction: column;
    }
}
</style>
@endpush
