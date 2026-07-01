<?php
/**
 * CLI helper — run locally: php fix-encoded-content.php
 * On shared hosting, use Admin → Settings → Maintenance instead.
 */
require __DIR__ . '/src/bootstrap.php';

echo 'Fixed ' . fix_encoded_content() . " encoded text field(s)." . PHP_EOL;
