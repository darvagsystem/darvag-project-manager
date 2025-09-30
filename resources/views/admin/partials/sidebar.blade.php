<aside class="admin-sidebar">
    <div class="sidebar-header">
        @if($companySettings->company_logo)
            <img src="{{ asset('storage/' . $companySettings->company_logo) }}" alt="{{ $companySettings->company_name }}" class="sidebar-logo">
        @else
            <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjQwIiB2aWV3Qm94PSIwIDAgMTIwIDQwIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjx0ZXh0IHg9IjYwIiB5PSIyNCIgZm9udC1mYW1pbHk9IkFyaWFsLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjE2IiBmb250LXdlaWdodD0iYm9sZCIgZmlsbD0iIzMzMzMzMyIgdGV4dC1hbmNob3I9Im1pZGRsZSI+2K/Yp9ix2YjaqTwvdGV4dD48L3N2Zz4=" alt="{{ $companySettings->company_name ?? 'داروگ' }}" class="sidebar-logo">
        @endif
        <h2 class="sidebar-title">پنل مدیریت</h2>
        <p class="sidebar-subtitle">{{ $companySettings->company_name ?? 'شرکت کاخ‌سازان داروگ' }}</p>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">
            <div class="nav-section-title">اصلی</div>
            <div class="nav-item">
                <a href="{{ route('panel.dashboard') }}" class="nav-link {{ Request::routeIs('panel.dashboard') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 7 5-5 5 5"></path>
                    </svg>
                    <span class="nav-text">داشبورد</span>
                </a>
            </div>
        </div>

        <div class="nav-section">
            <div class="nav-section-title">مدیریت محتوا</div>
            <div class="nav-item">
                <a href="{{ route('panel.projects.index') }}" class="nav-link {{ Request::routeIs('panel.projects.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="nav-text">پروژه‌ها</span>
                    <span class="nav-badge">12</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('panel.employees.index') }}" class="nav-link {{ Request::routeIs('panel.employees.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="nav-text">مدیریت پرسنل</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('panel.services') }}" class="nav-link {{ Request::routeIs('panel.services') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="nav-text">خدمات</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('panel.clients.index') }}" class="nav-link {{ Request::routeIs('panel.clients.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="nav-text">کارفرمایان</span>
                    <span class="nav-badge">4</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('panel.file-manager.index') }}" class="nav-link {{ Request::routeIs('panel.file-manager.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 7 5-5 5 5"></path>
                    </svg>
                    <span class="nav-text">مدیریت فایل‌ها</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('panel.tasks.index') }}" class="nav-link {{ Request::routeIs('panel.tasks.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    <span class="nav-text">مدیریت کارها</span>
                </a>
            </div>
        </div>


        <div class="nav-section">
            <div class="nav-section-title">سیستم</div>
            <div class="nav-item">
                <a href="{{ route('panel.settings.index') }}" class="nav-link {{ Request::routeIs('panel.settings.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="nav-text">تنظیمات</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('panel.tag-categories.index') }}" class="nav-link {{ Request::routeIs('panel.tag-categories.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span class="nav-text">دسته‌بندی تگ‌ها</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('panel.tags.index') }}" class="nav-link {{ Request::routeIs('panel.tags.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span class="nav-text">مدیریت تگ‌ها</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('panel.backup') }}" class="nav-link {{ Request::routeIs('panel.backup') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                    </svg>
                    <span class="nav-text">پشتیبان‌گیری</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('panel.logs') }}" class="nav-link {{ Request::routeIs('panel.logs') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span class="nav-text">گزارش‌های سیستم</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('panel.help.index') }}" class="nav-link {{ Request::routeIs('panel.help.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="nav-text">راهنما</span>
                </a>
            </div>
        </div>
    </nav>
</aside>
