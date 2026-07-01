<?php
/**
 * Admin Browser Test Script
 */
require_once __DIR__ . '/src/bootstrap.php';

$env = getenv('APP_ENV') ?: 'development';
if ($env === 'production') {
    http_response_code(403);
    die('Admin test script is disabled in production.');
}

use App\Models\Admin;
use App\Models\Page;
use App\Models\Service;
use App\Models\Message;
use App\Models\Tip;
use App\Models\Quote;
use App\Models\Asset;

$pass = 0;
$fail = 0;

function test($name, $condition, $detail = '') {
    global $pass, $fail;
    if ($condition) {
        echo "  PASS: $name" . ($detail ? " ($detail)" : '') . PHP_EOL;
        $pass++;
    } else {
        echo "  FAIL: $name" . ($detail ? " ($detail)" : '') . PHP_EOL;
        $fail++;
    }
}

echo PHP_EOL . "=== ADMIN AUTH TESTS ===" . PHP_EOL;

$admin = Admin::firstWhere('username', 'admin');
test("Admin record exists", $admin !== null);


echo PHP_EOL . "=== DATABASE TABLE TESTS ===" . PHP_EOL;

$models = [
    'Pages'    => Page::all(),
    'Services' => Service::all(),
    'Tips'     => Tip::all(),
    'Quotes'   => Quote::all(),
    'Assets'   => Asset::all(),
    'Messages' => Message::all(),
];
foreach ($models as $modelName => $result) {
    test("$modelName table is queryable", is_array($result));
}

echo PHP_EOL . "=== CSRF HELPER TEST ===" . PHP_EOL;
@session_start();
$token1 = csrf_token();
$token2 = csrf_token();
test("CSRF token generated", !empty($token1));
test("CSRF token consistent per session", $token1 === $token2);
test("CSRF token validation works", validate_csrf($token1) === true);
test("Fake CSRF token rejected", validate_csrf('invalid-fake-token-xyz') === false);

echo PHP_EOL . "=== URL HELPER TEST ===" . PHP_EOL;
$base = url();
$adminBase = admin_url();
$adminLogin = url('admin/login');
test("url() returns non-empty string", !empty($base), $base);
test("admin_url() returns admin entry", str_contains($adminBase, 'admin'), $adminBase);
test("url('admin/login') contains path", str_contains($adminLogin, 'admin/login'), $adminLogin);

echo PHP_EOL . "=== VIEW FILES EXIST ===" . PHP_EOL;
$views = [
    'src/Views/admin/auth/login.php',
    'src/Views/admin/dashboard.php',
    'src/Views/admin/layout/header.php',
    'src/Views/admin/layout/footer.php',
    'src/Views/admin/pages/index.php',
    'src/Views/admin/pages/form.php',
    'src/Views/admin/services/index.php',
    'src/Views/admin/tips/index.php',
    'src/Views/admin/quotes/index.php',
    'src/Views/admin/messages/index.php',
    'src/Views/admin/assets/index.php',
    'src/Views/admin/settings/index.php',
];
foreach ($views as $view) {
    test("$view", file_exists(__DIR__ . '/' . $view));
}

echo PHP_EOL . "=== INFRASTRUCTURE ===" . PHP_EOL;
test("Root .htaccess exists", file_exists(__DIR__ . '/.htaccess'));
test("Public .htaccess exists", file_exists(__DIR__ . '/public/.htaccess'));
try {
    $db = \App\Database\Database::getInstance();
    $db->fetch('SELECT 1 AS ok');
    test("MySQL connection works", true, env('DB_DATABASE', 'freddy_investments'));
} catch (\Throwable $e) {
    test("MySQL connection works", false, $e->getMessage());
}
test("Public uploads dir exists", is_dir(__DIR__ . '/public/uploads'));

echo PHP_EOL . "==================================" . PHP_EOL;
echo "RESULTS: {$pass} passed, {$fail} failed" . PHP_EOL;
echo "==================================" . PHP_EOL . PHP_EOL;

if ($fail > 0) {
    exit(1);
}
