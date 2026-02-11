<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Referral extends Model
{
    protected $table = 'referrals';
    protected $fillable = [
        'referrer_id',
        'referred_id',
        'bonus',
        'level'
    ];

    /**
     * Get referrals by referrer
     */
    public static function getByReferrer($referrerId)
    {
        $stmt = self::$db->prepare("
            SELECT r.*, u.name as referred_name, u.email as referred_email,
                   u.created_at as referred_date, u.balance as referred_balance
            FROM referrals r
            JOIN users u ON r.referred_id = u.id
            WHERE r.referrer_id = ?
            ORDER BY r.created_at DESC
        ");
        $stmt->execute([$referrerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get referral statistics for user
     */
    public static function getStats($userId)
    {
        $stmt = self::$db->prepare("
            SELECT
                COUNT(*) as total_referrals,
                COUNT(CASE WHEN u.status = 'active' THEN 1 END) as active_referrals,
                SUM(r.bonus) as total_bonus_earned,
                AVG(r.bonus) as avg_bonus_per_referral
            FROM referrals r
            JOIN users u ON r.referred_id = u.id
            WHERE r.referrer_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get referral tree (multi-level)
     */
    public static function getReferralTree($userId, $maxLevel = 3)
    {
        $tree = [];
        $currentLevel = [$userId];
        $level = 1;

        while ($level <= $maxLevel && !empty($currentLevel)) {
            $placeholders = str_repeat('?,', count($currentLevel) - 1) . '?';
            $stmt = self::$db->prepare("
                SELECT DISTINCT r.referred_id, u.name, u.email, u.created_at,
                       r.bonus, r.level
                FROM referrals r
                JOIN users u ON r.referred_id = u.id
                WHERE r.referrer_id IN ($placeholders)
                ORDER BY r.created_at DESC
            ");
            $stmt->execute($currentLevel);
            $referrals = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($referrals)) {
                $tree[$level] = $referrals;
                $currentLevel = array_column($referrals, 'referred_id');
            } else {
                break;
            }

            $level++;
        }

        return $tree;
    }

    /**
     * Calculate referral bonus for new user
     */
    public static function calculateBonus($referrerId, $depositAmount)
    {
        $referralBonus = Setting::get('referral_bonus', 10); // Default 10%
        return $depositAmount * ($referralBonus / 100);
    }

    /**
     * Process referral when user makes deposit
     */
    public static function processReferral($userId, $depositAmount)
    {
        $user = User::find($userId);
        if (!$user || !$user['referrer_id']) return false;

        $bonus = self::calculateBonus($user['referrer_id'], $depositAmount);

        // Create referral record
        $referral = self::create([
            'referrer_id' => $user['referrer_id'],
            'referred_id' => $userId,
            'bonus' => $bonus,
            'level' => 1
        ]);

        // Update referrer balance
        $stmt = self::$db->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
        $stmt->execute([$bonus, $user['referrer_id']]);

        // Record transaction
        Transaction::create([
            'user_id' => $user['referrer_id'],
            'type' => 'referral',
            'amount' => $bonus,
            'description' => "Referral bonus from " . $user['name']
        ]);

        return $referral;
    }

    /**
     * Get total referral earnings for user
     */
    public static function getTotalEarnings($userId)
    {
        $stmt = self::$db->prepare("SELECT SUM(bonus) as total FROM referrals WHERE referrer_id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    /**
     * Get referral commission rates by level
     */
    public static function getCommissionRates()
    {
        return [
            1 => Setting::get('referral_level_1', 10), // 10%
            2 => Setting::get('referral_level_2', 5),  // 5%
            3 => Setting::get('referral_level_3', 2)   // 2%
        ];
    }

    /**
     * Process multi-level referral bonus
     */
    public static function processMultiLevelReferral($userId, $depositAmount)
    {
        $user = User::find($userId);
        $currentReferrerId = $user['referrer_id'];
        $level = 1;
        $maxLevels = 3;

        $commissionRates = self::getCommissionRates();

        while ($currentReferrerId && $level <= $maxLevels) {
            if (!isset($commissionRates[$level])) break;

            $bonus = $depositAmount * ($commissionRates[$level] / 100);

            // Create referral record
            self::create([
                'referrer_id' => $currentReferrerId,
                'referred_id' => $userId,
                'bonus' => $bonus,
                'level' => $level
            ]);

            // Update referrer balance
            $stmt = self::$db->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
            $stmt->execute([$bonus, $currentReferrerId]);

            // Record transaction
            $referrer = User::find($currentReferrerId);
            Transaction::create([
                'user_id' => $currentReferrerId,
                'type' => 'referral',
                'amount' => $bonus,
                'description' => "Level {$level} referral bonus from " . $user['name']
            ]);

            // Move to next level
            $currentReferrerId = $referrer['referrer_id'];
            $level++;
        }
    }

    /**
     * Get referral leaderboard
     */
    public static function getLeaderboard($limit = 10)
    {
        $stmt = self::$db->prepare("
            SELECT u.name, u.email, COUNT(r.id) as referral_count,
                   SUM(r.bonus) as total_bonus
            FROM users u
            LEFT JOIN referrals r ON u.id = r.referrer_id
            GROUP BY u.id
            ORDER BY referral_count DESC, total_bonus DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Check if referral relationship exists
     */
    public static function exists($referrerId, $referredId)
    {
        $stmt = self::$db->prepare("
            SELECT id FROM referrals
            WHERE referrer_id = ? AND referred_id = ?
        ");
        $stmt->execute([$referrerId, $referredId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    /**
     * Get referral code for user
     */
    public static function getReferralCode($userId)
    {
        $user = User::find($userId);
        return $user['referral_code'] ?? null;
    }

    /**
     * Find referrer by code
     */
    public static function findReferrerByCode($referralCode)
    {
        $stmt = self::$db->prepare("SELECT id FROM users WHERE referral_code = ?");
        $stmt->execute([$referralCode]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
    }
}