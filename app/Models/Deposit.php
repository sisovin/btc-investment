<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Deposit extends Model
{
    protected $table = 'deposits';
    protected $fillable = [
        'user_id',
        'transaction_id',
        'amount',
        'charge',
        'net_amount',
        'payment_method_id',
        'status',
        'proof_image'
    ];

    /**
     * Get deposit with user and payment method details
     */
    public static function withDetails($id)
    {
        $stmt = self::$db->prepare("
            SELECT d.*, u.name as user_name, u.email as user_email,
                   pm.name as payment_method_name
            FROM deposits d
            JOIN users u ON d.user_id = u.id
            JOIN payment_methods pm ON d.payment_method_id = pm.id
            WHERE d.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get deposits by user
     */
    public static function getByUser($userId)
    {
        $stmt = self::$db->prepare("
            SELECT d.*, pm.name as payment_method_name
            FROM deposits d
            JOIN payment_methods pm ON d.payment_method_id = pm.id
            WHERE d.user_id = ?
            ORDER BY d.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get pending deposits
     */
    public static function getPending()
    {
        $stmt = self::$db->query("
            SELECT d.*, u.name as user_name, u.email as user_email,
                   pm.name as payment_method_name
            FROM deposits d
            JOIN users u ON d.user_id = u.id
            JOIN payment_methods pm ON d.payment_method_id = pm.id
            WHERE d.status = 'pending'
            ORDER BY d.created_at ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Approve deposit
     */
    public function approve()
    {
        // Update deposit status
        $stmt = self::$db->prepare("UPDATE deposits SET status = 'approved' WHERE id = ?");
        $stmt->execute([$this->id]);

        // Update user balance
        $stmt = self::$db->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
        $stmt->execute([$this->net_amount, $this->user_id]);

        // Record transaction
        Transaction::create([
            'user_id' => $this->user_id,
            'type' => 'deposit',
            'amount' => $this->net_amount,
            'description' => "Deposit via " . $this->getPaymentMethodName()
        ]);

        // Check for referral bonus
        $this->processReferralBonus();
    }

    /**
     * Reject deposit
     */
    public function reject()
    {
        $stmt = self::$db->prepare("UPDATE deposits SET status = 'rejected' WHERE id = ?");
        return $stmt->execute([$this->id]);
    }

    /**
     * Process referral bonus
     */
    private function processReferralBonus()
    {
        $user = User::find($this->user_id);
        if (!$user || !$user['referrer_id']) return;

        // Get referral settings
        $referralBonus = Setting::get('referral_bonus', 10); // Default 10%
        $bonusAmount = $this->net_amount * ($referralBonus / 100);

        // Update referrer balance
        $stmt = self::$db->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
        $stmt->execute([$bonusAmount, $user['referrer_id']]);

        // Record referral
        $stmt = self::$db->prepare("
            INSERT INTO referrals (referrer_id, referred_id, bonus)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$user['referrer_id'], $this->user_id, $bonusAmount]);

        // Record transaction for referrer
        Transaction::create([
            'user_id' => $user['referrer_id'],
            'type' => 'referral',
            'amount' => $bonusAmount,
            'description' => "Referral bonus from " . $user['name']
        ]);
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
            $id = 'DEP' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 10));
            $exists = self::findByTransactionId($id);
        } while ($exists);

        return $id;
    }

    /**
     * Find by transaction ID
     */
    public static function findByTransactionId($transactionId)
    {
        $stmt = self::$db->prepare("SELECT * FROM deposits WHERE transaction_id = ?");
        $stmt->execute([$transactionId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}