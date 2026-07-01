<?php
/**
 * One-time migration: copy data from legacy SQLite file into MySQL.
 *
 * Usage:
 *   php migrate-sqlite-to-mysql.php
 *
 * Prerequisites:
 *   - MySQL credentials configured in .env
 *   - storage/database.sqlite exists with data to migrate
 *   - Run setup-database.php first (or this script will create tables)
 */

require_once __DIR__ . '/src/bootstrap.php';

use App\Database\Database;
use App\Database\DatabaseInitializer;

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    die('Run this script from the command line: php migrate-sqlite-to-mysql.php');
}

$sqlitePath = __DIR__ . '/storage/database.sqlite';
if (!file_exists($sqlitePath)) {
    fwrite(STDERR, "No SQLite file found at {$sqlitePath}\n");
    exit(1);
}

$tables = [
    'audit_logs',
    'content_sections',
    'messages',
    'quotes',
    'tips',
    'projects',
    'services',
    'assets',
    'pages',
    'business_settings',
    'admins',
];

echo "Migrating SQLite data to MySQL..." . PHP_EOL;

try {
    Database::ensureDatabaseExists();
    Database::resetInstance();

    $mysql = Database::getInstance()->getConnection();
    $mysql->exec('SET FOREIGN_KEY_CHECKS = 0');
    foreach ($tables as $table) {
        $mysql->exec("DROP TABLE IF EXISTS `{$table}`");
    }
    $mysql->exec('SET FOREIGN_KEY_CHECKS = 1');
    Database::resetInstance();

    $initializer = new DatabaseInitializer();
    $initializer->initialize();
    $initializer->migrate();

    $mysql = Database::getInstance()->getConnection();
    $sqlite = new PDO('sqlite:' . $sqlitePath);
    $sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlite->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $mysql->exec('SET FOREIGN_KEY_CHECKS = 0');

    $importOrder = [
        'admins',
        'assets',
        'pages',
        'services',
        'projects',
        'tips',
        'quotes',
        'messages',
        'business_settings',
        'content_sections',
        'audit_logs',
    ];

    foreach ($importOrder as $table) {
        $sqliteTables = $sqlite->query(
            "SELECT name FROM sqlite_master WHERE type='table' AND name=" . $sqlite->quote($table)
        )->fetchAll(PDO::FETCH_COLUMN);

        if (empty($sqliteTables)) {
            echo "  skip {$table} (not in SQLite)" . PHP_EOL;
            continue;
        }

        $rows = $sqlite->query("SELECT * FROM {$table}")->fetchAll();
        if (empty($rows)) {
            echo "  skip {$table} (empty)" . PHP_EOL;
            continue;
        }

        $mysql->exec("TRUNCATE TABLE {$table}");
        $columns = array_keys($rows[0]);
        $columnList = implode(', ', $columns);
        $placeholders = implode(', ', array_fill(0, count($columns), '?'));
        $insertSql = "INSERT INTO {$table} ({$columnList}) VALUES ({$placeholders})";
        $stmt = $mysql->prepare($insertSql);

        foreach ($rows as $row) {
            $stmt->execute(array_values($row));
        }

        echo "  migrated {$table}: " . count($rows) . " row(s)" . PHP_EOL;
    }

    $mysql->exec('SET FOREIGN_KEY_CHECKS = 1');

    echo PHP_EOL . "Migration completed successfully." . PHP_EOL;
    echo "Verify the site, then archive or delete storage/database.sqlite." . PHP_EOL;
} catch (Throwable $e) {
    fwrite(STDERR, 'Migration failed: ' . $e->getMessage() . PHP_EOL);
    exit(1);
}
