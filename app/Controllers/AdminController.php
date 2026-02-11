<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Investment;
use App\Models\InvestmentPlan;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Admin dashboard
     */
    public function index()
    {
        // Get statistics
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'total_investments' => Investment::sum('amount'),
            'total_transactions' => Transaction::count(),
            'pending_withdrawals' => Transaction::where('type', 'withdrawal')
                ->where('status', 'pending')->count()
        ];

        // Get recent users
        $recentUsers = User::orderBy('created_at', 'desc')->limit(5)->get();

        // Get recent transactions
        $recentTransactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return $this->view('admin/index', [
            'title' => 'Admin Dashboard',
            'stats' => $stats,
            'recentUsers' => $recentUsers,
            'recentTransactions' => $recentTransactions
        ]);
    }

    /**
     * Manage users
     */
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);

        return $this->view('admin/users', [
            'title' => 'Manage Users',
            'users' => $users
        ]);
    }

    /**
     * Manage transactions
     */
    public function transactions()
    {
        $transactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return $this->view('admin/transactions', [
            'title' => 'Manage Transactions',
            'transactions' => $transactions
        ]);
    }

    /**
     * Manage investments
     */
    public function investments()
    {
        $investments = Investment::with(['user', 'plan'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return $this->view('admin/investments', [
            'title' => 'Manage Investments',
            'investments' => $investments
        ]);
    }

    /**
     * System settings
     */
    public function settings()
    {
        $plans = InvestmentPlan::all();

        return $this->view('admin/settings', [
            'title' => 'System Settings',
            'plans' => $plans
        ]);
    }

    /**
     * Update system settings
     */
    public function updateSettings()
    {
        $data = $this->request->all();

        // Handle different setting types
        if (isset($data['plans'])) {
            foreach ($data['plans'] as $planId => $planData) {
                InvestmentPlan::where('id', $planId)->update($planData);
            }
        }

        return $this->redirect('/admin/settings')->with('success', 'Settings updated successfully');
    }

    /**
     * Update user status
     */
    public function updateUserStatus($userId)
    {
        $data = $this->request->validate([
            'status' => 'required|in:active,inactive,suspended'
        ]);

        if ($data === false) {
            return $this->json(['error' => 'Invalid status'], 400);
        }

        $user = User::find($userId);
        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }

        $user->update(['status' => $data['status']]);

        return $this->json(['success' => true, 'message' => 'User status updated']);
    }
}