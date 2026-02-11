<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $description ?? 'BTC Investment - High Yield Investment Platform'; ?>">
    <meta name="keywords" content="bitcoin, crypto, investment, hyip, high yield">
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

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .mobile-menu {
            position: fixed;
            inset: 0;
            z-index: 50;
            background-color: white;
            transform: translateX(0);
            transition: transform 300ms ease-in-out;
        }

        .mobile-menu.hidden {
            transform: translateX(-100%);
        }
    </style>

    <title><?php echo $title ?? 'BTC Investment'; ?> - <?php echo SITE_NAME; ?></title>

    <!-- Page-specific head content -->
    <?php echo \App\Core\View::yield('head'); ?>
</head>
<body class="h-full bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-40 w-full">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="<?php echo url('/'); ?>" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">₿</span>
                        </div>
                        <span class="text-xl font-bold text-gray-900"><?php echo SITE_NAME; ?></span>
                    </a>
                </div>

                <!-- Desktop Navigation - Center -->
                <div class="hidden md:flex items-center space-x-8 absolute left-1/2 transform -translate-x-1/2">
                    <a href="<?php echo url('/'); ?>" class="<?php echo request()->is('/') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600'; ?> px-3 py-2 rounded-md text-sm font-medium transition duration-200">Home</a>
                    <a href="<?php echo url('/about'); ?>" class="<?php echo request()->is('/about') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600'; ?> px-3 py-2 rounded-md text-sm font-medium transition duration-200">About</a>
                    <a href="<?php echo url('/plans'); ?>" class="<?php echo request()->is('/plans') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600'; ?> px-3 py-2 rounded-md text-sm font-medium transition duration-200">Plans</a>
                    <a href="<?php echo url('/faqs'); ?>" class="<?php echo request()->is('/faqs') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600'; ?> px-3 py-2 rounded-md text-sm font-medium transition duration-200">FAQs</a>
                    <a href="<?php echo url('/services'); ?>" class="<?php echo request()->is('/services') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600'; ?> px-3 py-2 rounded-md text-sm font-medium transition duration-200">Services</a>
                    <a href="<?php echo url('/contact'); ?>" class="<?php echo request()->is('/contact') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600'; ?> px-3 py-2 rounded-md text-sm font-medium transition duration-200">Contact</a>
                </div>

                <!-- Desktop Navigation - Right -->
                <div class="hidden md:flex items-center space-x-3">
                    <?php if (auth()->check()): ?>
                        <a href="<?php echo url('/dashboard'); ?>" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-200">Dashboard</a>
                        <a href="<?php echo url('/logout'); ?>" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">Logout</a>
                    <?php else: ?>
                        <a href="<?php echo url('/login'); ?>" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">Login</a>
                        <a href="<?php echo url('/register'); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">Register</a>
                    <?php endif; ?>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button" id="mobile-menu-button" class="text-gray-700 hover:text-blue-600 p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="mobile-menu hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-200">
                <a href="<?php echo url('/'); ?>" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-md">Home</a>
                <a href="<?php echo url('/about'); ?>" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-md">About</a>
                <a href="<?php echo url('/plans'); ?>" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-md">Plans</a>
                <a href="<?php echo url('/faqs'); ?>" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-md">FAQs</a>
                <a href="<?php echo url('/services'); ?>" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-md">Services</a>
                <a href="<?php echo url('/contact'); ?>" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-md">Contact</a>

                <?php if (auth()->check()): ?>
                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <a href="<?php echo url('/dashboard'); ?>" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-md">Dashboard</a>
                        <a href="<?php echo url('/logout'); ?>" class="block px-3 py-2 text-base font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded-md">Logout</a>
                    </div>
                <?php else: ?>
                    <div class="border-t border-gray-200 pt-4 mt-4 space-y-2">
                        <a href="<?php echo url('/login'); ?>" class="block w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg text-center transition duration-200">Login</a>
                        <a href="<?php echo url('/register'); ?>" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg text-center transition duration-200">Register</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1">
        <?php echo \App\Core\View::yield('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">₿</span>
                        </div>
                        <span class="text-xl font-bold"><?php echo SITE_NAME; ?></span>
                    </div>
                    <p class="text-gray-400 mb-4 text-sm">
                        <?php echo SITE_DESCRIPTION; ?> Join thousands of investors who trust us with their cryptocurrency investments.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="<?php echo url('/about'); ?>" class="text-gray-400 hover:text-white transition duration-200">About Us</a></li>
                        <li><a href="<?php echo url('/plans'); ?>" class="text-gray-400 hover:text-white transition duration-200">Investment Plans</a></li>
                        <li><a href="<?php echo url('/contact'); ?>" class="text-gray-400 hover:text-white transition duration-200">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Help Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Live Chat</a></li>
                        <li><a href="mailto:support@btc-investment.com" class="text-gray-400 hover:text-white transition duration-200">support@btc-investment.com</a></li>
                        <li><span class="text-gray-400">24/7 Support</span></li>
                    </ul>
                </div>
              <!-- Newsletter Subscription -->
                <div>
                    <h3 class="text-lg font-semibold mb-2">Stay Updated</h3>
                    <p class="text-gray-400 mb-4 text-sm">
                        Subscribe to our newsletter for the latest investment opportunities, market insights, and exclusive offers.
                    </p>
                    <form action="<?php echo url('/newsletter/subscribe'); ?>" method="POST" class="flex flex-col sm:flex-row gap-2">
                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                        <input 
                            type="email" 
                            name="email" 
                            placeholder="Enter your email address" 
                            required
                            class="flex-1 px-4 py-3 bg-gray-800 text-white border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-500 transition duration-200"
                        >
                        <button 
                            type="submit"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200 whitespace-nowrap"
                        >
                            Subscribe
                        </button>
                    </form>
                    <p class="text-gray-500 text-xs mt-3">
                        We respect your privacy. Unsubscribe at any time.
                    </p>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">
                    &copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobile-menu');
            const button = document.getElementById('mobile-menu-button');

            if (!menu.contains(event.target) && !button.contains(event.target)) {
                menu.classList.add('hidden');
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
    </script>

    <!-- Page-specific scripts -->
    <?php echo \App\Core\View::yield('scripts'); ?>
</body>
</html>