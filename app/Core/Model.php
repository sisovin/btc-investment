<?php

namespace App\Core;

use PDO;
use PDOException;

abstract class Model
{
    protected static $db;
    protected $table;
    protected $fillable = [];
    protected $attributes = [];
    protected $exists = false;

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    /**
     * Initialize database connection
     */
    public static function initDatabase()
    {
        if (!self::$db) {
            $config = require __DIR__ . '/../../config/database.php';
            try {
                self::$db = new PDO(
                    "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}",
                    $config['username'],
                    $config['password'],
                    $config['options']
                );
            } catch (PDOException $e) {
                throw new PDOException("Database connection failed: " . $e->getMessage());
            }
        }
    }

    /**
     * Set database instance
     */
    public static function setDatabase($db)
    {
        self::$db = $db;
    }

    /**
     * Get database instance
     */
    public static function getDB()
    {
        if (!self::$db) {
            self::initDatabase();
        }
        return self::$db;
    }

    /**
     * Fill model with attributes
     */
    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->fillable) || empty($this->fillable)) {
                $this->attributes[$key] = $value;
            }
        }
    }

    /**
     * Set attribute
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->fillable) || empty($this->fillable)) {
            $this->attributes[$key] = $value;
        }
    }

    /**
     * Get attribute
     */
    public function getAttribute($key)
    {
        return $this->attributes[$key] ?? null;
    }

    /**
     * Magic getter
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Magic setter
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    /**
     * Check if attribute exists
     */
    public function __isset($key)
    {
        return isset($this->attributes[$key]);
    }

    /**
     * Create new record
     */
    public static function create(array $attributes)
    {
        $instance = new static($attributes);
        $instance->save();
        return $instance;
    }

    /**
     * Save model
     */
    public function save()
    {
        if ($this->exists) {
            return $this->update();
        } else {
            return $this->insert();
        }
    }

    /**
     * Insert new record
     */
    protected function insert()
    {
        $columns = array_keys($this->attributes);
        $placeholders = str_repeat('?,', count($columns) - 1) . '?';

        $sql = "INSERT INTO {$this->table} (" . implode(',', $columns) . ") VALUES ($placeholders)";

        $stmt = self::getDB()->prepare($sql);
        $values = array_values($this->attributes);

        if ($stmt->execute($values)) {
            $this->attributes['id'] = self::getDB()->lastInsertId();
            $this->exists = true;
            return true;
        }

        return false;
    }

    /**
     * Update existing record
     */
    protected function update()
    {
        $columns = array_keys($this->attributes);
        $setClause = implode('=?,', $columns) . '=?';
        $sql = "UPDATE {$this->table} SET $setClause WHERE id = ?";

        $stmt = self::getDB()->prepare($sql);
        $values = array_values($this->attributes);
        $values[] = $this->attributes['id'];

        return $stmt->execute($values);
    }

    /**
     * Find record by ID
     */
    public static function find($id)
    {
        $stmt = self::getDB()->prepare("SELECT * FROM " . static::getTableName() . " WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $instance = new static($data);
            $instance->exists = true;
            return $instance;
        }

        return null;
    }

    /**
     * Find record by ID or fail
     */
    public static function findOrFail($id)
    {
        $model = self::find($id);
        if (!$model) {
            throw new \Exception("Model not found");
        }
        return $model;
    }

    /**
     * Find by specific column
     */
    public static function findBy($column, $value)
    {
        $stmt = self::getDB()->prepare("SELECT * FROM " . static::getTableName() . " WHERE $column = ?");
        $stmt->execute([$value]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $instance = new static($data);
            $instance->exists = true;
            return $instance;
        }

        return null;
    }

    /**
     * Get all records
     */
    public static function all()
    {
        $stmt = self::getDB()->query("SELECT * FROM " . static::getTableName());
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get records with conditions
     */
    public static function where($column, $operator, $value)
    {
        $stmt = self::getDB()->prepare("SELECT * FROM " . static::getTableName() . " WHERE $column $operator ?");
        $stmt->execute([$value]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Delete record
     */
    public function delete()
    {
        if (!$this->exists) return false;

        $stmt = self::getDB()->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $result = $stmt->execute([$this->attributes['id']]);

        if ($result) {
            $this->exists = false;
        }

        return $result;
    }

    /**
     * Get table name
     */
    protected static function getTableName()
    {
        $className = get_called_class();
        $parts = explode('\\', $className);
        $modelName = end($parts);
        return strtolower($modelName) . 's'; // Simple pluralization
    }

    /**
     * Convert to array
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * Convert to JSON
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * Get fillable attributes
     */
    public function getFillable()
    {
        return $this->fillable;
    }

    /**
     * Check if model exists in database
     */
    public function exists()
    {
        return $this->exists;
    }

    /**
     * Get model ID
     */
    public function getId()
    {
        return $this->attributes['id'] ?? null;
    }

    /**
     * Update specific attributes
     */
    public function updateAttributes(array $attributes)
    {
        $this->fill($attributes);
        return $this->save();
    }

    /**
     * Refresh model from database
     */
    public function refresh()
    {
        if (!$this->exists || !isset($this->attributes['id'])) return false;

        $fresh = self::find($this->attributes['id']);
        if ($fresh) {
            $this->attributes = $fresh->attributes;
            return true;
        }

        return false;
    }

    /**
     * Get created at timestamp
     */
    public function getCreatedAt()
    {
        return $this->attributes['created_at'] ?? null;
    }

    /**
     * Get updated at timestamp
     */
    public function getUpdatedAt()
    {
        return $this->attributes['updated_at'] ?? null;
    }
}