<?php

namespace App\Core;

use Exception;

/**
 * Redis Cache Wrapper
 *
 * Provides a unified interface for Redis caching with fallback support
 * when the Redis extension is not available.
 */
class Redis
{
    private static $instance = null;
    private $connection = null;
    private $config = [];
    private $isConnected = false;

    /**
     * Get Redis instance (Singleton)
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor - Initialize Redis connection
     */
    private function __construct()
    {
        $this->config = config('redis.default');

        // Check if Redis extension is available
        if (!extension_loaded('redis')) {
            // Log warning but don't fail - Redis is optional
            error_log('Redis extension not available. Caching will be disabled.');
            return;
        }

        try {
            $this->connect();
        } catch (Exception $e) {
            // Log error but don't fail the application
            error_log('Redis connection failed: ' . $e->getMessage());
        }
    }

    /**
     * Connect to Redis server
     */
    private function connect()
    {
        if (!extension_loaded('redis')) {
            return;
        }

        $this->connection = new \Redis();

        // Connect to Redis server
        if ($this->config['password']) {
            $this->connection->connect($this->config['host'], $this->config['port'], 1, null, 0, 0, ['auth' => $this->config['password']]);
        } else {
            $this->connection->connect($this->config['host'], $this->config['port']);
        }

        // Select database
        if (isset($this->config['database'])) {
            $this->connection->select($this->config['database']);
        }

        // Test connection
        $this->connection->ping();
        $this->isConnected = true;
    }

    /**
     * Check if Redis is connected and available
     */
    public function isConnected()
    {
        return $this->isConnected && $this->connection !== null;
    }

    /**
     * Get value from cache
     */
    public function get($key)
    {
        if (!$this->isConnected()) {
            return null;
        }

        try {
            $value = $this->connection->get($key);
            return $value ? unserialize($value) : null;
        } catch (Exception $e) {
            error_log('Redis get error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Set value in cache
     */
    public function set($key, $value, $ttl = null)
    {
        if (!$this->isConnected()) {
            return false;
        }

        try {
            $serializedValue = serialize($value);

            if ($ttl) {
                return $this->connection->setex($key, $ttl, $serializedValue);
            } else {
                return $this->connection->set($key, $serializedValue);
            }
        } catch (Exception $e) {
            error_log('Redis set error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete value from cache
     */
    public function delete($key)
    {
        if (!$this->isConnected()) {
            return false;
        }

        try {
            return $this->connection->del($key);
        } catch (Exception $e) {
            error_log('Redis delete error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if key exists
     */
    public function exists($key)
    {
        if (!$this->isConnected()) {
            return false;
        }

        try {
            return $this->connection->exists($key);
        } catch (Exception $e) {
            error_log('Redis exists error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Set expiration time for key
     */
    public function expire($key, $ttl)
    {
        if (!$this->isConnected()) {
            return false;
        }

        try {
            return $this->connection->expire($key, $ttl);
        } catch (Exception $e) {
            error_log('Redis expire error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get time to live for key
     */
    public function ttl($key)
    {
        if (!$this->isConnected()) {
            return -1;
        }

        try {
            return $this->connection->ttl($key);
        } catch (Exception $e) {
            error_log('Redis ttl error: ' . $e->getMessage());
            return -1;
        }
    }

    /**
     * Increment numeric value
     */
    public function incr($key)
    {
        if (!$this->isConnected()) {
            return false;
        }

        try {
            return $this->connection->incr($key);
        } catch (Exception $e) {
            error_log('Redis incr error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Decrement numeric value
     */
    public function decr($key)
    {
        if (!$this->isConnected()) {
            return false;
        }

        try {
            return $this->connection->decr($key);
        } catch (Exception $e) {
            error_log('Redis decr error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Clear all cache
     */
    public function flush()
    {
        if (!$this->isConnected()) {
            return false;
        }

        try {
            return $this->connection->flushdb();
        } catch (Exception $e) {
            error_log('Redis flush error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get cache statistics
     */
    public function info()
    {
        if (!$this->isConnected()) {
            return ['status' => 'disconnected'];
        }

        try {
            return $this->connection->info();
        } catch (Exception $e) {
            error_log('Redis info error: ' . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Close Redis connection
     */
    public function close()
    {
        if ($this->isConnected() && $this->connection) {
            try {
                $this->connection->close();
                $this->isConnected = false;
            } catch (Exception $e) {
                error_log('Redis close error: ' . $e->getMessage());
            }
        }
    }

    /**
     * Destructor - Close connection
     */
    public function __destruct()
    {
        $this->close();
    }
}