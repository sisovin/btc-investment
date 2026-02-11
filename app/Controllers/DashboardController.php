<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Transaction;
use App\Models\Investment;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Dashboard index
     */
    public function index()
    {
        $user = auth()->user();

        // Get user statistics
        $stats = [
            'total_balance' => $user->balance,
            'total_invested' => Investment::where('user_id', $user->id)->sum('amount'),
            'total_earnings' => Transaction::where('user_id', $user->id)
                ->where('type', 'profit')
                ->sum('amount'),
            'active_investments' => Investment::where('user_id', $user->id)
                ->where('status', 'active')
                ->count()
        ];

        // Get recent transactions
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get active investments
        $activeInvestments = Investment::where('user_id', $user->id)
            ->where('status', 'active')
            ->with('plan')
            ->get();

        return $this->view('dashboard/index', [
            'title' => 'Dashboard',
            'user' => $user,
            'stats' => $stats,
            'recentTransactions' => $recentTransactions,
            'activeInvestments' => $activeInvestments
        ]);
    }

    /**
     * User profile
     */
    public function profile()
    {
        $user = auth()->user();

        return $this->view('dashboard/profile', [
            'title' => 'My Profile',
            'user' => $user
        ]);
    }

    /**
     * Update user profile
     */
    public function updateProfile()
    {
        $user = auth()->user();

        $data = $this->request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255'
        ]);

        if ($data === false) {
            return $this->redirect('/profile')->with('errors', $this->request->errors());
        }

        $user->update($data);

        return $this->redirect('/profile')->with('success', 'Profile updated successfully');
    }

    /**
     * User transactions
     */
    public function transactions()
    {
        $user = auth()->user();

        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return $this->view('dashboard/transactions', [
            'title' => 'My Transactions',
            'transactions' => $transactions
        ]);
    }

    /**
     * User investments
     */
    public function investments()
    {
        $user = auth()->user();

        $investments = Investment::where('user_id', $user->id)
            ->with('plan')
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->view('dashboard/investments', [
            'title' => 'My Investments',
            'investments' => $investments
        ]);
    }

    /**
     * Make investment
     */
    public function invest()
    {
        $user = auth()->user();

        $data = $this->request->validate([
            'plan_id' => 'required|integer|exists:investment_plans,id',
            'amount' => 'required|numeric|min:10'
        ]);

        if ($data === false) {
            return $this->redirect('/dashboard')->with('errors', $this->request->errors());
        }

        // Check user balance
        if ($user->balance < $data['amount']) {
            return $this->redirect('/dashboard')->with('error', 'Insufficient balance');
        }

        // Create investment
        Investment::create([
            'user_id' => $user->id,
            'plan_id' => $data['plan_id'],
            'amount' => $data['amount'],
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addDays(30) // Default 30 days
        ]);

        // Deduct from balance
        $user->decrement('balance', $data['amount']);

        // Create transaction record
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'investment',
            'amount' => $data['amount'],
            'description' => 'Investment made',
            'status' => 'completed'
        ]);

        return $this->redirect('/dashboard')->with('success', 'Investment made successfully');
    }

    /**
     * Withdraw funds
     */
    public function withdraw()
    {
        $user = auth()->user();

        $data = $this->request->validate([
            'amount' => 'required|numeric|min:10',
            'wallet_address' => 'required|string|max:100'
        ]);

        if ($data === false) {
            return $this->redirect('/dashboard')->with('errors', $this->request->errors());
        }

        // Check user balance
        if ($user->balance < $data['amount']) {
            return $this->redirect('/dashboard')->with('error', 'Insufficient balance');
        }

        // Create withdrawal transaction
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'withdrawal',
            'amount' => $data['amount'],
            'description' => 'Withdrawal request',
            'status' => 'pending',
            'metadata' => json_encode(['wallet_address' => $data['wallet_address']])
        ]);

        return $this->redirect('/dashboard')->with('success', 'Withdrawal request submitted');
    }
}