<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $description ?? 'BTC Investment Dashboard - Manage Your Investments'; ?>">
    <meta name="keywords" content="bitcoin, crypto, investment, dashboard, portfolio">
    <meta name="author" content="BTC Investment">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo asset('images/favicon.ico'); ?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <link href="<?php echo asset('css/tailwind.css'); ?>" rel="stylesheet">
    <link href="<?php echo asset('css/app.css'); ?>" rel="stylesheet">

    <!-- Chart.js for dashboard charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .sidebar-link {
            @apply flex items-center px-4 py-3 text-sm font-medium rounded-lg transition duration-200;
        }

        .sidebar-link.active {
            @apply bg-blue-100 text-blue-700 border-r-2 border-blue-700;
        }

        .sidebar-link:hover {
            @apply bg-gray-100 text-gray-900;
        }

        .stat-card {
            @apply bg-white rounded-lg shadow-sm border border-gray-200 p-6;
        }

        .btn-primary {
            @apply bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200;
        }

        .btn-secondary {
            @apply bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-200;
        }

        .btn-danger {
            @apply bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200;
        }

        .mobile-sidebar {
            @apply fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0;
        }

        .mobile-sidebar.hidden {
            transform: translateX(-100%);
        }

        .mobile-overlay {
            @apply fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden;
        }

        .dropdown-menu {
            @apply absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 opacity-0 invisible transition-all duration-200;
        }

        .dropdown-menu.show {
            @apply opacity-100 visible;
        }
    </style>

    <title><?php echo $title ?? 'Dashboard'; ?> - <?php echo SITE_NAME; ?></title>

    <!-- Page-specific head content -->
    <?php echo $__env->yieldSection('head'); ?>
</head>
<body class="h-full bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar Overlay for Mobile -->
        <div id="sidebar-overlay" class="mobile-overlay hidden" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <div id="sidebar" class="mobile-sidebar hidden lg:block">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 px-4 bg-white border-b border-gray-200">
                    <a href="<?php echo url('/dashboard'); ?>" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">₿</span>
                        </div>
                        <span class="text-lg font-bold text-gray-900"><?php echo SITE_NAME; ?></span>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2">
                    <a href="<?php echo url('/dashboard'); ?>" class="sidebar-link <?php echo request()->is('/dashboard') ? 'active' : ''; ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                        </svg>
                        Dashboard
                    </a>

                    <a href="<?php echo url('/profile'); ?>" class="sidebar-link <?php echo request()->is('/profile') ? 'active' : ''; ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile
                    </a>

                    <a href="<?php echo url('/investments'); ?>" class="sidebar-link <?php echo request()->is('/investments') ? 'active' : ''; ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        My Investments
                    </a>

                    <a href="<?php echo url('/transactions'); ?>" class="sidebar-link <?php echo request()->is('/transactions') ? 'active' : ''; ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Transactions
                    </a>

                    <a href="<?php echo url('/referrals'); ?>" class="sidebar-link <?php echo request()->is('/referrals') ? 'active' : ''; ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Referrals
                    </a>

                    <a href="<?php echo url('/support'); ?>" class="sidebar-link <?php echo request()->is('/support') ? 'active' : ''; ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Support
                    </a>
                </nav>

                <!-- User Info & Logout -->
                <div class="p-4 border-t border-gray-200">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-medium text-sm">
                                <?php echo strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)); ?>
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                <?php echo auth()->user()->first_name . ' ' . auth()->user()->last_name; ?>
                            </p>
                            <p class="text-xs text-gray-500 truncate">
                                Balance: $<?php echo number_format(auth()->user()->balance, 2); ?>
                            </p>
                        </div>
                    </div>
                    <a href="<?php echo url('/logout'); ?>" class="w-full btn-danger text-center block">
                        Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm border-b border-gray-200 lg:hidden">
                <div class="flex items-center justify-between px-4 py-3">
                    <button onclick="toggleSidebar()" class="text-gray-500 hover:text-gray-700 p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">₿</span>
                        </div>
                        <span class="text-lg font-bold text-gray-900"><?php echo SITE_NAME; ?></span>
                    </div>

                    <div class="relative">
                        <button onclick="toggleUserMenu()" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 p-2">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-medium text-sm">
                                    <?php echo strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)); ?>
                                </span>
                            </div>
                        </button>

                        <div id="user-menu" class="dropdown-menu">
                            <div class="py-1">
                                <a href="<?php echo url('/profile'); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="<?php echo url('/logout'); ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 lg:p-6">
                <!-- Breadcrumb -->
                <div class="mb-6">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="<?php echo url('/dashboard'); ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                    <svg class="w-3 h-3 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2A1 1 0 0 0 1 10h2v10a1 1 0 0 0 1 1h10v-6a1 1 0 0 0 1-1v-1h2a1 1 0 0 0 .707-1.707Z"/>
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            <?php if (isset($breadcrumb)): ?>
                                <?php foreach ($breadcrumb as $item): ?>
                                    <li>
                                        <div class="flex items-center">
                                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                                            </svg>
                                            <?php if (isset($item['url'])): ?>
                                                <a href="<?php echo $item['url']; ?>" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                                                    <?php echo $item['title']; ?>
                                                </a>
                                            <?php else: ?>
                                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                                                    <?php echo $item['title']; ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ol>
                    </nav>
                </div>

                <!-- Flash Messages -->
                <?php if (session()->has('success')): ?>
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo session()->get('success'); ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('error')): ?>
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo session()->get('error'); ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('warning')): ?>
                    <div class="mb-4 bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-lg flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo session()->get('warning'); ?>
                    </div>
                <?php endif; ?>

                <!-- Main Content -->
                <?php echo $__env->yieldSection('content'); ?>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (sidebar.classList.contains('hidden')) {
                sidebar.classList.remove('hidden');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('hidden');
                overlay.classList.add('hidden');
            }
        }

        // User menu toggle
        function toggleUserMenu() {
            const menu = document.getElementById('user-menu');
            menu.classList.toggle('show');
        }

        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('user-menu');
            const button = event.target.closest('button');

            if (!menu.contains(event.target) && !button) {
                menu.classList.remove('show');
            }
        });

        // CSRF token setup for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Global AJAX setup
        if (typeof $ !== 'undefined') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });
        }

        // Auto-hide flash messages
        setTimeout(function() {
            const messages = document.querySelectorAll('.bg-green-50, .bg-red-50, .bg-yellow-50');
            messages.forEach(function(message) {
                message.style.transition = 'opacity 0.5s';
                message.style.opacity = '0';
                setTimeout(function() {
                    message.remove();
                }, 500);
            });
        }, 5000);
    </script>

    <!-- Page-specific scripts -->
    <?php echo $__env->yieldSection('scripts'); ?>
</body>
</html>