<?php

namespace App\Core;

use App\Models\User;
use App\Models\Admin;
use Exception;

class Auth
{
    private static $user = null;
    private static $admin = null;
    private static $isAuthenticated = false;

    /**
     * Initialize authentication
     */
    public static function init()
    {
        self::checkSession();
        self::checkToken();
    }

    /**
     * Check session for authentication
     */
    private static function checkSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {
            $user = User::find($_SESSION['user_id']);
            if ($user && $user->status === 'active') {
                self::$user = $user;
                self::$isAuthenticated = true;
            }
        }

        if (isset($_SESSION['admin_id'])) {
            $admin = Admin::find($_SESSION['admin_id']);
            if ($admin && $admin->status === 'active') {
                self::$admin = $admin;
            }
        }
    }

    /**
     * Check JWT token for authentication
     */
    private static function checkToken()
    {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

        if (preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
            $token = $matches[1];
            $payload = JWT::validateToken($token);

            if ($payload && isset($payload['sub'])) {
                $user = User::find($payload['sub']);
                if ($user && $user->status === 'active') {
                    self::$user = $user;
                    self::$isAuthenticated = true;
                }
            }
        }
    }

    /**
     * Attempt user login
     */
    public static function attempt($email, $password, $remember = false)
    {
        $user = User::findByEmail($email);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user->password)) {
            self::logFailedLogin($user->id);
            return false;
        }

        if ($user->status !== 'active') {
            return false;
        }

        // Login successful
        self::login($user, $remember);
        return true;
    }

    /**
     * Login user
     */
    public static function login($user, $remember = false)
    {
        self::$user = $user;
        self::$isAuthenticated = true;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['user_id'] = $user->id;

        if ($remember) {
            $token = JWT::generateRefreshToken($user->id);
            setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', true, true);
        }

        // Update last login
        $user->updateAttributes(['last_login_at' => date('Y-m-d H:i:s')]);
    }

    /**
     * Attempt admin login
     */
    public static function attemptAdmin($email, $password)
    {
        $admin = Admin::findByEmail($email);

        if (!$admin) {
            return false;
        }

        if (!password_verify($password, $admin->password)) {
            return false;
        }

        if ($admin->status !== 'active') {
            return false;
        }

        // Login successful
        self::loginAdmin($admin);
        return true;
    }

    /**
     * Login admin
     */
    public static function loginAdmin($admin)
    {
        self::$admin = $admin;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['admin_id'] = $admin->id;
    }

    /**
     * Logout user
     */
    public static function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Clear session
        unset($_SESSION['user_id']);
        unset($_SESSION['admin_id']);

        // Clear remember token
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }

        self::$user = null;
        self::$admin = null;
        self::$isAuthenticated = false;
    }

    /**
     * Check if user is authenticated
     */
    public static function check()
    {
        return self::$isAuthenticated && self::$user !== null;
    }

    /**
     * Check if admin is authenticated
     */
    public static function checkAdmin()
    {
        return self::$admin !== null;
    }

    /**
     * Get authenticated user
     */
    public static function user()
    {
        return self::$user;
    }

    /**
     * Get authenticated admin
     */
    public static function admin()
    {
        return self::$admin;
    }

    /**
     * Get user ID
     */
    public static function id()
    {
        return self::$user ? self::$user->id : null;
    }

    /**
     * Get admin ID
     */
    public static function adminId()
    {
        return self::$admin ? self::$admin->id : null;
    }

    /**
     * Generate access token for user
     */
    public static function generateToken()
    {
        if (!self::$user) {
            throw new Exception('No authenticated user');
        }

        return JWT::generateAccessToken(self::$user->id, self::$user->email);
    }

    /**
     * Validate API token
     */
    public static function validateToken($token)
    {
        $payload = JWT::validateToken($token);

        if (!$payload || !isset($payload['sub'])) {
            return false;
        }

        $user = User::find($payload['sub']);
        if (!$user || $user->status !== 'active') {
            return false;
        }

        self::$user = $user;
        self::$isAuthenticated = true;

        return true;
    }

    /**
     * Require authentication
     */
    public static function requireAuth()
    {
        if (!self::check()) {
            if (self::isApiRequest()) {
                self::sendJsonResponse(['error' => 'Unauthorized'], 401);
            } else {
                header('Location: /login');
                exit;
            }
        }
    }

    /**
     * Require admin authentication
     */
    public static function requireAdmin()
    {
        if (!self::checkAdmin()) {
            if (self::isApiRequest()) {
                self::sendJsonResponse(['error' => 'Admin access required'], 403);
            } else {
                header('Location: /admin/login');
                exit;
            }
        }
    }

    /**
     * Check if request is API request
     */
    private static function isApiRequest()
    {
        $headers = getallheaders();
        return isset($headers['Accept']) && strpos($headers['Accept'], 'application/json') !== false;
    }

    /**
     * Send JSON response
     */
    private static function sendJsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Log failed login attempt
     */
    private static function logFailedLogin($userId)
    {
        // Implement failed login logging if needed
        // Could store in database or log file
    }

    /**
     * Check if user has permission
     */
    public static function hasPermission($permission)
    {
        if (!self::$user) return false;

        // Implement permission checking logic
        // This could check against a permissions table or user roles
        return true; // Placeholder
    }

    /**
     * Check if user owns resource
     */
    public static function owns($resource, $resourceId)
    {
        if (!self::$user) return false;

        // Check if user owns the resource
        // Implementation depends on the resource type
        return $resource->user_id == self::$user->id;
    }

    /**
     * Generate password reset token
     */
    public static function generatePasswordResetToken($email)
    {
        $user = User::findByEmail($email);
        if (!$user) return false;

        return JWT::generatePasswordResetToken($user->id);
    }

    /**
     * Reset password using token
     */
    public static function resetPassword($token, $newPassword)
    {
        $payload = JWT::validateToken($token);

        if (!$payload || ($payload['type'] ?? null) !== 'password_reset') {
            return false;
        }

        $user = User::find($payload['sub']);
        if (!$user) return false;

        $user->updateAttributes([
            'password' => password_hash($newPassword, PASSWORD_ARGON2ID)
        ]);

        return true;
    }

    /**
     * Generate email verification token
     */
    public static function generateEmailVerificationToken($userId)
    {
        $user = User::find($userId);
        if (!$user) return false;

        return JWT::generateEmailVerificationToken($userId, $user->email);
    }

    /**
     * Verify email using token
     */
    public static function verifyEmail($token)
    {
        $payload = JWT::validateToken($token);

        if (!$payload || ($payload['type'] ?? null) !== 'email_verification') {
            return false;
        }

        $user = User::find($payload['sub']);
        if (!$user) return false;

        $user->updateAttributes([
            'email_verified_at' => date('Y-m-d H:i:s')
        ]);

        return true;
    }
}