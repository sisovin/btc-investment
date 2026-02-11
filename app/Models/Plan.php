<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Plan extends Model
{
    protected $table = 'plans';
    protected $fillable = [
        'name',
        'min_amount',
        'max_amount',
        'interest_rate',
        'interest_type',
        'duration',
        'duration_unit',
        'compound_frequency',
        'status'
    ];

    /**
     * Get active plans
     */
    public static function getActive()
    {
        $stmt = self::$db->query("SELECT * FROM plans WHERE status = 'active' ORDER BY min_amount ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get plan by amount range
     */
    public static function getByAmount($amount)
    {
        $stmt = self::$db->prepare("
            SELECT * FROM plans
            WHERE status = 'active'
            AND ? BETWEEN min_amount AND max_amount
            ORDER BY min_amount ASC
        ");
        $stmt->execute([$amount]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Calculate profit for amount and plan
     */
    public function calculateProfit($amount, $duration = null)
    {
        $duration = $duration ?? $this->duration;

        if ($this->interest_type === 'fixed') {
            return $amount * ($this->interest_rate / 100);
        } elseif ($this->interest_type === 'percentage') {
            return $amount * ($this->interest_rate / 100);
        } elseif ($this->interest_type === 'compound') {
            return $this->calculateCompoundInterest($amount, $duration);
        }

        return 0;
    }

    /**
     * Calculate compound interest
     */
    private function calculateCompoundInterest($principal, $duration)
    {
        $rate = $this->interest_rate / 100;
        $compoundsPerPeriod = $this->getCompoundsPerPeriod();

        // Convert duration to periods
        $periods = $this->convertDurationToPeriods($duration);

        $amount = $principal * pow(1 + ($rate / $compoundsPerPeriod), $compoundsPerPeriod * $periods);
        return $amount - $principal;
    }

    /**
     * Get compounds per period based on frequency
     */
    private function getCompoundsPerPeriod()
    {
        switch ($this->compound_frequency) {
            case 'daily':
                return 365;
            case 'weekly':
                return 52;
            case 'monthly':
                return 12;
            case 'quarterly':
                return 4;
            case 'annually':
                return 1;
            default:
                return 12; // monthly default
        }
    }

    /**
     * Convert duration to periods
     */
    private function convertDurationToPeriods($duration)
    {
        switch ($this->duration_unit) {
            case 'days':
                return $duration / 365; // Convert to years
            case 'weeks':
                return $duration / 52;
            case 'months':
                return $duration / 12;
            case 'years':
                return $duration;
            default:
                return $duration / 12; // months default
        }
    }

    /**
     * Get total return percentage
     */
    public function getTotalReturnPercentage()
    {
        if ($this->interest_type === 'compound') {
            $periods = $this->convertDurationToPeriods($this->duration);
            $compoundsPerPeriod = $this->getCompoundsPerPeriod();
            $rate = $this->interest_rate / 100;

            return (pow(1 + ($rate / $compoundsPerPeriod), $compoundsPerPeriod * $periods) - 1) * 100;
        }

        return $this->interest_rate;
    }

    /**
     * Get duration in days
     */
    public function getDurationInDays()
    {
        switch ($this->duration_unit) {
            case 'days':
                return $this->duration;
            case 'weeks':
                return $this->duration * 7;
            case 'months':
                return $this->duration * 30; // Approximate
            case 'years':
                return $this->duration * 365;
            default:
                return $this->duration * 30;
        }
    }

    /**
     * Check if plan is suitable for amount
     */
    public function isSuitableForAmount($amount)
    {
        return $amount >= $this->min_amount && $amount <= $this->max_amount;
    }

    /**
     * Get plan statistics
     */
    public static function getStats()
    {
        $stmt = self::$db->query("
            SELECT
                COUNT(*) as total_plans,
                COUNT(CASE WHEN status = 'active' THEN 1 END) as active_plans,
                AVG(interest_rate) as avg_interest_rate,
                MIN(min_amount) as min_investment,
                MAX(max_amount) as max_investment
            FROM plans
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get investments count for this plan
     */
    public function getInvestmentsCount()
    {
        $stmt = self::$db->prepare("SELECT COUNT(*) as count FROM investments WHERE plan_id = ?");
        $stmt->execute([$this->id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    /**
     * Get total invested amount for this plan
     */
    public function getTotalInvested()
    {
        $stmt = self::$db->prepare("SELECT SUM(amount) as total FROM investments WHERE plan_id = ?");
        $stmt->execute([$this->id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    }
}