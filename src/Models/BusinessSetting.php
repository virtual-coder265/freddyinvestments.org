<?php
namespace App\Models;

use App\Database\Database;

/**
 * BusinessSetting Model
 */
class BusinessSetting extends Model {
    protected $table = 'business_settings';
    protected $fillable = ['setting_key', 'setting_value', 'setting_type', 'description'];

    public static function get($key, $default = null) {
        $setting = self::firstWhere('setting_key', $key);
        return $setting ? normalize_stored_text($setting['setting_value']) : $default;
    }

    public static function set($key, $value) {
        $existing = self::firstWhere('setting_key', $key);
        
        if ($existing) {
            $db = Database::getInstance();
            $db->update('business_settings', 
                ['setting_value' => $value, 'updated_at' => date('Y-m-d H:i:s')],
                'setting_key = ?',
                [$key]
            );
        } else {
            self::create(['setting_key' => $key, 'setting_value' => $value]);
        }
    }

    public static function all() {
        $instance = new static();
        $results = $instance->db->fetchAll("SELECT * FROM {$instance->table}");
        
        $settings = [];
        foreach ($results as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }
}
