<?php
namespace App\Models;

/**
 * Tip Model
 */
class Tip extends Model {
    protected $table = 'tips';
    protected $fillable = ['title', 'slug', 'content', 'image_id', 'category', 'order_position', 'status', 'created_by'];

    public static function active() {
        return self::where('status', '=', 'active');
    }

    public static function findBySlug($slug) {
        $instance = new static();
        $row = $instance->db->fetch(
            "SELECT * FROM {$instance->table} WHERE slug = ? AND status = 'active' LIMIT 1",
            [$slug]
        );
        if (!$row) {
            return null;
        }
        $item = new static();
        $item->attributes = $row;
        return $item;
    }

    public static function recent($limit = 10) {
        $instance = new static();
        $rows = $instance->db->fetchAll(
            "SELECT * FROM {$instance->table} WHERE status = 'active' ORDER BY order_position ASC, created_at DESC LIMIT ?",
            [$limit]
        );

        $results = [];
        foreach ($rows as $row) {
            $item = new static();
            $item->attributes = $row;
            $results[] = $item;
        }
        return $results;
    }

    public static function byCategory($category) {
        return self::where('category', '=', $category);
    }

    public static function ordered() {
        $instance = new static();
        $rows = $instance->db->fetchAll(
            "SELECT * FROM {$instance->table} ORDER BY order_position ASC"
        );
        
        $results = [];
        foreach ($rows as $row) {
            $item = new static();
            $item->attributes = $row;
            $results[] = $item;
        }
        return $results;
    }
}
