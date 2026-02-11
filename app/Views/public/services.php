@extends('layouts.public')

@section('title', 'Our Services')
@section('description', 'Discover the comprehensive financial services offered by BTC Investment including investment management, portfolio tracking, and personalized financial advice.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white py-20">
    <div class="absolute inset-0 bg-black bg-opacity-20"></div>
    <div class="relative w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Our <span class="text-yellow-400">Services</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto leading-relaxed">
                Comprehensive financial services designed to maximize your investment potential and secure your financial future.
            </p>
        </div>
    </div>
</section>

<!-- Services Overview -->
<section class="py-16 bg-white">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">What We Offer</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                From investment management to personalized financial advice, we provide everything you need for successful investing.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Investment Management -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition duration-300">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Investment Management</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Professional portfolio management with diversified investment strategies across multiple cryptocurrencies and traditional assets.
                </p>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li>• Daily portfolio monitoring</li>
                    <li>• Risk assessment & management</li>
                    <li>• Performance optimization</li>
                    <li>• Tax-efficient strategies</li>
                </ul>
            </div>

            <!-- Portfolio Tracking -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition duration-300">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Portfolio Tracking</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Real-time portfolio monitoring with detailed analytics, performance reports, and automated alerts for market changes.
                </p>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li>• Real-time price updates</li>
                    <li>• Performance analytics</li>
                    <li>• Automated alerts</li>
                    <li>• Historical data analysis</li>
                </ul>
            </div>

            <!-- Financial Advisory -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition duration-300">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Financial Advisory</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Personalized financial advice from certified investment advisors to help you make informed investment decisions.
                </p>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li>• Personalized strategies</li>
                    <li>• Risk tolerance assessment</li>
                    <li>• Goal-based planning</li>
                    <li>• Market insights</li>
                </ul>
            </div>

            <!-- Deposit Services -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition duration-300">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Deposit Services</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Secure and instant deposit processing with multiple payment methods including cryptocurrencies and traditional banking.
                </p>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li>• Multiple payment methods</li>
                    <li>• Instant processing</li>
                    <li>• Secure transactions</li>
                    <li>• No hidden fees</li>
                </ul>
            </div>

            <!-- Withdrawal Services -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition duration-300">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Withdrawal Services</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Fast and secure withdrawal processing with priority handling for VIP members and competitive processing times.
                </p>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li>• Fast processing</li>
                    <li>• Multiple withdrawal methods</li>
                    <li>• Priority VIP service</li>
                    <li>• Secure verification</li>
                </ul>
            </div>

            <!-- Customer Support -->
            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg transition duration-300">
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">24/7 Customer Support</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Round-the-clock customer support through multiple channels including live chat, email, and phone for all your needs.
                </p>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li>• 24/7 live support</li>
                    <li>• Multiple contact channels</li>
                    <li>• Expert assistance</li>
                    <li>• Quick response times</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="py-16 bg-gray-50">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">How It Works</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Getting started with BTC Investment is simple. Follow these easy steps to begin your investment journey.
            </p>
        </div>

        <div class="grid md:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white font-bold text-xl">
                    1
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Create Account</h3>
                <p class="text-gray-600 leading-relaxed">
                    Sign up for a free account in minutes. Complete verification and set up your security preferences.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white font-bold text-xl">
                    2
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Choose Plan</h3>
                <p class="text-gray-600 leading-relaxed">
                    Select an investment plan that matches your goals and risk tolerance from our range of options.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white font-bold text-xl">
                    3
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Make Deposit</h3>
                <p class="text-gray-600 leading-relaxed">
                    Fund your account using your preferred payment method. Deposits are processed instantly.
                </p>
            </div>

            <!-- Step 4 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-yellow-600 rounded-full flex items-center justify-center mx-auto mb-6 text-white font-bold text-xl">
                    4
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Start Earning</h3>
                <p class="text-gray-600 leading-relaxed">
                    Watch your investment grow with daily compounding returns. Monitor progress in your dashboard.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-16 bg-white">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">What Our Clients Say</h2>
            <p class="text-lg text-gray-600">Real experiences from our satisfied investors</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-gray-50 rounded-xl p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold mr-4">
                        JD
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">John Davis</h4>
                        <div class="flex text-yellow-400">
                            ★★★★★
                        </div>
                    </div>
                </div>
                <p class="text-gray-600 italic leading-relaxed">
                    "BTC Investment has transformed my financial future. The returns are consistent and the platform is incredibly user-friendly. Highly recommended!"
                </p>
            </div>

            <div class="bg-gray-50 rounded-xl p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-bold mr-4">
                        SM
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Sarah Miller</h4>
                        <div class="flex text-yellow-400">
                            ★★★★★
                        </div>
                    </div>
                </div>
                <p class="text-gray-600 italic leading-relaxed">
                    "The customer support is outstanding. They helped me through every step of my investment journey. My portfolio has grown significantly."
                </p>
            </div>

            <div class="bg-gray-50 rounded-xl p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center text-white font-bold mr-4">
                        RC
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Robert Chen</h4>
                        <div class="flex text-yellow-400">
                            ★★★★★
                        </div>
                    </div>
                </div>
                <p class="text-gray-600 italic leading-relaxed">
                    "Professional service with excellent returns. The VIP plan exceeded my expectations. This is the future of investing."
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Security Section -->
<section class="py-16 bg-gray-900 text-white">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4">Your Security is Our Priority</h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                We employ bank-level security measures to protect your investments and personal information.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-4">SSL Encryption</h3>
                <p class="text-gray-300 leading-relaxed">
                    All data is encrypted with 256-bit SSL certificates for maximum security.
                </p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-4">Cold Storage</h3>
                <p class="text-gray-300 leading-relaxed">
                    95% of funds are stored in offline cold wallets for maximum protection.
                </p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-4">KYC Verified</h3>
                <p class="text-gray-300 leading-relaxed">
                    Full compliance with international KYC and AML regulations.
                </p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-yellow-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-4">24/7 Monitoring</h3>
                <p class="text-gray-300 leading-relaxed">
                    Round-the-clock security monitoring and threat detection systems.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Experience Our Services?</h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
            Join thousands of investors who trust BTC Investment with their financial future.
            Start your journey today with our comprehensive investment services.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo url('/register'); ?>" class="bg-white text-blue-600 hover:bg-gray-100 font-bold py-3 px-8 rounded-lg transition duration-200">
                Get Started Now
            </a>
            <a href="<?php echo url('/plans'); ?>" class="border-2 border-white text-white hover:bg-white hover:text-blue-600 font-bold py-3 px-8 rounded-lg transition duration-200">
                View Investment Plans
            </a>
        </div>
    </div>
</section>
@endsection