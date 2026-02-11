<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
        'category'
    ];

    /**
     * Setting types
     */
    const TYPES = [
        'string',
        'integer',
        'float',
        'boolean',
        'json',
        'array'
    ];

    /**
     * Setting categories
     */
    const CATEGORIES = [
        'general',
        'investment',
        'payment',
        'referral',
        'security',
        'email',
        'notification'
    ];

    /**
     * Get setting value by key
     */
    public static function get($key, $default = null)
    {
        $stmt = self::$db->prepare("SELECT value, type FROM settings WHERE `key` = ?");
        $stmt->execute([$key]);
        $setting = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$setting) return $default;

        return self::castValue($setting['value'], $setting['type']);
    }

    /**
     * Set setting value
     */
    public static function set($key, $value, $type = 'string', $description = '', $category = 'general')
    {
        $castedValue = self::castValueForStorage($value, $type);

        $stmt = self::$db->prepare("
            INSERT INTO settings (`key`, value, type, description, category, updated_at)
            VALUES (?, ?, ?, ?, ?, NOW())
            ON DUPLICATE KEY UPDATE
            value = VALUES(value),
            type = VALUES(type),
            description = VALUES(description),
            category = VALUES(category),
            updated_at = NOW()
        ");
        return $stmt->execute([$key, $castedValue, $type, $description, $category]);
    }

    /**
     * Get all settings
     */
    public static function getAll()
    {
        $stmt = self::$db->query("SELECT * FROM settings ORDER BY category ASC, `key` ASC");
        $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cast values
        foreach ($settings as &$setting) {
            $setting['value'] = self::castValue($setting['value'], $setting['type']);
        }

        return $settings;
    }

    /**
     * Get settings by category
     */
    public static function getByCategory($category)
    {
        $stmt = self::$db->prepare("SELECT * FROM settings WHERE category = ? ORDER BY `key` ASC");
        $stmt->execute([$category]);
        $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cast values
        foreach ($settings as &$setting) {
            $setting['value'] = self::castValue($setting['value'], $setting['type']);
        }

        return $settings;
    }

    /**
     * Delete setting
     */
    public static function delete($key)
    {
        $stmt = self::$db->prepare("DELETE FROM settings WHERE `key` = ?");
        return $stmt->execute([$key]);
    }

    /**
     * Cast value based on type
     */
    private static function castValue($value, $type)
    {
        switch ($type) {
            case 'integer':
                return (int) $value;
            case 'float':
                return (float) $value;
            case 'boolean':
                return (bool) $value;
            case 'json':
                return json_decode($value, true);
            case 'array':
                return json_decode($value, true) ?? [];
            case 'string':
            default:
                return (string) $value;
        }
    }

    /**
     * Cast value for storage
     */
    private static function castValueForStorage($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return $value ? '1' : '0';
            case 'json':
            case 'array':
                return json_encode($value);
            default:
                return (string) $value;
        }
    }

    /**
     * Initialize default settings
     */
    public static function initializeDefaults()
    {
        $defaults = [
            // General settings
            ['key' => 'site_name', 'value' => 'BTC Investment', 'type' => 'string', 'description' => 'Website name', 'category' => 'general'],
            ['key' => 'site_description', 'value' => 'High Yield Investment Platform', 'type' => 'string', 'description' => 'Website description', 'category' => 'general'],
            ['key' => 'site_url', 'value' => 'https://btc-investment.com', 'type' => 'string', 'description' => 'Website URL', 'category' => 'general'],
            ['key' => 'admin_email', 'value' => 'admin@btc-investment.com', 'type' => 'string', 'description' => 'Administrator email', 'category' => 'general'],
            ['key' => 'timezone', 'value' => 'UTC', 'type' => 'string', 'description' => 'Default timezone', 'category' => 'general'],

            // Investment settings
            ['key' => 'min_investment', 'value' => '10', 'type' => 'float', 'description' => 'Minimum investment amount', 'category' => 'investment'],
            ['key' => 'max_investment', 'value' => '10000', 'type' => 'float', 'description' => 'Maximum investment amount', 'category' => 'investment'],
            ['key' => 'investment_duration', 'value' => '30', 'type' => 'integer', 'description' => 'Default investment duration in days', 'category' => 'investment'],
            ['key' => 'compound_frequency', 'value' => 'daily', 'type' => 'string', 'description' => 'Compound interest frequency', 'category' => 'investment'],
            ['key' => 'auto_profit_distribution', 'value' => '1', 'type' => 'boolean', 'description' => 'Enable automatic profit distribution', 'category' => 'investment'],

            // Payment settings
            ['key' => 'min_deposit', 'value' => '10', 'type' => 'float', 'description' => 'Minimum deposit amount', 'category' => 'payment'],
            ['key' => 'max_deposit', 'value' => '50000', 'type' => 'float', 'description' => 'Maximum deposit amount', 'category' => 'payment'],
            ['key' => 'min_withdrawal', 'value' => '10', 'type' => 'float', 'description' => 'Minimum withdrawal amount', 'category' => 'payment'],
            ['key' => 'max_withdrawal', 'value' => '10000', 'type' => 'float', 'description' => 'Maximum withdrawal amount', 'category' => 'payment'],
            ['key' => 'withdrawal_charge', 'value' => '5', 'type' => 'float', 'description' => 'Withdrawal charge percentage', 'category' => 'payment'],

            // Referral settings
            ['key' => 'referral_bonus', 'value' => '10', 'type' => 'float', 'description' => 'Referral bonus percentage', 'category' => 'referral'],
            ['key' => 'referral_level_1', 'value' => '10', 'type' => 'float', 'description' => 'Level 1 referral percentage', 'category' => 'referral'],
            ['key' => 'referral_level_2', 'value' => '5', 'type' => 'float', 'description' => 'Level 2 referral percentage', 'category' => 'referral'],
            ['key' => 'referral_level_3', 'value' => '2', 'type' => 'float', 'description' => 'Level 3 referral percentage', 'category' => 'referral'],

            // Security settings
            ['key' => 'password_min_length', 'value' => '8', 'type' => 'integer', 'description' => 'Minimum password length', 'category' => 'security'],
            ['key' => 'login_attempts', 'value' => '5', 'type' => 'integer', 'description' => 'Maximum login attempts', 'category' => 'security'],
            ['key' => 'lockout_duration', 'value' => '30', 'type' => 'integer', 'description' => 'Account lockout duration in minutes', 'category' => 'security'],
            ['key' => 'two_factor_auth', 'value' => '0', 'type' => 'boolean', 'description' => 'Enable two-factor authentication', 'category' => 'security'],

            // Email settings
            ['key' => 'smtp_host', 'value' => 'smtp.gmail.com', 'type' => 'string', 'description' => 'SMTP host', 'category' => 'email'],
            ['key' => 'smtp_port', 'value' => '587', 'type' => 'integer', 'description' => 'SMTP port', 'category' => 'email'],
            ['key' => 'smtp_username', 'value' => '', 'type' => 'string', 'description' => 'SMTP username', 'category' => 'email'],
            ['key' => 'smtp_password', 'value' => '', 'type' => 'string', 'description' => 'SMTP password', 'category' => 'email'],
            ['key' => 'email_from', 'value' => 'noreply@btc-investment.com', 'type' => 'string', 'description' => 'From email address', 'category' => 'email'],

            // Notification settings
            ['key' => 'email_notifications', 'value' => '1', 'type' => 'boolean', 'description' => 'Enable email notifications', 'category' => 'notification'],
            ['key' => 'deposit_notification', 'value' => '1', 'type' => 'boolean', 'description' => 'Notify on deposits', 'category' => 'notification'],
            ['key' => 'withdrawal_notification', 'value' => '1', 'type' => 'boolean', 'description' => 'Notify on withdrawals', 'category' => 'notification'],
            ['key' => 'investment_notification', 'value' => '1', 'type' => 'boolean', 'description' => 'Notify on investments', 'category' => 'notification']
        ];

        foreach ($defaults as $setting) {
            self::set(
                $setting['key'],
                $setting['value'],
                $setting['type'],
                $setting['description'],
                $setting['category']
            );
        }
    }

    /**
     * Get setting categories with counts
     */
    public static function getCategoriesWithCounts()
    {
        $stmt = self::$db->query("
            SELECT category, COUNT(*) as count
            FROM settings
            GROUP BY category
            ORDER BY category ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Search settings
     */
    public static function search($query)
    {
        $stmt = self::$db->prepare("
            SELECT * FROM settings
            WHERE `key` LIKE ? OR description LIKE ?
            ORDER BY category ASC, `key` ASC
        ");
        $searchTerm = "%$query%";
        $stmt->execute([$searchTerm, $searchTerm]);
        $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cast values
        foreach ($settings as &$setting) {
            $setting['value'] = self::castValue($setting['value'], $setting['type']);
        }

        return $settings;
    }

    /**
     * Export settings
     */
    public static function export()
    {
        $settings = self::getAll();
        return json_encode($settings, JSON_PRETTY_PRINT);
    }

    /**
     * Import settings
     */
    public static function import($jsonData)
    {
        $settings = json_decode($jsonData, true);
        if (!$settings) return false;

        foreach ($settings as $setting) {
            self::set(
                $setting['key'],
                $setting['value'],
                $setting['type'] ?? 'string',
                $setting['description'] ?? '',
                $setting['category'] ?? 'general'
            );
        }

        return true;
    }

    /**
     * Validate setting type
     */
    public static function isValidType($type)
    {
        return in_array($type, self::TYPES);
    }

    /**
     * Validate setting category
     */
    public static function isValidCategory($category)
    {
        return in_array($category, self::CATEGORIES);
    }
}