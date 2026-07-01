<?php
namespace App\Auth;

use App\Models\Admin;

/**
 * Authentication Manager
 * Handles admin login, logout, and session management
 */
class AuthManager {
    
    /**
     * Attempt to login admin
     */
    public static function attempt($username, $password) {
        $admin = Admin::authenticate($username, $password);
        
        if ($admin) {
            self::login($admin);
            return true;
        }
        
        return false;
    }

    /**
     * Login admin and store in session
     */
    public static function login($admin) {
        session_regenerate_id(true);

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_email'] = $admin['email'];
        $_SESSION['admin_full_name'] = $admin['full_name'];
        $_SESSION['admin_role'] = $admin['role'];
        $_SESSION['logged_in'] = true;
        $_SESSION['login_time'] = time();
        
        // Update last login
        $db = \App\Database\Database::getInstance();
        $db->update('admins', 
            ['last_login' => date('Y-m-d H:i:s')],
            'id = ?',
            [$admin['id']]
        );
    }

    /**
     * Check if user is authenticated
     */
    public static function check() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    /**
     * Get current logged-in admin
     */
    public static function user() {
        if (self::check()) {
            return [
                'id' => $_SESSION['admin_id'],
                'username' => $_SESSION['admin_username'],
                'email' => $_SESSION['admin_email'],
                'full_name' => $_SESSION['admin_full_name'],
                'role' => $_SESSION['admin_role']
            ];
        }
        return null;
    }

    /**
     * Get current admin ID
     */
    public static function id() {
        return $_SESSION['admin_id'] ?? null;
    }

    /**
     * Check if admin has specific role
     */
    public static function hasRole($role) {
        return self::check() && $_SESSION['admin_role'] === $role;
    }

    /**
     * Logout admin
     */
    public static function logout() {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        return true;
    }

    /**
     * Check session timeout (30 minutes)
     */
    public static function checkSessionTimeout($timeout = 1800) {
        if (self::check() && isset($_SESSION['login_time'])) {
            if (time() - $_SESSION['login_time'] > $timeout) {
                self::logout();
                return false;
            }
            $_SESSION['login_time'] = time(); // Refresh session
            return true;
        }
        return false;
    }
}
