<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Admin extends Model
{
    protected $table = 'admins';
    protected $fillable = [
        'name',
        'email',
        'password',
        'status'
    ];

    protected $hidden = ['password'];

    /**
     * Find admin by email
     */
    public static function findByEmail($email)
    {
        $stmt = self::$db->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get all users with pagination
     */
    public static function getUsers($page = 1, $perPage = 20)
    {
        $offset = ($page - 1) * $perPage;
        $stmt = self::$db->prepare("
            SELECT id, name, email, balance, status, created_at
            FROM users
            ORDER BY created_at DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$perPage, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get user count
     */
    public static function getUserCount()
    {
        $stmt = self::$db->query("SELECT COUNT(*) as count FROM users");
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    /**
     * Get recent deposits
     */
    public static function getRecentDeposits($limit = 10)
    {
        $stmt = self::$db->prepare("
            SELECT d.*, u.name as user_name, pm.name as payment_method
            FROM deposits d
            JOIN users u ON d.user_id = u.id
            JOIN payment_methods pm ON d.payment_method_id = pm.id
            ORDER BY d.created_at DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get recent withdrawals
     */
    public static function getRecentWithdrawals($limit = 10)
    {
        $stmt = self::$db->prepare("
            SELECT w.*, u.name as user_name, pm.name as payment_method
            FROM withdrawals w
            JOIN users u ON w.user_id = u.id
            JOIN payment_methods pm ON w.payment_method_id = pm.id
            ORDER BY w.created_at DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get total statistics
     */
    public static function getStats()
    {
        $stats = [];

        // Total users
        $stmt = self::$db->query("SELECT COUNT(*) as total FROM users");
        $stats['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Total deposits
        $stmt = self::$db->query("SELECT SUM(amount) as total FROM deposits WHERE status = 'approved'");
        $stats['total_deposits'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // Total withdrawals
        $stmt = self::$db->query("SELECT SUM(amount) as total FROM withdrawals WHERE status = 'paid'");
        $stats['total_withdrawals'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // Total investments
        $stmt = self::$db->query("SELECT SUM(amount) as total FROM investments WHERE status = 'active'");
        $stats['total_investments'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        return $stats;
    }
}