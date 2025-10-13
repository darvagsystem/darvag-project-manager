@extends('admin.layout')

@section('title', 'مرکز تنظیمات')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">مرکز تنظیمات</h1>
        <p class="page-subtitle">مدیریت کلیه تنظیمات و پیکربندی‌های سیستم</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i>
        {{ session('error') }}
    </div>
@endif

<!-- Settings Categories -->
<div class="settings-grid">
    <!-- Company Settings -->
    <div class="setting-card primary">
        <div class="card-icon">
            <i class="fas fa-building"></i>
        </div>
        <div class="card-content">
            <h3>تنظیمات شرکت</h3>
            <p>مدیریت اطلاعات کلی شرکت، لوگو و اطلاعات تماس</p>
        </div>
        <div class="card-actions">
            <a href="{{ route('panel.settings.company') }}" class="btn btn-primary">
                <i class="fas fa-cog"></i>
                تنظیمات
            </a>
        </div>
    </div>

    <!-- Banks Management -->
    <div class="setting-card success">
        <div class="card-icon">
            <i class="fas fa-university"></i>
        </div>
        <div class="card-content">
            <h3>مدیریت بانک‌ها</h3>
            <p>افزودن، ویرایش و مدیریت بانک‌های سیستم</p>
            <div class="card-stats">
                <span class="stat">{{ \App\Models\Bank::count() }} بانک</span>
                <span class="stat">{{ \App\Models\Bank::where('is_active', true)->count() }} فعال</span>
            </div>
        </div>
        <div class="card-actions">
            <a href="{{ route('panel.settings.banks.index') }}" class="btn btn-success">
                <i class="fas fa-edit"></i>
                مدیریت
            </a>
        </div>
    </div>

    <!-- User Management -->
    <div class="setting-card warning">
        <div class="card-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="card-content">
            <h3>مدیریت کاربران</h3>
            <p>مدیریت کاربران سیستم، نقش‌ها و دسترسی‌ها</p>
            <div class="card-stats">
                <span class="stat">قریباً</span>
            </div>
        </div>
        <div class="card-actions">
            <a href="{{ route('panel.users.index') }}" class="btn btn-warning">
                <i class="fas fa-user-cog"></i>
                مدیریت
            </a>
        </div>
    </div>

    <!-- System Backup -->
    <div class="setting-card info">
        <div class="card-icon">
            <i class="fas fa-download"></i>
        </div>
        <div class="card-content">
            <h3>پشتیبان‌گیری</h3>
            <p>ایجاد و مدیریت پشتیبان از اطلاعات سیستم</p>
            <div class="card-stats">
                <span class="stat">آخرین پشتیبان: هرگز</span>
            </div>
        </div>
        <div class="card-actions">
            <a href="#" class="btn btn-info" onclick="alert('این قابلیت در حال توسعه است')">
                <i class="fas fa-cloud-download-alt"></i>
                پشتیبان‌گیری
            </a>
        </div>
    </div>

    <!-- System Logs -->
    <div class="setting-card secondary">
        <div class="card-icon">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="card-content">
            <h3>گزارش‌های سیستم</h3>
            <p>مشاهده و مدیریت لاگ‌های سیستم</p>
            <div class="card-stats">
                <span class="stat">آخرین بروزرسانی: امروز</span>
            </div>
        </div>
        <div class="card-actions">
            <a href="{{ route('panel.logs') }}" class="btn btn-secondary">
                <i class="fas fa-list"></i>
                مشاهده
            </a>
        </div>
    </div>

    <!-- System Information -->
    <div class="setting-card dark">
        <div class="card-icon">
            <i class="fas fa-info-circle"></i>
        </div>
        <div class="card-content">
            <h3>اطلاعات سیستم</h3>
            <p>نمایش اطلاعات فنی و وضعیت سیستم</p>
            <div class="card-stats">
                <span class="stat">Laravel {{ app()->version() }}</span>
                <span class="stat">PHP {{ phpversion() }}</span>
            </div>
        </div>
        <div class="card-actions">
            <button class="btn btn-dark" onclick="toggleSystemInfo()">
                <i class="fas fa-eye"></i>
                نمایش
            </button>
        </div>
    </div>
</div>

