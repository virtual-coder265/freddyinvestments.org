<?php
namespace App\Models;

/**
 * Project Model
 */
class Project extends Model {
    protected $table = 'projects';
    protected $fillable = [
        'title',
        'slug',
        'category',
        'category_label',
        'description',
        'location',
        'image_id',
        'fallback_image',
        'featured',
        'order_position',
        'status',
        'created_by'
    ];

    public static function active() {
        $instance = new static();
        return $instance->fromRows($instance->db->fetchAll(
            "SELECT * FROM {$instance->table} WHERE status = ? ORDER BY order_position ASC, created_at DESC",
            ['active']
        ));
    }

    public static function ordered() {
        $instance = new static();
        return $instance->fromRows($instance->db->fetchAll(
            "SELECT * FROM {$instance->table} ORDER BY order_position ASC, created_at DESC"
        ));
    }

    public static function featured($limit = 6) {
        $instance = new static();
        return $instance->fromRows($instance->db->fetchAll(
            "SELECT * FROM {$instance->table} WHERE status = ? AND featured = 1 ORDER BY order_position ASC, created_at DESC LIMIT ?",
            ['active', $limit]
        ));
    }

    public static function findBySlug($slug) {
        return self::firstWhere('slug', $slug);
    }

    protected function fromRows($rows) {
        $results = [];
        foreach ($rows as $row) {
            $item = new static();
            $item->attributes = $row;
            $results[] = $item;
        }
        return $results;
    }
}
