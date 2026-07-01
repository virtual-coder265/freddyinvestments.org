<?php
namespace App\Models;

use App\Database\Database;

/**
 * Base Model Class
 * Provides common database operations for all models and implements ArrayAccess for backward compatibility
 */
abstract class Model implements \ArrayAccess {
    protected $db;
    protected $table;
    protected $attributes = [];
    protected $fillable = [];

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Find record by ID
     */
    public static function find($id) {
        $instance = new static();
        $data = $instance->db->fetch(
            "SELECT * FROM {$instance->table} WHERE id = ?",
            [$id]
        );
        if (!$data) {
            return null;
        }
        $instance->attributes = $data;
        return $instance;
    }

    /**
     * Get all records
     */
    public static function all() {
        $instance = new static();
        $rows = $instance->db->fetchAll("SELECT * FROM {$instance->table}");
        
        $results = [];
        foreach ($rows as $row) {
            $item = new static();
            $item->attributes = $row;
            $results[] = $item;
        }
        return $results;
    }

    /**
     * Create new record
     */
    public static function create($data) {
        $instance = new static();
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($instance->db->hasColumn($instance->table, 'updated_at')) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        
        $id = $instance->db->insert($instance->table, $data);
        return static::find($id);
    }

    /**
     * Update record
     */
    public function update($data) {
        if ($this->db->hasColumn($this->table, 'updated_at')) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        $this->db->update($this->table, $data, 'id = ?', [$this->attributes['id']]);
        
        $updated = $this->db->fetch(
            "SELECT * FROM {$this->table} WHERE id = ?",
            [$this->attributes['id']]
        );
        $this->attributes = $updated;
        return $this;
    }

    /**
     * Delete record
     */
    public function delete() {
        return $this->db->delete($this->table, 'id = ?', [$this->attributes['id']]);
    }

    /**
     * Find by condition
     */
    public static function where($column, $operator, $value = null) {
        $instance = new static();
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        
        $rows = $instance->db->fetchAll(
            "SELECT * FROM {$instance->table} WHERE {$column} {$operator} ?",
            [$value]
        );
        
        $results = [];
        foreach ($rows as $row) {
            $item = new static();
            $item->attributes = $row;
            $results[] = $item;
        }
        return $results;
    }

    /**
     * Get first matching record
     */
    public static function firstWhere($column, $value) {
        $instance = new static();
        $data = $instance->db->fetch(
            "SELECT * FROM {$instance->table} WHERE {$column} = ?",
            [$value]
        );
        if (!$data) {
            return null;
        }
        $instance->attributes = $data;
        return $instance;
    }

    /**
     * Count records
     */
    public static function count($where = null, $params = []) {
        $instance = new static();
        return $instance->db->count($instance->table, $where, $params);
    }

    /**
     * Get attribute value
     */
    public function __get($key) {
        return $this->attributes[$key] ?? null;
    }

    /**
     * Set attribute value
     */
    public function __set($key, $value) {
        $this->attributes[$key] = $value;
    }

    /**
     * Set attributes from array
     */
    public function fill($data) {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->attributes[$key] = $value;
            }
        }
        return $this;
    }

    /**
     * Convert to array
     */
    public function toArray() {
        return $this->attributes;
    }

    /**
     * ArrayAccess Implementation
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($offset): bool {
        return isset($this->attributes[$offset]);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset) {
        return $this->attributes[$offset] ?? null;
    }

    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value): void {
        $this->attributes[$offset] = $value;
    }

    #[\ReturnTypeWillChange]
    public function offsetUnset($offset): void {
        unset($this->attributes[$offset]);
    }
}
