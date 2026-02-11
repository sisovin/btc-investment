<?php

namespace App\Core;

class Session
{
    private static $flashMessages = [];
    private static $csrfToken = null;

    /**
     * Start session
     */
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Get session value
     */
    public static function get($key, $default = null)
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Set session value
     */
    public static function set($key, $value)
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * Check if session key exists
     */
    public static function has($key)
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    /**
     * Remove session value
     */
    public static function remove($key)
    {
        self::start();
        unset($_SESSION[$key]);
    }

    /**
     * Clear all session data
     */
    public static function clear()
    {
        self::start();
        session_unset();
    }

    /**
     * Destroy session
     */
    public static function destroy()
    {
        self::start();
        session_destroy();
        self::$flashMessages = [];
        self::$csrfToken = null;
    }

    /**
     * Regenerate session ID
     */
    public static function regenerate()
    {
        self::start();
        session_regenerate_id(true);
    }

    /**
     * Set flash message
     */
    public static function flash($key, $value)
    {
        self::start();
        $_SESSION['_flash'][$key] = $value;
        self::$flashMessages[$key] = $value;
    }

    /**
     * Get flash message
     */
    public static function getFlash($key)
    {
        self::start();
        return $_SESSION['_flash'][$key] ?? null;
    }

    /**
     * Get all flash messages
     */
    public static function getFlashMessages()
    {
        self::start();
        $messages = $_SESSION['_flash'] ?? [];
        unset($_SESSION['_flash']); // Clear flash messages after retrieval
        return $messages;
    }

    /**
     * Check if flash message exists
     */
    public static function hasFlash($key)
    {
        self::start();
        return isset($_SESSION['_flash'][$key]);
    }

    /**
     * Set multiple flash messages
     */
    public static function flashMultiple(array $messages)
    {
        foreach ($messages as $key => $value) {
            self::flash($key, $value);
        }
    }

    /**
     * Generate CSRF token
     */
    public static function generateCsrfToken()
    {
        if (self::$csrfToken === null) {
            self::$csrfToken = bin2hex(random_bytes(32));
            self::set('_csrf_token', self::$csrfToken);
        }
        return self::$csrfToken;
    }

    /**
     * Get CSRF token
     */
    public static function getCsrfToken()
    {
        if (self::$csrfToken === null) {
            self::$csrfToken = self::get('_csrf_token');
            if (!self::$csrfToken) {
                self::$csrfToken = self::generateCsrfToken();
            }
        }
        return self::$csrfToken;
    }

    /**
     * Validate CSRF token
     */
    public static function validateCsrfToken($token)
    {
        return hash_equals(self::getCsrfToken(), $token);
    }

    /**
     * Get session ID
     */
    public static function getId()
    {
        self::start();
        return session_id();
    }

    /**
     * Set session name
     */
    public static function setName($name)
    {
        session_name($name);
    }

    /**
     * Get session name
     */
    public static function getName()
    {
        return session_name();
    }

    /**
     * Set session cookie parameters
     */
    public static function setCookieParams($lifetime = 0, $path = '/', $domain = '', $secure = false, $httponly = true)
    {
        session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
    }

    /**
     * Get all session data
     */
    public static function all()
    {
        self::start();
        return $_SESSION;
    }

    /**
     * Push value to session array
     */
    public static function push($key, $value)
    {
        self::start();
        if (!isset($_SESSION[$key]) || !is_array($_SESSION[$key])) {
            $_SESSION[$key] = [];
        }
        $_SESSION[$key][] = $value;
    }

    /**
     * Pull value from session array
     */
    public static function pull($key, $default = null)
    {
        $value = self::get($key, $default);
        self::remove($key);
        return $value;
    }

    /**
     * Increment session value
     */
    public static function increment($key, $amount = 1)
    {
        $value = self::get($key, 0);
        self::set($key, $value + $amount);
        return $value + $amount;
    }

    /**
     * Decrement session value
     */
    public static function decrement($key, $amount = 1)
    {
        $value = self::get($key, 0);
        self::set($key, $value - $amount);
        return $value - $amount;
    }

    /**
     * Store user data in session
     */
    public static function setUser($user)
    {
        self::set('user', $user);
    }

    /**
     * Get user from session
     */
    public static function getUser()
    {
        return self::get('user');
    }

    /**
     * Check if user is logged in
     */
    public static function isLoggedIn()
    {
        return self::has('user');
    }

    /**
     * Store admin data in session
     */
    public static function setAdmin($admin)
    {
        self::set('admin', $admin);
    }

    /**
     * Get admin from session
     */
    public static function getAdmin()
    {
        return self::get('admin');
    }

    /**
     * Check if admin is logged in
     */
    public static function isAdminLoggedIn()
    {
        return self::has('admin');
    }

    /**
     * Set language
     */
    public static function setLanguage($lang)
    {
        self::set('language', $lang);
    }

    /**
     * Get language
     */
    public static function getLanguage($default = 'en')
    {
        return self::get('language', $default);
    }

    /**
     * Set theme
     */
    public static function setTheme($theme)
    {
        self::set('theme', $theme);
    }

    /**
     * Get theme
     */
    public static function getTheme($default = 'light')
    {
        return self::get('theme', $default);
    }

    /**
     * Remember user login
     */
    public static function rememberLogin($userId)
    {
        $token = bin2hex(random_bytes(32));
        self::set('remember_token', $token);

        // In a real application, you'd store this token in the database
        // associated with the user for persistent login
    }

    /**
     * Check remember token
     */
    public static function checkRememberToken($token)
    {
        $storedToken = self::get('remember_token');
        return $storedToken && hash_equals($storedToken, $token);
    }
}