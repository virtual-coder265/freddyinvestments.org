<?php
namespace App\Middleware;

use App\Auth\AuthManager;

/**
 * Authentication Middleware
 * Ensures admin is logged in before accessing protected routes
 */
class AuthMiddleware {
    
    /**
     * Check if admin access is enabled (blocks admin entirely if production admin access disabled)
     */
    public static function checkProductionAccess() {
        $env = getenv('APP_ENV') ?: 'development';
        $adminDisabledInProduction = getenv('ADMIN_DISABLED_IN_PRODUCTION');
        
        if ($env === 'production' && $adminDisabledInProduction !== 'false') {
            http_response_code(403);
            die('Admin access is disabled in production. Contact your system administrator.');
        }
    }
    
    /**
     * Check if admin is authenticated
     */
    public static function handle() {
        // Check if admin access is allowed in current environment
        self::checkProductionAccess();
        
        // Check session timeout
        if (AuthManager::check() && !AuthManager::checkSessionTimeout()) {
            $_SESSION['auth_message'] = 'Session expired. Please login again.';
            header('Location: ' . admin_url());
            exit;
        }

        // Check if authenticated
        if (!AuthManager::check()) {
            $_SESSION['auth_message'] = 'Please sign in to access the admin panel.';
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            header('Location: ' . admin_url());
            exit;
        }
    }

    /**
     * Check if user has specific role
     */
    public static function requireRole($role) {
        self::handle();
        
        if (!AuthManager::hasRole($role)) {
            http_response_code(403);
            die('Unauthorized. Required role: ' . $role);
        }
    }
}
