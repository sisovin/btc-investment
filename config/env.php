<?php

/**
 * Environment Configuration Loader
 *
 * This file loads environment variables from .env file and provides
 * a centralized way to access environment configuration.
 */

namespace App\Config;

use Exception;

class EnvLoader
{
    /**
     * Loaded environment variables
     */
    private static array $env = [];

    /**
     * Whether environment has been loaded
     */
    private static bool $loaded = false;

    /**
     * Load environment variables from .env file
     */
    public static function load(?string $path = null): void
    {
        if (self::$loaded) {
            return;
        }

        $path = $path ?? dirname(__DIR__) . '/.env';

        if (!file_exists($path)) {
            // Try .env.example as fallback for development
            $examplePath = dirname(__DIR__) . '/.env.example';
            if (file_exists($examplePath)) {
                $path = $examplePath;
            } else {
                throw new Exception("Environment file not found: {$path}");
            }
        }

        self::parseEnvFile($path);
        self::$loaded = true;
    }

    /**
     * Parse .env file
     */
    private static function parseEnvFile(string $path): void
    {
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            // Skip comments
            if (str_starts_with($line, '#')) {
                continue;
            }

            // Parse key=value
            if (strpos($line, '=') !== false) {
                [$key, $value] = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);

                // Remove quotes if present
                if ((str_starts_with($value, '"') && str_ends_with($value, '"')) ||
                    (str_starts_with($value, "'") && str_ends_with($value, "'"))) {
                    $value = substr($value, 1, -1);
                }

                // Handle special values
                $value = self::parseValue($value);

                self::$env[$key] = $value;
                $_ENV[$key] = $value;
                putenv("{$key}={$value}");
            }
        }
    }

    /**
     * Parse special values like booleans, nulls, etc.
     */
    private static function parseValue(string $value): mixed
    {
        // Handle empty strings
        if ($value === '') {
            return '';
        }

        // Handle booleans
        if (strtolower($value) === 'true') {
            return true;
        }
        if (strtolower($value) === 'false') {
            return false;
        }

        // Handle null
        if (strtolower($value) === 'null') {
            return null;
        }

        // Handle numeric values
        if (is_numeric($value)) {
            return strpos($value, '.') !== false ? (float) $value : (int) $value;
        }

        return $value;
    }

    /**
     * Get environment variable
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        if (!self::$loaded) {
            self::load();
        }

        return self::$env[$key] ?? $_ENV[$key] ?? getenv($key) ?: $default;
    }

    /**
     * Set environment variable
     */
    public static function set(string $key, mixed $value): void
    {
        self::$env[$key] = $value;
        $_ENV[$key] = $value;
        putenv("{$key}=" . (is_bool($value) ? ($value ? 'true' : 'false') : $value));
    }

    /**
     * Check if environment variable exists
     */
    public static function has(string $key): bool
    {
        if (!self::$loaded) {
            self::load();
        }

        return isset(self::$env[$key]) || isset($_ENV[$key]) || getenv($key) !== false;
    }

    /**
     * Get all environment variables
     */
    public static function all(): array
    {
        if (!self::$loaded) {
            self::load();
        }

        return self::$env;
    }

    /**
     * Clear loaded environment variables
     */
    public static function clear(): void
    {
        self::$env = [];
        self::$loaded = false;
    }
}