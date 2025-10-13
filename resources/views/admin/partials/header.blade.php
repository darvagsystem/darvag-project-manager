<header class="admin-header">
    <div class="header-left">
        <nav class="breadcrumb">
            @isset($breadcrumbs)
                @foreach($breadcrumbs as $breadcrumb)
                    <div class="breadcrumb-item">
                        @if(!$loop->first)
                            <svg class="breadcrumb-separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        @endif

                        @if($breadcrumb['url'])
                            <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                        @else
                            <span>{{ $breadcrumb['title'] }}</span>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="breadcrumb-item">
                    <svg class="breadcrumb-separator" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    </svg>
                    <span>داشبورد</span>
                </div>
            @endisset
        </nav>
    </div>

    <div class="header-right">
        <div class="header-search">
            <input type="text" class="search-input" placeholder="جستجو در سیستم...">
            <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        <button class="theme-toggle" title="تغییر تم">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
        </button>

        <div class="header-notifications" title="اعلان‌ها">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            <span class="notification-badge">5</span>
        </div>

        <div class="header-profile dropdown" title="پروفایل کاربری">
            <div class="profile-trigger" onclick="toggleProfileDropdown()" aria-expanded="false">
                <div class="profile-avatar">
                    @if(auth()->check())
                        {{ substr(auth()->user()->name, 0, 1) }}{{ substr(auth()->user()->username, 0, 1) }}
                    @else
                        م.ب
                    @endif
                </div>
                <div class="profile-info">
                    <div class="profile-name">
                        @if(auth()->check())
                            {{ auth()->user()->name }}
                        @else
                            مصیب بامری
                        @endif
                    </div>
                    <div class="profile-role">
                        @if(auth()->check())
                            @if(auth()->user()->roles->count() > 0)
                                {{ auth()->user()->roles->first()->name }}
                            @else
                                کاربر
                            @endif
                        @else
                            مدیر عامل
                        @endif
                    </div>
                </div>
                <svg class="dropdown-arrow" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>

            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <div class="dropdown-header">
                        <div class="fw-bold">
                            @if(auth()->check())
                                {{ auth()->user()->name }}
                            @else
                                مصیب بامری
                            @endif
                        </div>
                        <small class="text-muted">
                            @if(auth()->check())
                                {{ auth()->user()->email }}
                            @else
                                admin@example.com
                            @endif
                        </small>
                    </div>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('panel.profile.show') }}">
                        <i class="fas fa-user me-2"></i> پروفایل من
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('panel.profile.edit') }}">
                        <i class="fas fa-cog me-2"></i> تنظیمات
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i> خروج از سیستم
                        </button>
                    </form>
                </li>
            </ul>
        </div>

    </div>
</header>
