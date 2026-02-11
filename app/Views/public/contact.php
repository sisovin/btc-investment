@extends('layouts.public')

@section('title', 'Contact Us')
@section('description', 'Get in touch with BTC Investment. Our support team is available 24/7 to help with your investment questions and concerns.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white py-16">
    <div class="absolute inset-0 bg-black bg-opacity-20"></div>
    <div class="relative w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Contact <span class="text-yellow-400">Us</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto leading-relaxed">
                We're here to help. Reach out to our support team anytime.
            </p>
        </div>
    </div>
</section>

<!-- Contact Information -->
<section class="py-16 bg-white">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Send us a Message</h2>
                <p class="text-gray-600 mb-8">
                    Have a question about our services? Need help with your account? We're here to help.
                    Fill out the form below and we'll get back to you within 24 hours.
                </p>

                <form action="<?php echo url('/contact/submit'); ?>" method="POST" class="space-y-6">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                            <input
                                type="text"
                                id="first_name"
                                name="first_name"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="John"
                            >
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                            <input
                                type="text"
                                id="last_name"
                                name="last_name"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Doe"
                            >
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="john@example.com"
                        >
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
                        <select
                            id="subject"
                            name="subject"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                            <option value="">Select a subject</option>
                            <option value="general">General Inquiry</option>
                            <option value="investment">Investment Questions</option>
                            <option value="technical">Technical Support</option>
                            <option value="withdrawal">Withdrawal Issues</option>
                            <option value="account">Account Issues</option>
                            <option value="partnership">Partnership Opportunities</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                        <textarea
                            id="message"
                            name="message"
                            rows="6"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                            placeholder="Please describe your question or concern in detail..."
                        ></textarea>
                    </div>

                    <div class="flex items-start">
                        <input
                            type="checkbox"
                            id="newsletter"
                            name="newsletter"
                            class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        >
                        <label for="newsletter" class="ml-2 text-sm text-gray-600">
                            Subscribe to our newsletter for investment updates and market insights
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200"
                    >
                        Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Get in Touch</h2>

                <!-- Contact Methods -->
                <div class="space-y-6 mb-8">
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Email Support</h3>
                            <p class="text-gray-600 mb-1">support@btc-investment.com</p>
                            <p class="text-sm text-gray-500">We respond within 24 hours</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Phone Support</h3>
                            <p class="text-gray-600 mb-1">+1 (555) 123-4567</p>
                            <p class="text-sm text-gray-500">Mon-Fri 9AM-6PM UTC</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Live Chat</h3>
                            <p class="text-gray-600 mb-1">Available 24/7</p>
                            <p class="text-sm text-gray-500">Instant support for urgent issues</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Office Address</h3>
                            <p class="text-gray-600 mb-1">123 Financial District<br>Business Bay, Dubai<br>United Arab Emirates</p>
                            <p class="text-sm text-gray-500">Registered office location</p>
                        </div>
                    </div>
                </div>

                <!-- Response Time -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-3">Response Times</h3>
                    <div class="space-y-2 text-sm text-blue-800">
                        <div class="flex justify-between">
                            <span>Live Chat:</span>
                            <span class="font-medium">Instant</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Email:</span>
                            <span class="font-medium">Within 24 hours</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Phone:</span>
                            <span class="font-medium">Business hours</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-16 bg-gray-50">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Find Us</h2>
            <p class="text-gray-600">Our global headquarters and support centers</p>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="aspect-w-16 aspect-h-9 bg-gray-200 flex items-center justify-center">
                <div class="text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <p class="text-lg font-medium">Interactive Map</p>
                    <p class="text-sm">123 Financial District, Business Bay, Dubai, UAE</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16 bg-white">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Quick answers to common questions before you contact us
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            <div class="border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">How do I reset my password?</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Click "Forgot Password" on the login page and follow the instructions sent to your email.
                </p>
            </div>

            <div class="border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">How long do withdrawals take?</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Cryptocurrency withdrawals take 1-6 hours, bank transfers 1-3 business days.
                </p>
            </div>

            <div class="border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Is my investment secure?</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Yes, we use bank-level security with encryption, multi-signature wallets, and cold storage.
                </p>
            </div>

            <div class="border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Can I invest in multiple plans?</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Absolutely! You can invest in multiple plans simultaneously for diversified returns.
                </p>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="<?php echo url('/faqs'); ?>" class="text-blue-600 hover:text-blue-700 font-medium">
                View all FAQs →
            </a>
        </div>
    </div>
</section>
@endsection