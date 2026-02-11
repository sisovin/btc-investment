<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'description',
        'reference_id',
        'balance_before',
        'balance_after'
    ];

    /**
     * Transaction types
     */
    const TYPES = [
        'deposit',
        'withdrawal',
        'investment',
        'profit',
        'referral',
        'bonus',
        'transfer'
    ];

    /**
     * Get transactions by user
     */
    public static function getByUser($userId, $limit = 50, $offset = 0)
    {
        $stmt = self::$db->prepare("
            SELECT * FROM transactions
            WHERE user_id = ?
            ORDER BY created_at DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$userId, $limit, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get transactions by type
     */
    public static function getByType($type, $limit = 50)
    {
        $stmt = self::$db->prepare("
            SELECT t.*, u.name as user_name, u.email as user_email
            FROM transactions t
            JOIN users u ON t.user_id = u.id
            WHERE t.type = ?
            ORDER BY t.created_at DESC
            LIMIT ?
        ");
        $stmt->execute([$type, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get recent transactions
     */
    public static function getRecent($limit = 10)
    {
        $stmt = self::$db->prepare("
            SELECT t.*, u.name as user_name
            FROM transactions t
            JOIN users u ON t.user_id = u.id
            ORDER BY t.created_at DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get transaction statistics
     */
    public static function getStats()
    {
        $stmt = self::$db->query("
            SELECT
                COUNT(*) as total_transactions,
                SUM(CASE WHEN type = 'deposit' THEN amount END) as total_deposits,
                SUM(CASE WHEN type = 'withdrawal' THEN amount END) as total_withdrawals,
                SUM(CASE WHEN type = 'profit' THEN amount END) as total_profits,
                SUM(CASE WHEN type = 'investment' THEN amount END) as total_investments,
                COUNT(DISTINCT user_id) as active_users
            FROM transactions
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create transaction with balance update
     */
    public static function create(array $data)
    {
        // Get current balance
        $user = User::find($data['user_id']);
        $balanceBefore = $user['balance'];

        // Calculate new balance
        $balanceAfter = $balanceBefore + $data['amount'];

        // Create transaction record
        $data['balance_before'] = $balanceBefore;
        $data['balance_after'] = $balanceAfter;

        return parent::create($data);
    }

    /**
     * Get transaction by reference
     */
    public static function getByReference($referenceId)
    {
        $stmt = self::$db->prepare("SELECT * FROM transactions WHERE reference_id = ?");
        $stmt->execute([$referenceId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get user balance from transactions
     */
    public static function getUserBalance($userId)
    {
        $stmt = self::$db->prepare("
            SELECT balance_after
            FROM transactions
            WHERE user_id = ?
            ORDER BY created_at DESC
            LIMIT 1
        ");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['balance_after'] : 0;
    }

    /**
     * Get transaction summary for user
     */
    public static function getUserSummary($userId)
    {
        $stmt = self::$db->prepare("
            SELECT
                COUNT(*) as total_count,
                SUM(CASE WHEN type = 'deposit' THEN amount END) as total_deposits,
                SUM(CASE WHEN type = 'withdrawal' THEN amount END) as total_withdrawals,
                SUM(CASE WHEN type = 'profit' THEN amount END) as total_profits,
                SUM(CASE WHEN type = 'investment' THEN amount END) as total_investments,
                SUM(CASE WHEN type = 'referral' THEN amount END) as total_referrals
            FROM transactions
            WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get transactions by date range
     */
    public static function getByDateRange($startDate, $endDate, $userId = null)
    {
        $query = "
            SELECT t.*, u.name as user_name
            FROM transactions t
            JOIN users u ON t.user_id = u.id
            WHERE t.created_at BETWEEN ? AND ?
        ";
        $params = [$startDate, $endDate];

        if ($userId) {
            $query .= " AND t.user_id = ?";
            $params[] = $userId;
        }

        $query .= " ORDER BY t.created_at DESC";

        $stmt = self::$db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Validate transaction type
     */
    public static function isValidType($type)
    {
        return in_array($type, self::TYPES);
    }

    /**
     * Format amount for display
     */
    public function formatAmount()
    {
        $symbol = $this->amount >= 0 ? '+' : '';
        return $symbol . number_format($this->amount, 2) . ' USD';
    }

    /**
     * Get transaction type label
     */
    public function getTypeLabel()
    {
        $labels = [
            'deposit' => 'Deposit',
            'withdrawal' => 'Withdrawal',
            'investment' => 'Investment',
            'profit' => 'Profit',
            'referral' => 'Referral Bonus',
            'bonus' => 'Bonus',
            'transfer' => 'Transfer'
        ];

        return $labels[$this->type] ?? ucfirst($this->type);
    }
}