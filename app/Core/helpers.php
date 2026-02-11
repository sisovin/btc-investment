<?php

use App\Core\Auth;
use App\Core\View;
use App\Core\Session;
use App\Models\Setting;
use App\Config\EnvLoader;

/**
 * Get environment variable
 */
if (!function_exists('env')) {
    function env($key, $default = null)
    {
        return EnvLoader::get($key, $default);
    }
}

/**
 * Get application configuration
 */
if (!function_exists('config')) {
    function config($key, $default = null)
    {
        static $config = [];

        if (empty($config)) {
            $configFiles = glob(__DIR__ . '/../config/*.php');
            foreach ($configFiles as $file) {
                $name = basename($file, '.php');
                if ($name === 'constants') {
                    continue; // Skip constants.php as it defines constants, not returns config array
                }
                $config[$name] = require $file;
            }
        }

        $keys = explode('.', $key);
        $value = $config;

        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return $default;
            }
            $value = $value[$k];
        }

        return $value;
    }
}

/**
 * Get authentication helper
 */
if (!function_exists('auth')) {
    function auth()
    {
        return new class {
            public function check() {
                return Auth::check();
            }
            public function user() {
                return Auth::user();
            }
            public function checkAdmin() {
                return Auth::checkAdmin();
            }
            public function admin() {
                return Auth::admin();
            }
        };
    }
}

/**
 * Check if user is authenticated
 */
if (!function_exists('auth_check')) {
    function auth_check()
    {
        return Auth::check();
    }
}

/**
 * Get authenticated admin
 */
if (!function_exists('admin')) {
    function admin()
    {
        return Auth::admin();
    }
}

/**
 * Check if admin is authenticated
 */
if (!function_exists('admin_check')) {
    function admin_check()
    {
        return Auth::checkAdmin();
    }
}

/**
 * Get session helper
 */
if (!function_exists('session')) {
    function session()
    {
        return new class {
            public function get($key, $default = null) {
                return Session::get($key, $default);
            }
            public function set($key, $value) {
                return Session::set($key, $value);
            }
            public function has($key) {
                return Session::has($key);
            }
            public function remove($key) {
                return Session::remove($key);
            }
            public function flash($key, $value) {
                return Session::flash($key, $value);
            }
            public function getFlash($key) {
                return Session::getFlash($key);
            }
        };
    }
}

/**
 * Get setting value
 */
if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return Setting::get($key, $default);
    }
}

/**
 * Get base path
 */
if (!function_exists('base_path')) {
    function base_path($path = '')
    {
        return __DIR__ . '/../' . ltrim($path, '/');
    }
}

/**
 * Get app path
 */
if (!function_exists('app_path')) {
    function app_path($path = '')
    {
        return base_path('app/' . ltrim($path, '/'));
    }
}

/**
 * Get config path
 */
if (!function_exists('config_path')) {
    function config_path($path = '')
    {
        return base_path('config/' . ltrim($path, '/'));
    }
}

/**
 * Get database path
 */
if (!function_exists('database_path')) {
    function database_path($path = '')
    {
        return base_path('database/' . ltrim($path, '/'));
    }
}

/**
 * Get public path
 */
if (!function_exists('public_path')) {
    function public_path($path = '')
    {
        return base_path('public/' . ltrim($path, '/'));
    }
}

/**
 * Get resources path
 */
if (!function_exists('resource_path')) {
    function resource_path($path = '')
    {
        return base_path('resources/' . ltrim($path, '/'));
    }
}

/**
 * Get storage path
 */
if (!function_exists('storage_path')) {
    function storage_path($path = '')
    {
        return base_path('storage/' . ltrim($path, '/'));
    }
}

/**
 * Get view path
 */
if (!function_exists('view_path')) {
    function view_path($path = '')
    {
        return resource_path('views/' . ltrim($path, '/'));
    }
}

/**
 * Generate URL
 */
if (!function_exists('url')) {
    function url($path = '')
    {
        $baseUrl = env('APP_URL', 'http://localhost');
        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }
}

/**
 * Generate asset URL
 */
if (!function_exists('asset')) {
    function asset($path)
    {
        return url('assets/' . ltrim($path, '/'));
    }
}

/**
 * Generate route URL
 */
if (!function_exists('route')) {
    function route($name, $params = [])
    {
        // This would require named routes implementation
        return url($name);
    }
}

/**
 * Redirect to URL
 */
if (!function_exists('redirect')) {
    function redirect($url, $statusCode = 302)
    {
        header("Location: $url", true, $statusCode);
        exit;
    }
}

/**
 * Redirect back
 */
if (!function_exists('back')) {
    function back()
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        redirect($referer);
    }
}

/**
 * Get old input value
 */
if (!function_exists('old')) {
    function old($key, $default = '')
    {
        return Session::get("old_input.$key", $default);
    }
}

/**
 * Get CSRF token
 */
if (!function_exists('csrf_token')) {
    function csrf_token()
    {
        return Session::getCsrfToken();
    }
}

/**
 * CSRF field
 */
if (!function_exists('csrf_field')) {
    function csrf_field()
    {
        return '<input type="hidden" name="_token" value="' . csrf_token() . '">';
    }
}

/**
 * Get flash message
 */
