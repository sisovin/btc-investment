<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'balance',
        'referral_code',
        'referrer_id',
        'email_verified_at',
        'phone_verified_at',
        'status'
    ];

    protected $hidden = ['password'];

    /**
     * Find user by email
     */
    public static function findByEmail($email)
    {
        $stmt = self::$db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Find user by referral code
     */
    public static function findByReferralCode($code)
    {
        $stmt = self::$db->prepare("SELECT * FROM users WHERE referral_code = ?");
        $stmt->execute([$code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get user's investments
     */
    public function investments()
    {
        $stmt = self::$db->prepare("
            SELECT i.*, p.name as plan_name, p.interest_rate
            FROM investments i
            JOIN plans p ON i.plan_id = p.id
            WHERE i.user_id = ?
            ORDER BY i.created_at DESC
        ");
        $stmt->execute([$this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get user's deposits
     */
    public function deposits()
    {
        $stmt = self::$db->prepare("
            SELECT d.*, pm.name as payment_method_name
            FROM deposits d
            JOIN payment_methods pm ON d.payment_method_id = pm.id
            WHERE d.user_id = ?
            ORDER BY d.created_at DESC
        ");
        $stmt->execute([$this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get user's withdrawals
     */
    public function withdrawals()
    {
        $stmt = self::$db->prepare("
            SELECT w.*, pm.name as payment_method_name
            FROM withdrawals w
            JOIN payment_methods pm ON w.payment_method_id = pm.id
            WHERE w.user_id = ?
            ORDER BY w.created_at DESC
        ");
        $stmt->execute([$this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get user's referrals
     */
    public function referrals()
    {
        $stmt = self::$db->prepare("
            SELECT u.name, u.email, r.bonus, r.created_at
            FROM referrals r
            JOIN users u ON r.referred_id = u.id
            WHERE r.referrer_id = ?
            ORDER BY r.created_at DESC
        ");
        $stmt->execute([$this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Update user balance
     */
    public function updateBalance($amount)
    {
        $stmt = self::$db->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
        return $stmt->execute([$amount, $this->id]);
    }

    /**
     * Check if user can withdraw amount
     */
    public function canWithdraw($amount)
    {
        return $this->balance >= $amount;
    }

    /**
     * Generate unique referral code
     */
    public static function generateReferralCode()
    {
        do {
            $code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
            $exists = self::findByReferralCode($code);
        } while ($exists);

        return $code;
    }
}