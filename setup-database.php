<?php
/**
 * Database Setup Script
 * Run this once to initialize the database with tables and default admin user
 * 
 * Usage:
 * Via command line: php setup-database.php
 * Via browser: http://localhost/freddyinvestments.org/setup-database.php
 */

// Bootstrap the application
require_once __DIR__ . '/src/bootstrap.php';

$env = getenv('APP_ENV') ?: 'development';
if ($env === 'production') {
    http_response_code(403);
    die('Setup script is disabled in production.');
}

use App\Database\Database;
use App\Database\DatabaseInitializer;
use App\Models\Admin;

// Only allow from localhost or CLI
$allowedIP = ['127.0.0.1', '::1'];
$isLocalhost = in_array($_SERVER['REMOTE_ADDR'] ?? '', $allowedIP) || php_sapi_name() === 'cli';

if (!$isLocalhost) {
    die('Access Denied. This script can only be run from localhost.');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freddy Investments - Database Setup</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl p-8 max-w-md w-full">
        <h1 class="text-3xl font-bold text-slate-900 mb-2">Database Setup</h1>
        <p class="text-slate-600 mb-6">Freddy Investments Admin CMS</p>

        <?php
        try {
            // Ensure MySQL database exists (local development helper)
            echo '<div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">';
            echo '<p class="text-blue-700 mb-2"><strong>Preparing MySQL Database...</strong></p>';
            Database::ensureDatabaseExists();
            Database::resetInstance();
            echo '<p class="text-emerald-700 text-sm">✓ Database `' . htmlspecialchars(env('DB_DATABASE', 'freddy_investments')) . '` is ready</p>';
            echo '</div>';

            // Initialize database
            echo '<div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">';
            echo '<p class="text-blue-700 mb-2"><strong>Initializing Database...</strong></p>';
            
            $initializer = new DatabaseInitializer();
            $initializer->initialize();
            
            echo '<p class="text-emerald-700 text-sm">✓ Database tables created successfully</p>';
            echo '</div>';

            // Create default admin user
            echo '<div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">';
            echo '<p class="text-blue-700 mb-2"><strong>Creating Default Admin User...</strong></p>';
            
            // Check if admin already exists
            $existingAdmin = Admin::firstWhere('username', 'admin');
            
            if ($existingAdmin) {
                echo '<p class="text-yellow-700 text-sm">⚠ Admin user already exists. Skipping.</p>';
            } else {
                $initialPassword = env('ADMIN_INITIAL_PASSWORD', '');
                if ($initialPassword === '') {
                    $initialPassword = bin2hex(random_bytes(12));
                }

                Admin::create([
                    'username' => 'admin',
                    'email' => 'admin@freddyinvestments.org',
                    'password_hash' => password_hash($initialPassword, PASSWORD_BCRYPT),
                    'full_name' => 'Administrator',
                    'role' => 'admin',
                    'status' => 'active'
                ]);
                echo '<p class="text-emerald-700 text-sm">✓ Default admin user created</p>';
                echo '<p class="text-slate-700 text-sm mt-2"><strong>Username:</strong> admin</p>';
                echo '<p class="text-slate-700 text-sm"><strong>Initial password:</strong> ' . htmlspecialchars($initialPassword) . '</p>';
            }
            
            echo '</div>';

            // Success message
            echo '<div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-lg">';
            echo '<p class="text-emerald-700 font-semibold mb-2">✓ Setup Completed Successfully!</p>';
            echo '<p class="text-emerald-600 text-sm">Database is ready for use.</p>';
            echo '</div>';

            echo '<div class="bg-amber-50 rounded-lg p-4 mb-6 border border-amber-200">';
            echo '<p class="text-sm font-semibold text-amber-900 mb-2">⚠️ IMPORTANT - Security Notice:</p>';
            echo '<p class="text-sm text-amber-800 mb-3">A default admin account has been created. However, <strong>you must use your own secure credentials</strong> to ensure production security.</p>';
            echo '<p class="text-xs text-amber-700">The default credentials are only for initial database setup and should never be used in production. Set your custom admin username and password immediately.</p>';
            echo '</div>';

            echo '<div class="space-y-2">';
            echo '<a href="' . url('admin/login') . '" class="block w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 rounded-lg transition">';
            echo 'Go to Admin Login';
            echo '</a>';
            echo '<a href="' . url('/') . '" class="block w-full text-center bg-slate-300 hover:bg-slate-400 text-slate-900 font-semibold py-2 rounded-lg transition">';
            echo 'Go to Website';
            echo '</a>';
            echo '</div>';

            echo '<div class="mt-6 pt-6 border-t border-slate-200 text-xs text-slate-600">';
            echo '<p><strong>Important:</strong> Delete or secure this setup file after using it.</p>';
            echo '<p class="mt-2">Change the default admin password immediately for security.</p>';
            echo '</div>';

        } catch (\Exception $e) {
            echo '<div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">';
            echo '<p class="text-red-700 font-semibold mb-2">Error During Setup</p>';
            echo '<p class="text-red-600 text-sm">' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '</div>';
        }
        ?>
    </div>
</div>
</body>
</html>
