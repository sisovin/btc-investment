@extends('layouts.public')

@section('title', 'Investment Plans')
@section('description', 'Explore our high-yield investment plans at BTC Investment. Choose from Starter, Premium, and VIP plans with competitive returns and flexible terms.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white py-20">
    <div class="absolute inset-0 bg-black bg-opacity-20"></div>
    <div class="relative w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Investment <span class="text-yellow-400">Plans</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto leading-relaxed">
                Choose the perfect investment plan for your financial goals. High returns, flexible terms, and secure investments.
            </p>
        </div>
    </div>
</section>

<!-- Investment Plans -->
<section class="py-16 bg-white">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Choose Your Investment Plan</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                All plans offer daily compounding returns and instant withdrawals. Start with any amount that fits your budget.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Starter Plan -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6">
                    <h3 class="text-2xl font-bold mb-2">Starter Plan</h3>
                    <div class="text-4xl font-bold mb-1">2.5%</div>
                    <div class="text-green-100">Daily Return</div>
                </div>

                <div class="p-6">
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Minimum Investment:</span>
                            <span class="font-semibold text-gray-900">$10</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Maximum Investment:</span>
                            <span class="font-semibold text-gray-900">$1,000</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Investment Period:</span>
                            <span class="font-semibold text-gray-900">30 Days</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Total Return:</span>
                            <span class="font-semibold text-green-600">75%</span>
                        </div>
                    </div>

                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Daily compounding returns
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Instant withdrawals
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            24/7 customer support
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Principal refundable
                        </li>
                    </ul>

                    <a href="<?php echo url('/register'); ?>" class="block w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-200">
                        Start Investing
                    </a>
                </div>
            </div>

            <!-- Premium Plan -->
            <div class="bg-white border-2 border-blue-500 rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden relative">
                <div class="absolute top-0 right-0 bg-blue-500 text-white px-3 py-1 text-sm font-medium rounded-bl-lg">
                    Most Popular
                </div>

                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6">
                    <h3 class="text-2xl font-bold mb-2">Premium Plan</h3>
                    <div class="text-4xl font-bold mb-1">3.5%</div>
                    <div class="text-blue-100">Daily Return</div>
                </div>

                <div class="p-6">
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Minimum Investment:</span>
                            <span class="font-semibold text-gray-900">$500</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Maximum Investment:</span>
                            <span class="font-semibold text-gray-900">$10,000</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Investment Period:</span>
                            <span class="font-semibold text-gray-900">45 Days</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Total Return:</span>
                            <span class="font-semibold text-blue-600">157.5%</span>
                        </div>
                    </div>

                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Daily compounding returns
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Priority withdrawals
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Dedicated account manager
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Monthly performance reports
                        </li>
                    </ul>

                    <a href="<?php echo url('/register'); ?>" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-200">
                        Start Investing
                    </a>
                </div>
            </div>

            <!-- VIP Plan -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6">
                    <h3 class="text-2xl font-bold mb-2">VIP Plan</h3>
                    <div class="text-4xl font-bold mb-1">5.0%</div>
                    <div class="text-purple-100">Daily Return</div>
                </div>

                <div class="p-6">
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Minimum Investment:</span>
                            <span class="font-semibold text-gray-900">$5,000</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Maximum Investment:</span>
                            <span class="font-semibold text-gray-900">Unlimited</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Investment Period:</span>
                            <span class="font-semibold text-gray-900">60 Days</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Total Return:</span>
                            <span class="font-semibold text-purple-600">300%</span>
                        </div>
                    </div>

                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-purple-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Daily compounding returns
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-purple-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Instant VIP withdrawals
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-purple-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Personal investment advisor
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-purple-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Exclusive market insights
                        </li>
                    </ul>

                    <a href="<?php echo url('/register'); ?>" class="block w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-200">
                        Start Investing
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Calculator Section -->
<section class="py-16 bg-gray-50">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Investment Calculator</h2>
                <p class="text-lg text-gray-600">
                    Calculate your potential returns with our investment calculator
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Calculator Inputs -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Calculate Returns</h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Investment Amount ($)</label>
                                <input
                                    type="number"
                                    id="calc-amount"
                                    min="10"
                                    max="100000"
                                    value="1000"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Investment Plan</label>
                                <select id="calc-plan" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="starter">Starter Plan (2.5% daily)</option>
                                    <option value="premium" selected>Premium Plan (3.5% daily)</option>
                                    <option value="vip">VIP Plan (5.0% daily)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Investment Period (Days)</label>
                                <input
                                    type="number"
                                    id="calc-days"
                                    min="1"
                                    max="365"
                                    value="30"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                            </div>

                            <button
                                id="calculate-btn"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200"
                            >
                                Calculate Returns
                            </button>
                        </div>
                    </div>

                    <!-- Calculator Results -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Your Returns</h3>

                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-sm text-gray-600 mb-1">Daily Return</div>
                                <div class="text-2xl font-bold text-green-600" id="daily-return">$35.00</div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-sm text-gray-600 mb-1">Total Returns</div>
                                <div class="text-2xl font-bold text-blue-600" id="total-returns">$1,050.00</div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-sm text-gray-600 mb-1">Final Amount</div>
                                <div class="text-2xl font-bold text-purple-600" id="final-amount">$2,050.00</div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-sm text-gray-600 mb-1">Return Percentage</div>
                                <div class="text-2xl font-bold text-orange-600" id="return-percentage">105.00%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose Our Plans</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                We offer competitive returns with industry-leading security and customer service
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">High Returns</h3>
                <p class="text-gray-600 leading-relaxed">
                    Competitive daily returns that compound automatically for maximum growth potential.
                </p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Secure & Safe</h3>
                <p class="text-gray-600 leading-relaxed">
                    Bank-level security with encrypted transactions and secure wallet storage.
                </p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Instant Access</h3>
                <p class="text-gray-600 leading-relaxed">
                    Quick deposits and withdrawals with multiple payment methods available.
                </p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">24/7 Support</h3>
                <p class="text-gray-600 leading-relaxed">
                    Round-the-clock customer support through multiple channels for all your needs.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Start Investing?</h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
            Join thousands of successful investors who trust BTC Investment with their financial future.
            Create your account today and start earning.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo url('/register'); ?>" class="bg-white text-blue-600 hover:bg-gray-100 font-bold py-3 px-8 rounded-lg transition duration-200">
                Create Account
            </a>
            <a href="<?php echo url('/login'); ?>" class="border-2 border-white text-white hover:bg-white hover:text-blue-600 font-bold py-3 px-8 rounded-lg transition duration-200">
                Login to Dashboard
            </a>
        </div>
    </div>
</section>

<script>
// Investment Calculator
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('calc-amount');
    const planSelect = document.getElementById('calc-plan');
    const daysInput = document.getElementById('calc-days');
    const calculateBtn = document.getElementById('calculate-btn');

    const dailyReturnEl = document.getElementById('daily-return');
    const totalReturnsEl = document.getElementById('total-returns');
    const finalAmountEl = document.getElementById('final-amount');
    const returnPercentageEl = document.getElementById('return-percentage');

    const planRates = {
        starter: 0.025,
        premium: 0.035,
        vip: 0.05
    };

    function calculateReturns() {
        const amount = parseFloat(amountInput.value) || 0;
        const plan = planSelect.value;
        const days = parseInt(daysInput.value) || 0;
        const rate = planRates[plan];

        if (amount > 0 && days > 0 && rate > 0) {
            const dailyReturn = amount * rate;
            const totalReturns = dailyReturn * days;
            const finalAmount = amount + totalReturns;
            const returnPercentage = (totalReturns / amount) * 100;

            dailyReturnEl.textContent = '$' + dailyReturn.toFixed(2);
            totalReturnsEl.textContent = '$' + totalReturns.toFixed(2);
            finalAmountEl.textContent = '$' + finalAmount.toFixed(2);
            returnPercentageEl.textContent = returnPercentage.toFixed(2) + '%';
        }
    }

    calculateBtn.addEventListener('click', calculateReturns);
    amountInput.addEventListener('input', calculateReturns);
    planSelect.addEventListener('change', calculateReturns);
    daysInput.addEventListener('input', calculateReturns);

    // Initial calculation
    calculateReturns();
});
</script>
@endsection