<?php
namespace App\Models;

use App\Database\Database;

/**
 * Section-based content snippets used by public views.
 */
class ContentSection extends Model {
    protected $table = 'content_sections';
    protected $fillable = [
        'page_key',
        'section_key',
        'field_key',
        'field_value',
        'field_type',
        'label',
        'updated_by'
    ];

    public static function get($page, $section, $field, $default = '') {
        $instance = new static();
        $row = $instance->db->fetch(
            "SELECT field_value FROM {$instance->table} WHERE page_key = ? AND section_key = ? AND field_key = ?",
            [$page, $section, $field]
        );

        if (!$row || $row['field_value'] === null || $row['field_value'] === '') {
            return $default;
        }

        return normalize_stored_text($row['field_value']);
    }

    public static function setValue($page, $section, $field, $value, $type = 'text', $label = null, $adminId = null) {
        $existing = (new static())->db->fetch(
            "SELECT id FROM content_sections WHERE page_key = ? AND section_key = ? AND field_key = ?",
            [$page, $section, $field]
        );

        $data = [
            'field_value' => $value,
            'field_type' => $type,
            'label' => $label ?: ucwords(str_replace('_', ' ', $field)),
            'updated_by' => $adminId,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $db = Database::getInstance();
        if ($existing) {
            $db->update('content_sections', $data, 'id = ?', [$existing['id']]);
            return;
        }

        $data['page_key'] = $page;
        $data['section_key'] = $section;
        $data['field_key'] = $field;
        $data['created_at'] = date('Y-m-d H:i:s');
        $db->insert('content_sections', $data);
    }

    public static function grouped() {
        $instance = new static();
        $rows = $instance->db->fetchAll(
            "SELECT * FROM {$instance->table} ORDER BY page_key ASC, section_key ASC, field_key ASC"
        );

        $grouped = [];
        foreach ($rows as $row) {
            $grouped[$row['page_key']][$row['section_key']][$row['field_key']] = $row;
        }
        return $grouped;
    }
}
