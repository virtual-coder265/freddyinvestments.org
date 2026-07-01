<?php
/**
 * Freddy Investments - Application Bootstrap
 */

/**
 * Detect HTTPS including reverse-proxy forwarded protocol.
 */
function is_https_request() {
    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
        return strtolower(trim(explode(',', $_SERVER['HTTP_X_FORWARDED_PROTO'])[0])) === 'https';
    }

    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        return true;
    }

    return !empty($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443;
}

// Secure Session Initialization
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);

    $is_secure = is_https_request();
    ini_set('session.cookie_secure', $is_secure ? 1 : 0);

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => $is_secure,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();
}

// Custom .env Configuration File Parser
class EnvLoader {
    public static function load($dir) {
        $path = $dir . '/.env';
        if (!file_exists($path)) {
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            // Skip comments and empty lines
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }

            // Split into name and value
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);

                // Strip quotes around the value if present
                if (preg_match('/^["\'](.*)["\']$/', $value, $matches)) {
                    $value = $matches[1];
                }

                // Inject into environments
                putenv("{$name}={$value}");
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}

// Load Environment Variables (root folder is parent of src)
EnvLoader::load(dirname(__DIR__));

// Custom PSR-4 Class Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return; // Move to next autoloader if prefix doesn't match
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require_once $file;
    }
});

// Configure Error Reporting based on Environment
$appEnv = env('APP_ENV', 'production');
if ($appEnv === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', dirname(__DIR__) . '/storage/logs/error.log');
}

/**
 * Helper to fetch configuration value from environment
 */
function env($key, $default = null) {
    $value = getenv($key);
    if ($value === false) {
        return $default;
    }
    
    if (strtolower($value) === 'true') return true;
    if (strtolower($value) === 'false') return false;
    if (strtolower($value) === 'null') return null;
    
    return $value;
}

/**
 * Secure CSRF Token Generation and Retrieval
 */
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF Token
 */
function validate_csrf($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Secure Input Sanitization
 */
function sanitize($data) {
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Trim CMS/display text for storage. Escaping happens only at output via e().
 */
function sanitize_cms($data) {
    if (is_array($data)) {
        return array_map('sanitize_cms', $data);
    }
    return is_string($data) ? trim($data) : $data;
}

/**
 * Decode legacy HTML entities stored from earlier double-encoding saves.
 */
function normalize_stored_text($value) {
    if (!is_string($value) || $value === '') {
        return $value;
    }

    $decoded = $value;
    do {
        $value = $decoded;
        $decoded = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    } while ($decoded !== $value);

    return $value;
}

/**
 * Repair HTML entity encoding stored in CMS/content tables.
 * Safe to run multiple times; returns the number of fields updated.
 */
function fix_encoded_content() {
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

    $tables = [
        'services' => ['name', 'slug', 'description', 'icon'],
        'projects' => ['title', 'slug', 'category', 'category_label', 'description', 'location', 'fallback_image'],
        'quotes' => ['client_name', 'client_company', 'quote_text'],
        'tips' => ['title', 'slug', 'category'],
    ];

    foreach ($tables as $table => $textColumns) {
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

    return $updated;
}

/**
 * Allow basic HTML for rich text CMS fields.
 */
function sanitize_html($html) {
    return strip_tags(trim($html), '<p><br><strong><em><b><i><ul><ol><li><a><h2><h3><h4><blockquote>');
}

/**
 * Generate URL-friendly slug from text.
 */
function slugify($text) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text), '-'));
    return $slug !== '' ? $slug : 'item';
}

/**
 * Check if a CMS toggle field is enabled.
 */
function cms_toggle($page, $section, $field, $default = '1') {
    return cms_content($page, $section, $field, $default) === '1';
}

/**
 * Resolve the request scheme, supporting reverse proxy headers.
 */
function request_scheme() {
    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
        return strtolower(trim(explode(',', $_SERVER['HTTP_X_FORWARDED_PROTO'])[0]));
    }

    if (!empty($_SERVER['REQUEST_SCHEME'])) {
        return strtolower($_SERVER['REQUEST_SCHEME']);
    }

    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        return 'https';
    }

    if (!empty($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443) {
        return 'https';
    }

    return 'http';
}

/**
 * Resolve the current request host, supporting reverse proxy headers.
 */
function request_host() {
    if (!empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
        return trim(explode(',', $_SERVER['HTTP_X_FORWARDED_HOST'])[0]);
    }

    if (!empty($_SERVER['HTTP_HOST'])) {
        return $_SERVER['HTTP_HOST'];
    }

    return parse_url(env('APP_URL', 'http://localhost/freddyinvestments.org'), PHP_URL_HOST) ?: 'localhost';
}

/**
 * Normalize a script directory into a URL path segment.
 */
function normalize_url_path($path) {
    $path = str_replace('\\', '/', $path);

    if ($path === '.' || $path === '/') {
        return '';
    }

    return rtrim($path, '/');
}

/**
 * Detect whether the current execution has an HTTP request context.
 */
function has_http_request_context() {
    return !empty($_SERVER['HTTP_HOST']) ||
        !empty($_SERVER['HTTP_X_FORWARDED_HOST']) ||
        isset($_SERVER['REQUEST_URI']);
}

/**
 * Determine the public-facing base path for application routes.
 */
