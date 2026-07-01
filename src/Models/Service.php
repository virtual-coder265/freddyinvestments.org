<?php
namespace App\Models;

/**
 * Service Model
 */
class Service extends Model {
    protected $table = 'services';
    protected $fillable = ['name', 'slug', 'description', 'icon', 'image_id', 'order_position', 'status', 'created_by'];

    public static function active() {
        return self::where('status', '=', 'active');
    }

    public static function findBySlug($slug) {
        return self::firstWhere('slug', $slug);
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
