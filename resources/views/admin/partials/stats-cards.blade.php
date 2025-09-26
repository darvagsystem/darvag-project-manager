<div class="stats-grid">
    <!-- Total Projects -->
    <div class="stat-card" data-stat="projects">
        <div class="stat-header">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['total_projects'] ?? 0 }}</div>
                <div class="stat-label">کل پروژه‌ها</div>
            </div>
        </div>
        <div class="stat-change positive">
            <svg class="change-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
            </svg>
            <span>+12%</span>
        </div>
    </div>

    <!-- Active Projects -->
    <div class="stat-card accent" data-stat="active-projects">
        <div class="stat-header">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['active_projects'] ?? 0 }}</div>
                <div class="stat-label">پروژه‌های فعال</div>
            </div>
        </div>
        <div class="stat-change positive">
            <svg class="change-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
            </svg>
            <span>+8%</span>
        </div>
    </div>

    <!-- Total Employees -->
    <div class="stat-card success" data-stat="employees">
        <div class="stat-header">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['total_employees'] ?? 0 }}</div>
                <div class="stat-label">کل کارمندان</div>
            </div>
        </div>
        <div class="stat-change positive">
            <svg class="change-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
            </svg>
            <span>+5%</span>
        </div>
    </div>

    <!-- Active Employees -->
    <div class="stat-card warning" data-stat="active-employees">
        <div class="stat-header">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['active_employees'] ?? 0 }}</div>
                <div class="stat-label">کارمندان فعال</div>
            </div>
        </div>
        <div class="stat-change positive">
            <svg class="change-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
            </svg>
            <span>+3%</span>
        </div>
    </div>

    <!-- Total Clients -->
    <div class="stat-card" data-stat="clients">
        <div class="stat-header">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['total_clients'] ?? 0 }}</div>
                <div class="stat-label">کل کارفرمایان</div>
            </div>
        </div>
        <div class="stat-change positive">
            <svg class="change-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
            </svg>
            <span>+15%</span>
        </div>
    </div>

    <!-- Total Banks -->
    <div class="stat-card success" data-stat="banks">
        <div class="stat-header">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m2 0h1m-2 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['total_banks'] ?? 0 }}</div>
                <div class="stat-label">بانک‌های ثبت شده</div>
            </div>
        </div>
        <div class="stat-change positive">
            <svg class="change-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
            </svg>
            <span>+2%</span>
        </div>
    </div>
</div>
