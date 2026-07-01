<?php
namespace App\Controllers;

use App\Auth\AuthManager;
use App\Middleware\AuthMiddleware;
use App\Models\AuditLog;

/**
 * Admin Authentication Controller
 * Handles admin login and logout
 */
class AdminAuthController {
    
    /**
     * Canonical admin entry point.
     */
    public function entry() {
        // Check if admin access is enabled (blocks admin entirely if production admin access disabled)
        $env = getenv('APP_ENV') ?: 'development';
        $adminDisabledInProduction = getenv('ADMIN_DISABLED_IN_PRODUCTION');
        
        if ($env === 'production' && $adminDisabledInProduction !== 'false') {
            http_response_code(403);
            die('Admin access is disabled in production. Contact your system administrator.');
        }
        
        $target = AuthManager::check() ? admin_url('dashboard') : admin_url('login');
        header('Location: ' . $target);
        exit;
    }
    
    protected function render($view, $data = []) {
        extract($data);
        $title = isset($title) ? $title : 'Admin Login | Freddy Investments';
        
        $viewPath = __DIR__ . '/../Views/admin/' . $view . '.php';
        
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            echo "<div class='p-12 text-center text-red-500'>Error: View file [{$view}] not found.</div>";
        }
    }

    /**
     * Show login form
     */
    public function showLogin() {
        AuthMiddleware::checkProductionAccess();

        if (AuthManager::check()) {
            header('Location: ' . admin_url('dashboard'));
            exit;
        }

        $this->render('auth/login', [
            'title' => 'Admin Login | Freddy Investments'
        ]);
    }

    /**
     * Process login
     */
    public function login() {
        AuthMiddleware::checkProductionAccess();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . admin_url('login'));
            exit;
        }

        // Validate CSRF
        $csrfToken = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
        if (!validate_csrf($csrfToken)) {
            $_SESSION['login_error'] = 'Invalid security token. Please try again.';
            header('Location: ' . admin_url('login'));
            exit;
        }

        $username = sanitize($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $_SESSION['login_error'] = 'Username and password are required.';
            header('Location: ' . admin_url('login'));
            exit;
        }

        $rateLimit = $_SESSION['admin_login_rate_limit'] ?? ['count' => 0, 'locked_until' => 0];
        if (time() < ($rateLimit['locked_until'] ?? 0)) {
            $minutesLeft = max(1, (int) ceil(($rateLimit['locked_until'] - time()) / 60));
            $_SESSION['login_error'] = "Too many failed login attempts. Please try again in {$minutesLeft} minute(s).";
            header('Location: ' . admin_url('login'));
            exit;
        }

        if (AuthManager::attempt($username, $password)) {
            unset($_SESSION['admin_login_rate_limit']);
            AuditLog::record('login', 'admin', AuthManager::id());
            $redirect = $_SESSION['redirect_after_login'] ?? admin_url('dashboard');
            unset($_SESSION['redirect_after_login']);
            header('Location: ' . $redirect);
            exit;
        }

        $rateLimit['count'] = ($rateLimit['count'] ?? 0) + 1;
        if ($rateLimit['count'] >= 5) {
            $rateLimit['count'] = 0;
            $rateLimit['locked_until'] = time() + 900;
        }
        $_SESSION['admin_login_rate_limit'] = $rateLimit;

        $_SESSION['login_error'] = 'Invalid username or password.';
        header('Location: ' . admin_url('login'));
        exit;
    }

    /**
     * Logout
     */
    public function logout() {
        AuditLog::record('logout', 'admin', AuthManager::id());
        AuthManager::logout();
        header('Location: ' . admin_url());
        exit;
    }
}