if (!function_exists('flash')) {
    function flash($key)
    {
        return Session::getFlash($key);
    }
}

/**
 * Set flash message
 */
if (!function_exists('set_flash')) {
    function set_flash($key, $value)
    {
        Session::flash($key, $value);
    }
}

/**
 * Format currency
 */
if (!function_exists('currency')) {
    function currency($amount, $currency = 'USD')
    {
        return number_format($amount, 2) . ' ' . $currency;
    }
}

/**
 * Format date
 */
if (!function_exists('format_date')) {
    function format_date($date, $format = 'Y-m-d H:i:s')
    {
        return date($format, strtotime($date));
    }
}

/**
 * Truncate text
 */
if (!function_exists('truncate')) {
    function truncate($text, $length = 100, $suffix = '...')
    {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . $suffix;
    }
}

/**
 * Check if current route matches
 */
if (!function_exists('is_active')) {
    function is_active($route)
    {
        return View::isActive($route);
    }
}

/**
 * Dump and die
 */
if (!function_exists('dd')) {
    function dd(...$vars)
    {
        echo '<pre>';
        foreach ($vars as $var) {
            var_dump($var);
        }
        echo '</pre>';
        die;
    }
}

/**
 * Dump
 */
if (!function_exists('dump')) {
    function dump(...$vars)
    {
        echo '<pre>';
        foreach ($vars as $var) {
            var_dump($var);
        }
        echo '</pre>';
    }
}

/**
 * Get current request method
 */
if (!function_exists('request_method')) {
    function request_method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}

/**
 * Check if request is POST
 */
if (!function_exists('is_post')) {
    function is_post()
    {
        return request_method() === 'POST';
    }
}

/**
 * Check if request is GET
 */
if (!function_exists('is_get')) {
    function is_get()
    {
        return request_method() === 'GET';
    }
}

/**
 * Check if request is AJAX
 */
if (!function_exists('is_ajax')) {
    function is_ajax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}

/**
 * Get client IP
 */
if (!function_exists('get_ip')) {
    function get_ip()
    {
        return $_SERVER['HTTP_X_FORWARDED_FOR'] ??
               $_SERVER['HTTP_CLIENT_IP'] ??
               $_SERVER['REMOTE_ADDR'] ??
               '127.0.0.1';
    }
}

/**
 * Generate random string
 */
if (!function_exists('str_random')) {
    function str_random($length = 16)
    {
        return bin2hex(random_bytes($length / 2));
    }
}

/**
 * Check if string starts with
 */
if (!function_exists('str_starts_with')) {
    function str_starts_with($haystack, $needle)
    {
        return strpos($haystack, $needle) === 0;
    }
}

/**
 * Check if string ends with
 */
if (!function_exists('str_ends_with')) {
    function str_ends_with($haystack, $needle)
    {
        return substr($haystack, -strlen($needle)) === $needle;
    }
}

/**
 * Convert to snake_case
 */
if (!function_exists('snake_case')) {
    function snake_case($string)
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }
}

/**
 * Convert to camelCase
 */
if (!function_exists('camel_case')) {
    function camel_case($string)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $string))));
    }
}

/**
 * Array get helper
 */
if (!function_exists('array_get')) {
    function array_get($array, $key, $default = null)
    {
        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return $default;
            }
            $array = $array[$segment];
        }

        return $array;
    }
}

/**
 * Array set helper
 */
if (!function_exists('array_set')) {
    function array_set(&$array, $key, $value)
    {
        $keys = explode('.', $key);
        $current = &$array;

        foreach ($keys as $key) {
            if (!isset($current[$key]) || !is_array($current[$key])) {
                $current[$key] = [];
            }
            $current = &$current[$key];
        }

        $current = $value;
    }
}

/**
 * Array has helper
 */
if (!function_exists('array_has')) {
    function array_has($array, $key)
    {
        if (isset($array[$key])) {
            return true;
        }

        $keys = explode('.', $key);
        $current = $array;

        foreach ($keys as $key) {
            if (!is_array($current) || !array_key_exists($key, $current)) {
                return false;
            }
            $current = $current[$key];
        }

        return true;
    }
}

/**
 * Get the current request instance
 */
if (!function_exists('request')) {
    function request()
    {
        return \App\Core\Request::getInstance();
    }
}

/**
 * Generate URL for path
 */
if (!function_exists('url')) {
    function url($path = '')
    {
        return \App\Core\View::url($path);
    }
}

/**
 * Generate asset URL
 */
if (!function_exists('asset')) {
    function asset($path)
    {
        return \App\Core\View::asset($path);
    }
}

/**
 * Generate route URL
 */
if (!function_exists('route')) {
    function route($name, $params = [])
    {
        return \App\Core\View::route($name, $params);
    }
}

/**
 * Generate CSRF token
 */
if (!function_exists('csrf')) {
    function csrf()
    {
        return \App\Core\View::csrf();
    }
}

/**
 * Get auth helper
 */
if (!function_exists('auth')) {
    function auth()
    {
        return new class {
            public function check() {
                return \App\Core\Auth::check();
            }
            public function user() {
                return \App\Core\Auth::user();
            }
            public function admin() {
                return \App\Core\Auth::admin();
            }
        };
    }
}