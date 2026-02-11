<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class PaymentMethod extends Model
{
    protected $table = 'payment_methods';
    protected $fillable = [
        'name',
        'type',
        'currency',
        'min_amount',
        'max_amount',
        'fixed_charge',
        'percentage_charge',
        'status',
        'config'
    ];

    /**
     * Payment method types
     */
    const TYPES = [
        'bank_transfer',
        'crypto',
        'paypal',
        'stripe',
        'manual'
    ];

    /**
     * Get active payment methods
     */
    public static function getActive()
    {
        $stmt = self::$db->query("SELECT * FROM payment_methods WHERE status = 'active' ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get payment methods by type
     */
    public static function getByType($type)
    {
        $stmt = self::$db->prepare("SELECT * FROM payment_methods WHERE type = ? AND status = 'active'");
        $stmt->execute([$type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get deposit methods
     */
    public static function getDepositMethods()
    {
        $stmt = self::$db->query("
            SELECT * FROM payment_methods
            WHERE status = 'active' AND type IN ('bank_transfer', 'crypto', 'paypal', 'stripe')
            ORDER BY name ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get withdrawal methods
     */
    public static function getWithdrawalMethods()
    {
        $stmt = self::$db->query("
            SELECT * FROM payment_methods
            WHERE status = 'active' AND type IN ('bank_transfer', 'crypto', 'paypal')
            ORDER BY name ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Calculate charge for amount
     */
    public function calculateCharge($amount)
    {
        $fixedCharge = $this->fixed_charge ?? 0;
        $percentageCharge = ($amount * ($this->percentage_charge ?? 0) / 100);

        return $fixedCharge + $percentageCharge;
    }

    /**
     * Calculate net amount after charge
     */
    public function calculateNetAmount($amount)
    {
        $charge = $this->calculateCharge($amount);
        return $amount - $charge;
    }

    /**
     * Check if amount is within limits
     */
    public function isAmountValid($amount)
    {
        return $amount >= $this->min_amount && $amount <= $this->max_amount;
    }

    /**
     * Get config as array
     */
    public function getConfig()
    {
        return json_decode($this->config ?? '{}', true);
    }

    /**
     * Update config
     */
    public function updateConfig(array $config)
    {
        $this->config = json_encode($config);
        return $this->save();
    }

    /**
     * Get payment method statistics
     */
    public static function getStats()
    {
        $stmt = self::$db->query("
            SELECT
                COUNT(*) as total_methods,
                COUNT(CASE WHEN status = 'active' THEN 1 END) as active_methods,
                COUNT(CASE WHEN type = 'crypto' THEN 1 END) as crypto_methods,
                COUNT(CASE WHEN type = 'bank_transfer' THEN 1 END) as bank_methods
            FROM payment_methods
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get usage statistics for this method
     */
    public function getUsageStats()
    {
        // Deposits count
        $stmt = self::$db->prepare("SELECT COUNT(*) as deposits FROM deposits WHERE payment_method_id = ?");
        $stmt->execute([$this->id]);
        $deposits = $stmt->fetch(PDO::FETCH_ASSOC)['deposits'];

        // Withdrawals count
        $stmt = self::$db->prepare("SELECT COUNT(*) as withdrawals FROM withdrawals WHERE payment_method_id = ?");
        $stmt->execute([$this->id]);
        $withdrawals = $stmt->fetch(PDO::FETCH_ASSOC)['withdrawals'];

        // Total volume
        $stmt = self::$db->prepare("
            SELECT
                SUM(amount) as total_deposits,
                SUM(net_amount) as net_deposits
            FROM deposits
            WHERE payment_method_id = ? AND status = 'approved'
        ");
        $stmt->execute([$this->id]);
        $depositVolume = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'deposits_count' => $deposits,
            'withdrawals_count' => $withdrawals,
            'total_deposit_volume' => $depositVolume['total_deposits'] ?? 0,
            'net_deposit_volume' => $depositVolume['net_deposits'] ?? 0
        ];
    }

    /**
     * Validate payment method type
     */
    public static function isValidType($type)
    {
        return in_array($type, self::TYPES);
    }

    /**
     * Get supported currencies
     */
    public static function getSupportedCurrencies()
    {
        return ['USD', 'EUR', 'BTC', 'ETH', 'USDT', 'BNB'];
    }

    /**
     * Create default payment methods
     */
    public static function createDefaults()
    {
        $defaults = [
            [
                'name' => 'Bank Transfer',
                'type' => 'bank_transfer',
                'currency' => 'USD',
                'min_amount' => 10,
                'max_amount' => 10000,
                'fixed_charge' => 0,
                'percentage_charge' => 0,
                'status' => 'active',
                'config' => json_encode([
                    'bank_name' => 'Your Bank',
                    'account_name' => 'Your Company',
                    'account_number' => '1234567890',
                    'routing_number' => '123456789'
                ])
            ],
            [
                'name' => 'Bitcoin',
                'type' => 'crypto',
                'currency' => 'BTC',
                'min_amount' => 0.001,
                'max_amount' => 10,
                'fixed_charge' => 0,
                'percentage_charge' => 1,
                'status' => 'active',
                'config' => json_encode([
                    'wallet_address' => '1YourBitcoinWalletAddressHere',
                    'network' => 'bitcoin'
                ])
            ],
            [
                'name' => 'USDT (TRC20)',
                'type' => 'crypto',
                'currency' => 'USDT',
                'min_amount' => 10,
                'max_amount' => 50000,
                'fixed_charge' => 0,
                'percentage_charge' => 0.5,
                'status' => 'active',
                'config' => json_encode([
                    'wallet_address' => 'TYourUSDTWalletAddressHere',
                    'network' => 'tron'
                ])
            ]
        ];

        foreach ($defaults as $method) {
            self::create($method);
        }
    }
}