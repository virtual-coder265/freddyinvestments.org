<?php
/**
 * One-time fix: decode HTML entities stored in CMS/content tables.
 * Run: php fix-encoded-content.php
 */
require __DIR__ . '/src/bootstrap.php';

$db = \App\Database\Database::getInstance();
$updated = 0;

$rows = $db->fetchAll('SELECT id, field_value FROM content_sections WHERE field_value LIKE ?', ['%&%']);
foreach ($rows as $row) {
    $fixed = normalize_stored_text($row['field_value']);
    if ($fixed !== $row['field_value']) {
        $db->update('content_sections', ['field_value' => $fixed], 'id = ?', [$row['id']]);
        $updated++;
    }
}

$settings = $db->fetchAll('SELECT id, setting_value FROM business_settings WHERE setting_value LIKE ?', ['%&%']);
foreach ($settings as $row) {
    $fixed = normalize_stored_text($row['setting_value']);
    if ($fixed !== $row['setting_value']) {
        $db->update('business_settings', ['setting_value' => $fixed], 'id = ?', [$row['id']]);
        $updated++;
    }
}

foreach (['services', 'projects', 'quotes', 'tips'] as $table) {
    $textColumns = match ($table) {
        'services' => ['name', 'slug', 'description', 'icon'],
        'projects' => ['title', 'slug', 'category', 'category_label', 'description', 'location', 'fallback_image'],
        'quotes' => ['client_name', 'client_company', 'quote_text'],
        'tips' => ['title', 'slug', 'category'],
        default => [],
    };

    foreach ($textColumns as $column) {
        $rows = $db->fetchAll("SELECT id, {$column} FROM {$table} WHERE {$column} LIKE ?", ['%&%']);
        foreach ($rows as $row) {
            $fixed = normalize_stored_text($row[$column]);
            if ($fixed !== $row[$column]) {
                $db->update($table, [$column => $fixed], 'id = ?', [$row['id']]);
                $updated++;
            }
        }
    }
}

echo "Fixed {$updated} encoded text field(s)." . PHP_EOL;
