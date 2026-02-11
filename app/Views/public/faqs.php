@extends('layouts.public')

@section('title', 'Frequently Asked Questions')
@section('description', 'Find answers to common questions about BTC Investment, cryptocurrency investing, account management, and our services.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white py-16">
    <div class="absolute inset-0 bg-black bg-opacity-20"></div>
    <div class="relative w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Frequently Asked <span class="text-yellow-400">Questions</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto leading-relaxed">
                Everything you need to know about investing with BTC Investment
            </p>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16 bg-white">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Getting Started -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Getting Started</h2>
                <div class="space-y-4">
                    <div class="border border-gray-200 rounded-lg">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                            <span class="text-lg font-medium text-gray-900">How do I create an account?</span>
                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-700 leading-relaxed">
                                Creating an account is simple and takes less than 5 minutes. Click the "Register" button in the top navigation,
                                fill out the registration form with your personal information, and verify your email address. Once verified,
                                you can log in and start investing immediately.
                            </p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                            <span class="text-lg font-medium text-gray-900">What documents do I need to verify my account?</span>
                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-700 leading-relaxed mb-3">
                                For account verification, we require:
                            </p>
                            <ul class="list-disc list-inside text-gray-700 space-y-1">
                                <li>Government-issued ID (passport, driver's license, or national ID)</li>
                                <li>Proof of address (utility bill, bank statement, or similar)</li>
                                <li>Selfie with your ID for verification</li>
                            </ul>
                            <p class="text-gray-700 leading-relaxed mt-3">
                                This helps us comply with KYC/AML regulations and ensures the security of your account.
                            </p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                            <span class="text-lg font-medium text-gray-900">Is BTC Investment available in my country?</span>
                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-700 leading-relaxed">
                                BTC Investment is available in most countries worldwide. However, due to regulatory restrictions,
                                we are currently unable to serve users from certain countries including the United States, North Korea,
                                and some other restricted jurisdictions. Please check our terms of service for the complete list of
                                restricted countries.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Investments -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Investments</h2>
                <div class="space-y-4">
                    <div class="border border-gray-200 rounded-lg">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                            <span class="text-lg font-medium text-gray-900">How do investment plans work?</span>
                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-700 leading-relaxed">
                                Our investment plans offer different return rates and terms. You choose a plan, make a deposit,
                                and your investment grows according to the plan's specifications. Returns are calculated daily
                                and can be compounded or withdrawn. Each plan has minimum and maximum investment amounts,
                                and you can view detailed information about each plan on our Plans page.
                            </p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                            <span class="text-lg font-medium text-gray-900">What are the minimum and maximum investment amounts?</span>
                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-700 leading-relaxed">
                                Investment amounts vary by plan. Our Starter plan has a minimum of $10 and maximum of $1,000,
                                while our VIP plan requires a minimum of $5,000 with no upper limit. You can view specific
                                limits for each plan on our investment plans page. Multiple investments in different plans
                                are allowed.
                            </p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                            <span class="text-lg font-medium text-gray-900">How often are returns paid?</span>
                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-700 leading-relaxed">
                                Returns are calculated and credited to your account daily. You can choose to compound your
                                returns (add them back to your principal for higher future returns) or withdraw them at any time.
                                Daily compounding is recommended for maximum growth, but you have full control over your earnings.
                            </p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                            <span class="text-lg font-medium text-gray-900">Can I withdraw my principal investment?</span>
                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-700 leading-relaxed">
                                Yes, you can withdraw your principal investment at any time. However, please note that some plans
                                have minimum investment periods. Early withdrawal from these plans may result in forfeiture of
                                accrued returns for the period. You can view withdrawal terms for each plan on the Plans page.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deposits & Withdrawals -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Deposits & Withdrawals</h2>
                <div class="space-y-4">
                    <div class="border border-gray-200 rounded-lg">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                            <span class="text-lg font-medium text-gray-900">What payment methods do you accept?</span>
                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-700 leading-relaxed mb-3">
                                We accept multiple cryptocurrencies and traditional payment methods:
                            </p>
                            <ul class="list-disc list-inside text-gray-700 space-y-1">
                                <li>Bitcoin (BTC)</li>
                                <li>Ethereum (ETH)</li>
                                <li>USDT (Tether)</li>
                                <li>Bank transfers</li>
                                <li>Credit/Debit cards</li>
                            </ul>
                            <p class="text-gray-700 leading-relaxed mt-3">
                                All deposits are processed instantly, and withdrawals are typically processed within 24 hours.
                            </p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                            <span class="text-lg font-medium text-gray-900">How long do withdrawals take?</span>
                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-700 leading-relaxed">
                                Withdrawal processing times vary by payment method:
                            </p>
                            <ul class="list-disc list-inside text-gray-700 space-y-1 mt-2">
                                <li>Cryptocurrency withdrawals: 1-6 hours</li>
                                <li>Bank transfers: 1-3 business days</li>
                                <li>Credit/Debit cards: 1-5 business days</li>
                            </ul>
                            <p class="text-gray-700 leading-relaxed mt-3">
                                All withdrawal requests are reviewed and processed during business hours (Monday-Friday, 9 AM - 6 PM UTC).
                            </p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                            <span class="text-lg font-medium text-gray-900">Are there any fees for deposits or withdrawals?</span>
                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-700 leading-relaxed">
                                Deposits are completely free. For withdrawals, we only charge network fees for cryptocurrency
                                transactions. Bank transfers and card withdrawals may incur third-party processing fees,
                                which are clearly displayed before you confirm the withdrawal. We never charge hidden fees.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security & Support -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Security & Support</h2>
                <div class="space-y-4">
                    <div class="border border-gray-200 rounded-lg">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                            <span class="text-lg font-medium text-gray-900">How secure is my investment?</span>
                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-700 leading-relaxed">
                                Security is our top priority. We use bank-level encryption, multi-signature wallets, and cold storage
                                for funds. Our platform undergoes regular security audits and penetration testing. All user data
                                is encrypted and stored securely. We are fully compliant with international financial regulations.
                            </p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg">
                        <button class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                            <span class="text-lg font-medium text-gray-900">How can I contact customer support?</span>
                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-4">
                            <p class="text-gray-700 leading-relaxed mb-3">
                                You can reach our support team through multiple channels:
                            </p>
                            <ul class="list-disc list-inside text-gray-700 space-y-1">
                                <li>Live chat on our website (available 24/7)</li>
                                <li>Email: support@btc-investment.com</li>
                                <li>Support ticket system in your dashboard</li>
                                <li>Phone: +1 (555) 123-4567 (business hours)</li>
                            </ul>
                            <p class="text-gray-700 leading-relaxed mt-3">
                                Our average response time is under 2 hours during business hours.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Support Section -->
<section class="py-16 bg-gray-900 text-white">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Still Have Questions?</h2>
        <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
            Our support team is here to help you with any questions or concerns.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo url('/contact'); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200">
                Contact Support
            </a>
            <a href="<?php echo url('/register'); ?>" class="border-2 border-white text-white hover:bg-white hover:text-gray-900 font-bold py-3 px-8 rounded-lg transition duration-200">
                Start Investing
            </a>
        </div>
    </div>
</section>

<script>
// FAQ Accordion functionality
document.addEventListener('DOMContentLoaded', function() {
    const faqToggles = document.querySelectorAll('.faq-toggle');

    faqToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const content = this.nextElementSibling;
            const icon = this.querySelector('svg');

            // Toggle content visibility
            content.classList.toggle('hidden');

            // Rotate icon
            icon.classList.toggle('rotate-180');

            // Close other FAQs
            faqToggles.forEach(otherToggle => {
                if (otherToggle !== this) {
                    const otherContent = otherToggle.nextElementSibling;
                    const otherIcon = otherToggle.querySelector('svg');

                    otherContent.classList.add('hidden');
                    otherIcon.classList.remove('rotate-180');
                }
            });
        });
    });
});
</script>
@endsection