<!-- System Information Modal -->
<div id="systemInfoModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>اطلاعات سیستم</h2>
            <button class="close-btn" onclick="toggleSystemInfo()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="info-grid">
                <div class="info-item">
                    <strong>نسخه Laravel:</strong>
                    <span>{{ app()->version() }}</span>
                </div>
                <div class="info-item">
                    <strong>نسخه PHP:</strong>
                    <span>{{ phpversion() }}</span>
                </div>
                <div class="info-item">
                    <strong>محیط:</strong>
                    <span>{{ app()->environment() }}</span>
                </div>
                <div class="info-item">
                    <strong>تاریخ ایجاد:</strong>
                    <span>{{ date('Y/m/d H:i:s') }}</span>
                </div>
                <div class="info-item">
                    <strong>وضعیت Debug:</strong>
                    <span>{{ config('app.debug') ? 'فعال' : 'غیرفعال' }}</span>
                </div>
                <div class="info-item">
                    <strong>URL برنامه:</strong>
                    <span>{{ config('app.url') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ensure all links are clickable
    const links = document.querySelectorAll('a');
    links.forEach(link => {
        link.style.pointerEvents = 'auto';
        link.style.cursor = 'pointer';
        link.style.zIndex = '999';

        // Add click event listener for debugging
        link.addEventListener('click', function(e) {
            console.log('Link clicked:', this.href);
        });
    });

    // Ensure all buttons are clickable
    const buttons = document.querySelectorAll('button, .btn');
    buttons.forEach(button => {
        button.style.pointerEvents = 'auto';
        button.style.cursor = 'pointer';
        button.style.zIndex = '999';

        // Add click event listener for debugging
        button.addEventListener('click', function(e) {
            console.log('Button clicked:', this);
        });
    });

    // Remove any overlays that might be blocking clicks
    const overlays = document.querySelectorAll('.overlay, .modal-backdrop');
    overlays.forEach(overlay => {
        overlay.style.display = 'none';
    });

    console.log('Click fix applied');
});
</script>
@endpush

@push('styles')
<style>
.settings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 24px;
    margin-top: 20px;
}

.setting-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    pointer-events: auto;
}

.setting-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
}

.setting-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
}

.setting-card.primary::before { background: #3B82F6; }
.setting-card.success::before { background: #10B981; }
.setting-card.warning::before { background: #F59E0B; }
.setting-card.info::before { background: #06B6D4; }
.setting-card.secondary::before { background: #6B7280; }
.setting-card.dark::before { background: #374151; }

.card-icon {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 16px;
}

.setting-card.primary .card-icon {
    background: rgba(59, 130, 246, 0.1);
    color: #3B82F6;
}

.setting-card.success .card-icon {
    background: rgba(16, 185, 129, 0.1);
    color: #10B981;
}

.setting-card.warning .card-icon {
    background: rgba(245, 158, 11, 0.1);
    color: #F59E0B;
}

.setting-card.info .card-icon {
    background: rgba(6, 182, 212, 0.1);
    color: #06B6D4;
}

.setting-card.secondary .card-icon {
    background: rgba(107, 114, 128, 0.1);
    color: #6B7280;
}

.setting-card.dark .card-icon {
    background: rgba(55, 65, 81, 0.1);
    color: #374151;
}

.card-content h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1F2937;
    margin-bottom: 8px;
}

.card-content p {
    color: #6B7280;
    font-size: 14px;
    line-height: 1.5;
    margin-bottom: 12px;
}

.card-stats {
    display: flex;
    gap: 12px;
    margin-bottom: 16px;
}

.stat {
    background: #F3F4F6;
    color: #374151;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
}

.card-actions {
    margin-top: auto;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    pointer-events: auto;
    z-index: 10;
    position: relative;
}

.btn-primary {
    background: #3B82F6;
    color: white;
}

.btn-primary:hover {
    background: #2563EB;
}

.btn-success {
    background: #10B981;
    color: white;
}

.btn-success:hover {
    background: #059669;
}

.btn-warning {
    background: #F59E0B;
    color: white;
}

.btn-warning:hover {
    background: #D97706;
}

.btn-info {
    background: #06B6D4;
    color: white;
}

.btn-info:hover {
    background: #0891B2;
}

.btn-secondary {
    background: #6B7280;
    color: white;
}

.btn-secondary:hover {
    background: #4B5563;
}

.btn-dark {
    background: #374151;
    color: white;
}

.btn-dark:hover {
    background: #1F2937;
}

.alert {
    padding: 16px 20px;
    border-radius: 8px;
    border: none;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-success {
    background: rgba(16, 185, 129, 0.1);
    color: #065F46;
}

.alert-danger {
    background: rgba(239, 68, 68, 0.1);
    color: #991B1B;
}

/* Fix click issues */
* {
    pointer-events: auto !important;
}

a, button, .btn {
    pointer-events: auto !important;
    cursor: pointer !important;
    z-index: 999 !important;
}

/* Modal Styles */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: white;
    border-radius: 12px;
    max-width: 600px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
}

.modal-header {
    padding: 20px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h2 {
    margin: 0;
    color: #1F2937;
}

.close-btn {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #6B7280;
}

.close-btn:hover {
    color: #374151;
}

.modal-body {
    padding: 20px;
}

.info-grid {
    display: grid;
    gap: 12px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    padding: 12px;
    background: #F9FAFB;
    border-radius: 8px;
}

.info-item strong {
    color: #374151;
}

.info-item span {
    color: #6B7280;
    font-family: monospace;
}

@media (max-width: 768px) {
    .settings-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .setting-card {
        padding: 20px;
    }
}
</style>
@endpush

@push('scripts')
<script>
function toggleSystemInfo() {
    const modal = document.getElementById('systemInfoModal');
    if (modal.style.display === 'none' || modal.style.display === '') {
        modal.style.display = 'flex';
    } else {
        modal.style.display = 'none';
    }
}

// Close modal when clicking outside
document.getElementById('systemInfoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        toggleSystemInfo();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('systemInfoModal');
        if (modal.style.display === 'flex') {
            toggleSystemInfo();
        }
    }
});
</script>
@endpush
