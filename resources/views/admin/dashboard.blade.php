@extends('admin.layout')

@section('title', 'داشبورد مدیریت')

@section('content')
<div class="page-header">
    <h1 class="page-title">داشبورد مدیریت</h1>
    <p class="page-subtitle">خلاصه‌ای از عملکرد و فعالیت‌های شرکت کاخ‌سازان داروگ</p>
</div>

<!-- Quick Actions -->
@include('admin.partials.quick-actions')

<!-- Stats Cards -->
@include('admin.partials.stats-cards')

<!-- Content Sections -->
@include('admin.partials.content-sections')

<!-- Chart Section -->
@include('admin.partials.chart-section')
@endsection

@push('scripts')
<script>
    // Dashboard specific scripts
    let notificationCount = 5;
    setInterval(function() {
        const random = Math.random();
        if (random > 0.7) {
            notificationCount++;
            const badge = document.querySelector('.notification-badge');
            if (badge) {
                badge.textContent = notificationCount;
            }

            // Add new activity
            const activities = [
                'پروژه جدید اضافه شد',
                'کاربر جدید ثبت نام کرد',
                'پرداخت جدید دریافت شد',
                'پروژه به روزرسانی شد'
            ];

            const randomActivity = activities[Math.floor(Math.random() * activities.length)];
            console.log('فعالیت جدید:', randomActivity);
        }
    }, 10000);

    // Auto-save functionality simulation
    let autoSaveTimer;
    document.addEventListener('input', function() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(function() {
            console.log('تغییرات به صورت خودکار ذخیره شد');
        }, 2000);
    });

    // Real-time statistics update
    function updateStats() {
        fetch('/admin/api/stats')
            .then(response => response.json())
            .then(data => {
                // Update stats cards
                if (data.total_projects !== undefined) {
                    const projectCount = document.querySelector('.stat-card[data-stat="projects"] .stat-value');
                    if (projectCount) {
                        projectCount.textContent = data.total_projects;
                    }
                }

                if (data.active_projects !== undefined) {
                    const activeProjectCount = document.querySelector('.stat-card[data-stat="active-projects"] .stat-value');
                    if (activeProjectCount) {
                        activeProjectCount.textContent = data.active_projects;
                    }
                }

                if (data.total_employees !== undefined) {
                    const employeeCount = document.querySelector('.stat-card[data-stat="employees"] .stat-value');
                    if (employeeCount) {
                        employeeCount.textContent = data.total_employees;
                    }
                }

                if (data.total_clients !== undefined) {
                    const clientCount = document.querySelector('.stat-card[data-stat="clients"] .stat-value');
                    if (clientCount) {
                        clientCount.textContent = data.total_clients;
                    }
                }
            })
            .catch(error => {
                console.log('Error updating stats:', error);
            });
    }

    // Update stats every 30 seconds
    setInterval(updateStats, 30000);

    // Initialize charts if Chart.js is available
    if (typeof Chart !== 'undefined') {
        // Project status chart
        const projectStatusCtx = document.getElementById('projectStatusChart');
        if (projectStatusCtx) {
            new Chart(projectStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['در حال اجرا', 'تکمیل شده', 'در حال برنامه‌ریزی', 'متوقف شده'],
                    datasets: [{
                        data: [{{ $stats['active_projects'] ?? 0 }}, {{ $stats['completed_projects'] ?? 0 }}, 0, 0],
                        backgroundColor: ['#0077ff', '#00c853', '#ffb400', '#f44336']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // Monthly progress chart
        const progressCtx = document.getElementById('progressChart');
        if (progressCtx) {
            new Chart(progressCtx, {
                type: 'line',
                data: {
                    labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور'],
                    datasets: [{
                        label: 'پیشرفت پروژه‌ها',
                        data: [65, 72, 78, 85, 90, 95],
                        borderColor: '#0077ff',
                        backgroundColor: 'rgba(0, 119, 255, 0.1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        }
    }
</script>
@endpush
