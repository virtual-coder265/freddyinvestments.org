<?php
namespace App\Models;

/**
 * Admin Model
 */
class Admin extends Model {
    protected $table = 'admins';
    protected $fillable = ['username', 'email', 'password_hash', 'full_name', 'role', 'status'];

    public static function authenticate($identity, $password) {
        $admin = filter_var($identity, FILTER_VALIDATE_EMAIL)
            ? self::firstWhere('email', $identity)
            : self::firstWhere('username', $identity);

        if ($admin && $admin['status'] === 'active' && password_verify($password, $admin['password_hash'])) {
            return $admin;
        }
        return null;
    }

    public static function authenticateByEmail($email, $password) {
        return self::authenticate($email, $password);
    }
}
