@extends('layouts.public')

@section('title', 'About Us')
@section('description', 'Learn about BTC Investment - Your trusted cryptocurrency investment platform with years of experience in high-yield investments.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white py-20">
    <div class="absolute inset-0 bg-black bg-opacity-20"></div>
    <div class="relative w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                About <span class="text-yellow-400">BTC Investment</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto leading-relaxed">
                Your trusted cryptocurrency investment platform with over 5 years of experience in providing high-yield investment opportunities.
            </p>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-white">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl font-bold text-blue-600 mb-2">5+</div>
                <div class="text-gray-600">Years Experience</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-blue-600 mb-2">10K+</div>
                <div class="text-gray-600">Happy Investors</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-blue-600 mb-2">$50M+</div>
                <div class="text-gray-600">Total Invested</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-blue-600 mb-2">99.9%</div>
                <div class="text-gray-600">Uptime</div>
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="py-16 bg-gray-50">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Story</h2>
                <p class="text-lg text-gray-600">How we started and where we're going</p>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Founded in 2019</h3>
                    <p class="text-gray-700 mb-6 leading-relaxed">
                        BTC Investment was founded with a simple mission: to make cryptocurrency investment accessible to everyone.
                        We recognized the potential of blockchain technology early on and decided to create a platform that would
                        allow both experienced traders and newcomers to benefit from the crypto market's growth.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        Over the years, we've grown from a small startup to one of the most trusted names in cryptocurrency
                        investment, serving thousands of investors worldwide and managing millions in assets.
                    </p>
                </div>
                <div class="relative">
                    <img src="<?php echo asset('images/about-team.jpg'); ?>" alt="Our Team" class="rounded-lg shadow-lg w-full" onerror="this.src='https://via.placeholder.com/500x400/4F46E5/FFFFFF?text=BTC+Investment+Team'">
                    <div class="absolute -bottom-4 -right-4 bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold">
                        Professional Team
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-16 bg-white">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12">
            <!-- Mission -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-8 rounded-xl">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Our Mission</h3>
                </div>
                <p class="text-gray-700 leading-relaxed">
                    To democratize cryptocurrency investment by providing a secure, transparent, and user-friendly platform
                    that empowers individuals to grow their wealth through strategic crypto investments while maintaining
                    the highest standards of security and customer service.
                </p>
            </div>

            <!-- Vision -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-8 rounded-xl">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Our Vision</h3>
                </div>
                <p class="text-gray-700 leading-relaxed">
                    To become the world's leading cryptocurrency investment platform, setting the standard for security,
                    transparency, and innovation in the digital asset space. We envision a future where everyone can
                    confidently invest in cryptocurrencies with peace of mind.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-16 bg-gray-900 text-white">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Why Choose BTC Investment</h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                What sets us apart from other investment platforms
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-4">Bank-Level Security</h3>
                <p class="text-gray-300 leading-relaxed">
                    Advanced encryption, multi-signature wallets, and cold storage ensure your investments are protected
                    with the highest security standards in the industry.
                </p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-4">Licensed & Regulated</h3>
                <p class="text-gray-300 leading-relaxed">
                    Fully licensed and regulated financial institution with compliance certifications and regular
                    audits to ensure transparency and legal compliance.
                </p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-yellow-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-4">High Returns</h3>
                <p class="text-gray-300 leading-relaxed">
                    Competitive interest rates and strategic investment approaches deliver consistent returns
                    while maintaining sustainable growth for our investors.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-16 bg-white">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Meet Our Leadership Team</h2>
            <p class="text-lg text-gray-600">The experts behind BTC Investment</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-32 h-32 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <span class="text-4xl text-white font-bold">JD</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">John Doe</h3>
                <p class="text-blue-600 font-medium mb-4">CEO & Founder</p>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Former Wall Street trader with 15+ years experience in financial markets and blockchain technology.
                </p>
            </div>

            <div class="text-center">
                <div class="w-32 h-32 bg-gradient-to-br from-green-400 to-green-600 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <span class="text-4xl text-white font-bold">JS</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Jane Smith</h3>
                <p class="text-blue-600 font-medium mb-4">CTO</p>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Cybersecurity expert and blockchain developer with extensive experience in secure financial systems.
                </p>
            </div>

            <div class="text-center">
                <div class="w-32 h-32 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <span class="text-4xl text-white font-bold">MJ</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Mike Johnson</h3>
                <p class="text-blue-600 font-medium mb-4">Head of Investments</p>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Cryptocurrency analyst and portfolio manager specializing in DeFi and traditional finance integration.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Start Your Investment Journey?</h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
            Join thousands of successful investors who trust BTC Investment with their financial future.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo url('/register'); ?>" class="bg-white text-blue-600 hover:bg-gray-100 font-bold py-3 px-8 rounded-lg transition duration-200">
                Start Investing Today
            </a>
            <a href="<?php echo url('/plans'); ?>" class="border-2 border-white text-white hover:bg-white hover:text-blue-600 font-bold py-3 px-8 rounded-lg transition duration-200">
                View Investment Plans
            </a>
        </div>
    </div>
</section>
@endsection