<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Investment extends Model
{
    protected $table = 'investments';
    protected $fillable = [
        'user_id',
        'plan_id',
        'amount',
        'profit',
        'status',
        'start_date',
        'end_date',
        'last_profit_at'
    ];

    /**
     * Get investment with plan details
     */
    public static function withPlan($id)
    {
        $stmt = self::$db->prepare("
            SELECT i.*, p.name as plan_name, p.interest_rate, p.compound_frequency,
                   p.duration_days, u.name as user_name, u.email as user_email
            FROM investments i
            JOIN plans p ON i.plan_id = p.id
            JOIN users u ON i.user_id = u.id
            WHERE i.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get active investments
     */
    public static function getActive()
    {
        $stmt = self::$db->query("
            SELECT i.*, p.name as plan_name, p.interest_rate, u.name as user_name
            FROM investments i
            JOIN plans p ON i.plan_id = p.id
            JOIN users u ON i.user_id = u.id
            WHERE i.status = 'active'
            ORDER BY i.created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Calculate profit for investment
     */
    public function calculateProfit()
    {
        $plan = Plan::find($this->plan_id);
        if (!$plan) return 0;

        $now = time();
        $start = strtotime($this->start_date);
        $lastProfit = $this->last_profit_at ? strtotime($this->last_profit_at) : $start;

        $hoursElapsed = ($now - $lastProfit) / 3600;

        $profit = 0;
        switch ($plan['compound_frequency']) {
            case 'hourly':
                $profit = $this->amount * ($plan['interest_rate'] / 100) * $hoursElapsed;
                break;
            case 'daily':
                $daysElapsed = $hoursElapsed / 24;
                $profit = $this->amount * ($plan['interest_rate'] / 100) * $daysElapsed;
                break;
            case 'weekly':
                $weeksElapsed = $hoursElapsed / (24 * 7);
                $profit = $this->amount * ($plan['interest_rate'] / 100) * $weeksElapsed;
                break;
            case 'monthly':
                $monthsElapsed = $hoursElapsed / (24 * 30);
                $profit = $this->amount * ($plan['interest_rate'] / 100) * $monthsElapsed;
                break;
        }

        return round($profit, 2);
    }

    /**
     * Add profit to investment
     */
    public function addProfit($amount)
    {
        // Update investment profit
        $stmt = self::$db->prepare("
            UPDATE investments
            SET profit = profit + ?, last_profit_at = NOW()
            WHERE id = ?
        ");
        $stmt->execute([$amount, $this->id]);

        // Update user balance
        $stmt = self::$db->prepare("
            UPDATE users
            SET balance = balance + ?
            WHERE id = ?
        ");
        $stmt->execute([$amount, $this->user_id]);

        // Record transaction
        Transaction::create([
            'user_id' => $this->user_id,
            'type' => 'profit',
            'amount' => $amount,
            'description' => "Investment profit from plan"
        ]);

        // Record compound interest
        $stmt = self::$db->prepare("
            INSERT INTO compound_interest (investment_id, amount)
            VALUES (?, ?)
        ");
        $stmt->execute([$this->id, $amount]);
    }

    /**
     * Check if investment should be completed
     */
    public function shouldComplete()
    {
        $plan = Plan::find($this->plan_id);
        if (!$plan || !$plan['duration_days']) return false;

        $start = strtotime($this->start_date);
        $now = time();
        $daysElapsed = ($now - $start) / (24 * 3600);

        return $daysElapsed >= $plan['duration_days'];
    }

    /**
     * Complete investment
     */
    public function complete()
    {
        $stmt = self::$db->prepare("
            UPDATE investments
            SET status = 'completed', end_date = NOW()
            WHERE id = ?
        ");
        return $stmt->execute([$this->id]);
    }

    /**
     * Get investments by user
     */
    public static function getByUser($userId)
    {
        $stmt = self::$db->prepare("
            SELECT i.*, p.name as plan_name, p.interest_rate
            FROM investments i
            JOIN plans p ON i.plan_id = p.id
            WHERE i.user_id = ?
            ORDER BY i.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}