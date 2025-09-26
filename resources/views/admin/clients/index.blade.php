@extends('admin.layout')

@section('title', 'مدیریت کارفرمایان')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">مدیریت کارفرمایان</h1>
            <p class="page-subtitle">لیست کارفرمایان و مشتریان شرکت</p>
        </div>
        <a href="{{ route('clients.create') }}" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-left: 8px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            افزودن کارفرمای جدید
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 30px;">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ count($clients) }}</div>
        <div class="stat-label">کل کارفرمایان</div>
    </div>

    <div class="stat-card success">
        <div class="stat-header">
            <div class="stat-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ collect($clients)->where('status', 'active')->count() }}</div>
        <div class="stat-label">کارفرمایان فعال</div>
    </div>

    <div class="stat-card accent">
        <div class="stat-header">
            <div class="stat-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ collect($clients)->sum('projects_count') }}</div>
        <div class="stat-label">کل پروژه‌ها</div>
    </div>
</div>

<!-- Clients Table -->
<div class="content-card">
    <div class="card-header">
        <div>
            <h3 class="card-title">لیست کارفرمایان</h3>
            <p class="card-subtitle">مدیریت اطلاعات کارفرمایان و مشتریان</p>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="clients-table">
                <thead>
                    <tr>
                        <th>کارفرما</th>
                        <th>وضعیت</th>
                        <th>پروژه‌ها</th>
                        <th>اطلاعات</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                    <tr class="client-row" data-status="{{ $client->status }}">
                        <td>
                            <div class="client-info">
                                <div class="client-logo">
                                    @if($client->logo)
                                        <img src="{{ asset('storage/' . $client->logo) }}" alt="{{ $client->name }}" class="logo-image">
                                    @else
                                        <div class="logo-placeholder">
                                            {{ substr($client->name, 0, 2) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="client-details">
                                    <div class="client-name">{{ $client->name }}</div>
                                    <div class="client-email">{{ $client->email }}</div>
                                    <div class="client-phone">{{ $client->phone }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="client-status status-{{ $client->status }}">
                                @if($client->status === 'active')
                                    فعال
                                @else
                                    غیرفعال
                                @endif
                            </span>
                        </td>
                        <td>
                            <div class="client-stats">
                                <div class="stat-item">
                                    <span class="stat-number">{{ $client->projects_count ?? 0 }}</span>
                                    <span class="stat-label">پروژه</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-number">{{ $client->contacts_count ?? 0 }}</span>
                                    <span class="stat-label">مخاطب</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="client-meta">
                                @if($client->website)
                                    <div class="meta-item">
                                        <span class="meta-label">وب‌سایت:</span>
                                        <a href="{{ $client->website }}" target="_blank" class="meta-value">{{ $client->website }}</a>
                                    </div>
                                @endif
                                @if($client->address)
                                    <div class="meta-item">
                                        <span class="meta-label">آدرس:</span>
                                        <span class="meta-value">{{ $client->address }}</span>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('clients.contacts.index', $client->id) }}" class="btn btn-sm btn-contacts" title="دفترچه تلفن">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-sm btn-edit" title="ویرایش">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <button class="btn btn-sm btn-delete" title="حذف">
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

.table-responsive {
    overflow-x: auto;
}

.clients-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.clients-table th,
.clients-table td {
    padding: 15px;
    text-align: right;
    border-bottom: 1px solid var(--border-light);
}

.clients-table th {
    background: var(--bg-light);
    font-weight: 600;
    color: var(--text-light);
    font-size: 14px;
}

.clients-table tr:hover {
    background: var(--bg-light);
}

.client-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.client-logo {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}

.client-logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.client-details {
    flex: 1;
}

.client-name {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 4px;
}

.client-email {
    font-size: 13px;
    color: var(--text-light);
    margin-bottom: 4px;
}

.client-phone {
    font-size: 13px;
    color: var(--text-light);
}

.client-stats {
    display: flex;
    gap: 15px;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.stat-number {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-dark);
}

.stat-label {
    font-size: 12px;
    color: var(--text-light);
}

.client-meta {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-light);
}

.meta-label {
    font-weight: 600;
    color: var(--text-dark);
}

.meta-value {
    color: var(--primary-color);
    text-decoration: none;
}

.meta-value:hover {
    text-decoration: underline;
}

.client-status {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-active {
    background: rgba(0, 200, 83, 0.1);
    color: var(--success-color);
}

.status-inactive {
    background: rgba(244, 67, 54, 0.1);
    color: var(--error-color);
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

.btn-contacts {
    background: rgba(0, 200, 83, 0.1);
    color: var(--success-color);
}

.btn-contacts:hover {
    background: var(--success-color);
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
</style>
@endpush