function app_base_path() {
    static $basePath;

    if ($basePath !== null) {
        return $basePath;
    }

    $scriptDir = normalize_url_path(dirname($_SERVER['SCRIPT_NAME'] ?? ''));

    if ($scriptDir !== '' && str_ends_with($scriptDir, '/public')) {
        $basePath = substr($scriptDir, 0, -7);
        return $basePath === false ? '' : $basePath;
    }

    if ($scriptDir !== '') {
        $basePath = $scriptDir;
        return $basePath;
    }

    if (has_http_request_context()) {
        $basePath = '';
        return $basePath;
    }

    $fallbackPath = parse_url(env('APP_URL', 'http://localhost/freddyinvestments.org'), PHP_URL_PATH) ?: '';
    $basePath = normalize_url_path($fallbackPath);
    return $basePath;
}

/**
 * Determine the public directory base path for static assets and uploads.
 */
function public_base_path() {
    static $publicPath;

    if ($publicPath !== null) {
        return $publicPath;
    }

    $scriptDir = normalize_url_path(dirname($_SERVER['SCRIPT_NAME'] ?? ''));

    if ($scriptDir !== '') {
        $publicPath = $scriptDir;
        return $publicPath;
    }

    if (has_http_request_context()) {
        $publicPath = '';
        return $publicPath;
    }

    $fallbackPath = parse_url(env('APP_URL', 'http://localhost/freddyinvestments.org'), PHP_URL_PATH) ?: '';
    $publicPath = normalize_url_path($fallbackPath);
    return $publicPath;
}

/**
 * Join a path onto a base URL without duplicating slashes.
 */
function build_url($baseUrl, $path = '') {
    $baseUrl = rtrim($baseUrl, '/');

    if ($path === '' || $path === null) {
        return $baseUrl . '/';
    }

    return $baseUrl . '/' . ltrim($path, '/');
}

/**
 * Build the request origin with scheme and host, or fall back to APP_URL for CLI usage.
 */
function request_origin() {
    if (!empty($_SERVER['HTTP_HOST']) || !empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
        return request_scheme() . '://' . request_host();
    }

    $fallbackUrl = rtrim(env('APP_URL', 'http://localhost/freddyinvestments.org'), '/');
    $parts = parse_url($fallbackUrl);

    if (!is_array($parts) || empty($parts['scheme']) || empty($parts['host'])) {
        return 'http://localhost';
    }

    $origin = $parts['scheme'] . '://' . $parts['host'];

    if (!empty($parts['port'])) {
        $origin .= ':' . $parts['port'];
    }

    return $origin;
}

/**
 * URL helper for application routes.
 */
function url($path = '') {
    return build_url(request_origin() . app_base_path(), $path);
}

/**
 * URL helper for the admin entry point and nested admin routes.
 */
function admin_url($path = '') {
    $adminPath = 'admin';

    if ($path !== '' && $path !== null) {
        $adminPath .= '/' . ltrim($path, '/');
    }

    return url($adminPath);
}

/**
 * URL helper for bundled public assets.
 */
function asset_url($path = '') {
    $normalizedPath = ltrim($path, '/');
    $assetUrl = build_url(request_origin() . public_base_path(), 'assets/' . $normalizedPath);
    $assetFile = dirname(__DIR__) . '/public/assets/' . str_replace('/', DIRECTORY_SEPARATOR, $normalizedPath);

    if (is_file($assetFile)) {
        $assetUrl .= '?v=' . filemtime($assetFile);
    }

    return $assetUrl;
}

/**
 * URL helper for uploaded media and any public file path stored by the CMS.
 */
function media_url($path = '') {
    if ($path === '' || $path === null) {
        return build_url(request_origin() . public_base_path());
    }

    if (preg_match('#^(?:[a-z][a-z0-9+.-]*:)?//#i', $path) || str_starts_with($path, 'data:')) {
        return $path;
    }

    return build_url(request_origin() . public_base_path(), $path);
}

/**
 * Escape output safely in templates.
 */
function e($value) {
    return htmlspecialchars(normalize_stored_text((string) $value), ENT_QUOTES, 'UTF-8');
}

/**
 * Fetch a business setting with a fallback.
 */
function cms_setting($key, $default = '') {
    try {
        return \App\Models\BusinessSetting::get($key, $default);
    } catch (\Throwable $e) {
        return $default;
    }
}

/**
 * Fetch section content with a fallback.
 */
function cms_content($page, $section, $field, $default = '') {
    try {
        return \App\Models\ContentSection::get($page, $section, $field, $default);
    } catch (\Throwable $e) {
        return $default;
    }
}

/**
 * Fetch a CMS-managed section image with a bundled image fallback.
 */
function cms_content_image($page, $section, $field, $fallbackImage = '') {
    $assetId = cms_content($page, $section, $field, '');
    return cms_image_url($assetId, $fallbackImage);
}

/**
 * Convert a CMS asset id or bundled fallback image into a public URL.
 */
function cms_image_url($imageId = null, $fallbackImage = '') {
    if (!empty($imageId)) {
        try {
            $asset = \App\Models\Asset::find($imageId);
            if ($asset && !empty($asset['filepath'])) {
                return media_url($asset['filepath']);
            }
        } catch (\Throwable $e) {
            // Fall through to bundled image fallback.
        }
    }

    if ($fallbackImage === '') {
        return '';
    }

    return str_starts_with($fallbackImage, '/') ? media_url($fallbackImage) : asset_url('images/' . $fallbackImage);
}

function phone_href($phone) {
    return 'tel:' . preg_replace('/[^0-9+]/', '', (string) $phone);
}
