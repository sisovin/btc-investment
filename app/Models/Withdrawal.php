<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Withdrawal extends Model
{
    protected $table = 'withdrawals';
    protected $fillable = [
        'user_id',
        'transaction_id',
        'amount',
        'charge',
        'net_amount',
        'payment_method_id',
        'status',
        'account_details'
    ];

    /**
     * Get withdrawal with user and payment method details
     */
    public static function withDetails($id)
    {
        $stmt = self::$db->prepare("
            SELECT w.*, u.name as user_name, u.email as user_email,
                   pm.name as payment_method_name
            FROM withdrawals w
            JOIN users u ON w.user_id = u.id
            JOIN payment_methods pm ON w.payment_method_id = pm.id
            WHERE w.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get withdrawals by user
     */
    public static function getByUser($userId)
    {
        $stmt = self::$db->prepare("
            SELECT w.*, pm.name as payment_method_name
            FROM withdrawals w
            JOIN payment_methods pm ON w.payment_method_id = pm.id
            WHERE w.user_id = ?
            ORDER BY w.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get pending withdrawals
     */
    public static function getPending()
    {
        $stmt = self::$db->query("
            SELECT w.*, u.name as user_name, u.email as user_email,
                   pm.name as payment_method_name
            FROM withdrawals w
            JOIN users u ON w.user_id = u.id
            JOIN payment_methods pm ON w.payment_method_id = pm.id
            WHERE w.status = 'pending'
            ORDER BY w.created_at ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Process withdrawal request
     */
    public static function request($userId, $amount, $paymentMethodId, $accountDetails)
    {
        $user = User::find($userId);
        if (!$user) return false;

        // Check minimum withdrawal
        $minWithdrawal = Setting::get('min_withdrawal', 10);
        if ($amount < $minWithdrawal) return false;

        // Check user balance
        if ($user['balance'] < $amount) return false;

        // Calculate charge
        $withdrawalCharge = Setting::get('withdrawal_charge', 5); // 5%
        $charge = $amount * ($withdrawalCharge / 100);
        $netAmount = $amount - $charge;

        // Create withdrawal
        $withdrawal = self::create([
            'user_id' => $userId,
            'transaction_id' => self::generateTransactionId(),
            'amount' => $amount,
            'charge' => $charge,
            'net_amount' => $netAmount,
            'payment_method_id' => $paymentMethodId,
            'status' => 'pending',
            'account_details' => json_encode($accountDetails)
        ]);

        // Deduct from user balance
        $stmt = self::$db->prepare("UPDATE users SET balance = balance - ? WHERE id = ?");
        $stmt->execute([$amount, $userId]);

        return $withdrawal;
    }

    /**
     * Approve withdrawal
     */
    public function approve()
    {
        $stmt = self::$db->prepare("UPDATE withdrawals SET status = 'approved' WHERE id = ?");
        $stmt->execute([$this->id]);

        // Record transaction
        Transaction::create([
            'user_id' => $this->user_id,
            'type' => 'withdrawal',
            'amount' => -$this->amount,
            'description' => "Withdrawal via " . $this->getPaymentMethodName()
        ]);
    }

    /**
     * Reject withdrawal
     */
    public function reject()
    {
        // Refund user balance
        $stmt = self::$db->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
        $stmt->execute([$this->amount, $this->user_id]);

        // Update withdrawal status
        $stmt = self::$db->prepare("UPDATE withdrawals SET status = 'rejected' WHERE id = ?");
        $stmt->execute([$this->id]);
    }

    /**
     * Get payment method name
     */
    private function getPaymentMethodName()
    {
        $stmt = self::$db->prepare("SELECT name FROM payment_methods WHERE id = ?");
        $stmt->execute([$this->payment_method_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['name'] ?? 'Unknown';
    }

    /**
     * Generate unique transaction ID
     */
    public static function generateTransactionId()
    {
        do {
            $id = 'WD' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 10));
            $exists = self::findByTransactionId($id);
        } while ($exists);

        return $id;
    }

    /**
     * Find by transaction ID
     */
    public static function findByTransactionId($transactionId)
    {
        $stmt = self::$db->prepare("SELECT * FROM withdrawals WHERE transaction_id = ?");
        $stmt->execute([$transactionId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get account details as array
     */
    public function getAccountDetails()
    {
        return json_decode($this->account_details, true);
    }
}