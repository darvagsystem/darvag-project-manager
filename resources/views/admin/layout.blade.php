<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'پنل مدیریت') - {{ $companySettings->company_name ?? 'شرکت کاخ‌سازان داروگ' }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.0.96/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Header -->
        @include('admin.partials.header')

        <!-- Content -->
        <div class="admin-content">
            @yield('content')
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar toggle
            const sidebarToggle = document.createElement('button');
            sidebarToggle.className = 'mobile-toggle';
            sidebarToggle.innerHTML = '☰';
            sidebarToggle.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 1001; background: var(--primary-color); color: white; border: none; padding: 10px; border-radius: 5px; display: none;';

            if (window.innerWidth <= 768) {
                document.body.appendChild(sidebarToggle);
                sidebarToggle.style.display = 'block';
            }

            sidebarToggle.addEventListener('click', function() {
                const sidebar = document.querySelector('.admin-sidebar');
                sidebar.classList.toggle('open');
            });

            // Theme toggle
            const themeToggle = document.querySelector('.theme-toggle');
            if (themeToggle) {
                themeToggle.addEventListener('click', function() {
                    document.body.classList.toggle('dark-theme');

                    // Update icon
                    const icon = this.querySelector('svg path');
                    if (document.body.classList.contains('dark-theme')) {
                        icon.setAttribute('d', 'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z');
                    } else {
                        icon.setAttribute('d', 'M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z');
                    }
                });
            }

            // Responsive handling
            window.addEventListener('resize', function() {
                if (window.innerWidth <= 768) {
                    sidebarToggle.style.display = 'block';
                } else {
                    sidebarToggle.style.display = 'none';
                    const sidebar = document.querySelector('.admin-sidebar');
                    if (sidebar) {
                        sidebar.classList.remove('open');
                    }
                }
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
    @yield('scripts')
</body>
</html>
