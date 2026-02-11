<?php \App\Core\View::extends('layouts.public'); ?>

@section('title', $title ?? 'Welcome to BTC Crypto Investment')

<?php \App\Core\View::section('content'); ?>
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-blue-600 to-purple-700 text-white">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative max-w-7xl mx-auto px-4 py-24 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Invest in Bitcoin & Crypto
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100">
                High-yield investment opportunities with automated returns
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo htmlspecialchars(url('/register'), ENT_QUOTES, 'UTF-8'); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 px-8 rounded-lg text-lg transition duration-300">
                    Start Investing Now
                </a>
                <a href="<?php echo htmlspecialchars(url('/plans'), ENT_QUOTES, 'UTF-8'); ?>" class="bg-white bg-opacity-20 hover:bg-opacity-30 border-2 border-white text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-300">
                    View Investment Plans
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl font-bold text-blue-600 mb-2">$2.5M+</div>
                <div class="text-gray-600">Total Invested</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-green-600 mb-2">15,000+</div>
                <div class="text-gray-600">Happy Investors</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-purple-600 mb-2">99.9%</div>
                <div class="text-gray-600">Uptime</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-orange-600 mb-2">24/7</div>
                <div class="text-gray-600">Support</div>
            </div>
        </div>
    </div>
</section>

<!-- Investment Plans Preview -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Investment Plans
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Choose from our carefully designed investment plans with competitive returns and flexible terms.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <?php if(!empty($plans)): ?>
                <?php foreach($plans as $plan): ?>
                <div class="bg-white rounded-lg shadow-lg p-8 text-center border border-gray-200 hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">₿</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($plan['name'] ?? 'Plan', ENT_QUOTES, 'UTF-8'); ?></h3>
                    <div class="text-3xl font-bold text-blue-600 mb-2"><?php echo htmlspecialchars($plan['interest_rate'] ?? '0', ENT_QUOTES, 'UTF-8'); ?>%</div>
                    <div class="text-gray-600 mb-4">Daily Return</div>
                    <div class="text-sm text-gray-500 mb-6">
                        Min: $<?php echo htmlspecialchars(number_format($plan['min_amount'] ?? 0), ENT_QUOTES, 'UTF-8'); ?> -
                        Max: $<?php echo htmlspecialchars($plan['max_amount'] ? number_format($plan['max_amount']) : 'Unlimited', ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                    <a href="<?php echo htmlspecialchars(url('/register'), ENT_QUOTES, 'UTF-8'); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                        Choose Plan
                    </a>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500">No investment plans available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="text-center">
            <a href="<?php echo htmlspecialchars(url('/plans'), ENT_QUOTES, 'UTF-8'); ?>" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-300">
                View All Plans
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Why Choose Us?
            </h2>
            <p class="text-xl text-gray-600">
                We provide secure, reliable, and profitable investment opportunities
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Secure & Reliable</h3>
                <p class="text-gray-600">Your investments are protected with bank-level security and SSL encryption.</p>
            </div>

            <div class="text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">High Returns</h3>
                <p class="text-gray-600">Competitive interest rates with daily compounding for maximum profit potential.</p>
            </div>

            <div class="text-center">
                <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">24/7 Support</h3>
                <p class="text-gray-600">Round-the-clock customer support to assist you with any questions or concerns.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-blue-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">
            Ready to Start Your Investment Journey?
        </h2>
        <p class="text-xl mb-8 text-blue-100">
            Join thousands of investors who are already earning passive income with our platform.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo htmlspecialchars(url('/register'), ENT_QUOTES, 'UTF-8'); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-4 px-8 rounded-lg text-lg transition duration-300">
                Create Free Account
            </a>
            <a href="<?php echo htmlspecialchars(url('/contact'), ENT_QUOTES, 'UTF-8'); ?>" class="bg-white bg-opacity-20 hover:bg-opacity-30 border-2 border-white text-white font-bold py-4 px-8 rounded-lg text-lg transition duration-300">
                Contact Support
            </a>
        </div>
    </div>
</section>
<?php \App\Core\View::endsection(); ?>