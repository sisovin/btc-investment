<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\InvestmentPlan;
use App\Models\Transaction;
use App\Models\Investment;

class ApiController extends Controller
{
    /**
     * Get investment plans
     */
    public function plans()
    {
        $plans = InvestmentPlan::where('is_active', 1)->get();

        return $this->json([
            'success' => true,
            'data' => $plans
        ]);
    }

    /**
     * Get current rates
     */
    public function rates()
    {
        // This would typically fetch from an external API
        // For now, return mock data
        $rates = [
            'BTC' => 45000,
            'ETH' => 3000,
            'USDT' => 1
        ];

        return $this->json([
            'success' => true,
            'data' => $rates
        ]);
    }

    /**
     * Get user balance
     */
    public function userBalance()
    {
        $user = auth()->user();

        return $this->json([
            'success' => true,
            'data' => [
                'balance' => $user->balance,
                'currency' => 'USD'
            ]
        ]);
    }

    /**
     * Get user transactions
     */
    public function userTransactions()
    {
        $user = auth()->user();

        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return $this->json([
            'success' => true,
            'data' => $transactions
        ]);
    }

    /**
     * Make investment via API
     */
    public function invest()
    {
        $user = auth()->user();

        $data = $this->request->validate([
            'plan_id' => 'required|integer|exists:investment_plans,id',
            'amount' => 'required|numeric|min:10'
        ]);

        if ($data === false) {
            return $this->json([
                'success' => false,
                'errors' => $this->request->errors()
            ], 400);
        }

        // Check user balance
        if ($user->balance < $data['amount']) {
            return $this->json([
                'success' => false,
                'error' => 'Insufficient balance'
            ], 400);
        }

        // Create investment
        $investment = Investment::create([
            'user_id' => $user->id,
            'plan_id' => $data['plan_id'],
            'amount' => $data['amount'],
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addDays(30)
        ]);

        // Deduct from balance
        $user->decrement('balance', $data['amount']);

        // Create transaction record
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'investment',
            'amount' => $data['amount'],
            'description' => 'Investment made via API',
            'status' => 'completed'
        ]);

        return $this->json([
            'success' => true,
            'data' => $investment,
            'message' => 'Investment created successfully'
        ]);
    }

    /**
     * Withdraw funds via API
     */
    public function withdraw()
    {
        $user = auth()->user();

        $data = $this->request->validate([
            'amount' => 'required|numeric|min:10',
            'wallet_address' => 'required|string|max:100'
        ]);

        if ($data === false) {
            return $this->json([
                'success' => false,
                'errors' => $this->request->errors()
            ], 400);
        }

        // Check user balance
        if ($user->balance < $data['amount']) {
            return $this->json([
                'success' => false,
                'error' => 'Insufficient balance'
            ], 400);
        }

        // Create withdrawal transaction
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'type' => 'withdrawal',
            'amount' => $data['amount'],
            'description' => 'Withdrawal request via API',
            'status' => 'pending',
            'metadata' => json_encode(['wallet_address' => $data['wallet_address']])
        ]);

        return $this->json([
            'success' => true,
            'data' => $transaction,
            'message' => 'Withdrawal request submitted'
        ]);
    }
}