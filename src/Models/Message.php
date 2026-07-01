<?php
namespace App\Models;

/**
 * Message Model (Contact Form Submissions)
 */
class Message extends Model {
    protected $table = 'messages';
    protected $fillable = ['name', 'email', 'phone', 'service', 'message', 'ip_address', 'status', 'response', 'responded_by'];

    public static function unread() {
        return self::where('status', '=', 'unread');
    }

    public static function recent($limit = 10) {
        $instance = new static();
        $rows = $instance->db->fetchAll(
            "SELECT * FROM {$instance->table} ORDER BY created_at DESC LIMIT ?",
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
}
