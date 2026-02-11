<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $connection;

    /**
     * Private constructor to prevent direct instantiation
     */
    private function __construct()
    {
        $this->connect();
    }

    /**
     * Get database instance (Singleton pattern)
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Establish database connection
     */
    private function connect()
    {
        $config = $this->getConfig();

        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['database']}";
            $this->connection = new PDO($dsn, $config['username'], $config['password'], $config['options']);

            // Set character set
            $this->connection->exec("SET NAMES {$config['charset']}");

            // Set PDO attributes
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        } catch (PDOException $e) {
            throw new PDOException("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Get database configuration
     */
    private function getConfig()
    {
        $configFile = __DIR__ . '/../../config/database.php';
        if (!file_exists($configFile)) {
            throw new \Exception("Database configuration file not found: $configFile");
        }

        $config = require $configFile;

        // Get the default connection configuration
        $defaultConnection = $config['default'] ?? 'mysql';
        $connectionConfig = $config['connections'][$defaultConnection] ?? [];

        // Override with environment variables if available
        $connectionConfig['host'] = getenv('DB_HOST') ?: ($connectionConfig['host'] ?? '127.0.0.1');
        $connectionConfig['database'] = getenv('DB_DATABASE') ?: ($connectionConfig['database'] ?? 'btc_investment');
        $connectionConfig['username'] = getenv('DB_USERNAME') ?: ($connectionConfig['username'] ?? 'root');
        $connectionConfig['password'] = getenv('DB_PASSWORD') ?: ($connectionConfig['password'] ?? '');
        $connectionConfig['charset'] = $connectionConfig['charset'] ?? 'utf8mb4';
        $connectionConfig['options'] = $connectionConfig['options'] ?? [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        return $connectionConfig;
    }

    /**
     * Get PDO connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Execute a query and return PDOStatement
     */
    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new PDOException("Query execution failed: " . $e->getMessage());
        }
    }

    /**
     * Execute a query and return all results
     */
    public function fetchAll($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }

    /**
     * Execute a query and return single result
     */
    public function fetch($sql, $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }

    /**
     * Execute a query and return single column
     */
    public function fetchColumn($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchColumn();
    }

    /**
     * Execute an INSERT, UPDATE, or DELETE query
     */
    public function execute($sql, $params = [])
    {
        return $this->query($sql, $params)->rowCount();
    }

    /**
     * Get last inserted ID
     */
    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }

    /**
     * Begin transaction
     */
    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    /**
     * Commit transaction
     */
    public function commit()
    {
        return $this->connection->commit();
    }

    /**
     * Rollback transaction
     */
    public function rollback()
    {
        return $this->connection->rollBack();
    }

    /**
     * Check if in transaction
     */
    public function inTransaction()
    {
        return $this->connection->inTransaction();
    }

    /**
     * Get database info
     */
    public function getDatabaseInfo()
    {
        return [
            'driver' => $this->connection->getAttribute(PDO::ATTR_DRIVER_NAME),
            'version' => $this->connection->getAttribute(PDO::ATTR_SERVER_VERSION),
            'connection_status' => $this->connection->getAttribute(PDO::ATTR_CONNECTION_STATUS)
        ];
    }

    /**
     * Test database connection
     */
    public static function testConnection()
    {
        try {
            $db = self::getInstance();
            $db->query("SELECT 1");
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Close database connection
     */
    public function close()
    {
        $this->connection = null;
        self::$instance = null;
    }

    /**
     * Prevent cloning
     */
    private function __clone() {}

    /**
     * Prevent unserialization
     */
    public function __wakeup() {}
}