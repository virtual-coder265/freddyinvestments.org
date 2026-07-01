<?php
namespace App\Models;

/**
 * Audit log entries for admin actions.
 */
class AuditLog extends Model {
    protected $table = 'audit_logs';
    protected $fillable = ['admin_id', 'action', 'entity_type', 'entity_id', 'changes', 'ip_address', 'user_agent'];

    public static function record($action, $entityType = null, $entityId = null, $changes = null) {
        try {
            return self::create([
                'admin_id' => \App\Auth\AuthManager::id(),
                'action' => $action,
                'entity_type' => $entityType,
                'entity_id' => $entityId,
                'changes' => is_array($changes) ? json_encode($changes, JSON_UNESCAPED_SLASHES) : $changes,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null
            ]);
        } catch (\Exception $e) {
            error_log('Audit log failed: ' . $e->getMessage());
            return null;
        }
    }
}
