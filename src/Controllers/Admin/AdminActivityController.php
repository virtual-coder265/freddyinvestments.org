<?php
namespace App\Controllers\Admin;

use App\Database\Database;

/**
 * Admin activity / audit log viewer.
 */
class AdminActivityController extends AdminController {
    protected $currentPage = 'activity';
    protected $requiredRole = 'admin';

    public function index() {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 25;
        $offset = ($page - 1) * $perPage;

        $action = sanitize($_GET['action'] ?? '');
        $entity = sanitize($_GET['entity'] ?? '');

        $where = '1=1';
        $params = [];

        if ($action !== '') {
            $where .= ' AND a.action = ?';
            $params[] = $action;
        }
        if ($entity !== '') {
            $where .= ' AND a.entity_type = ?';
            $params[] = $entity;
        }

        $db = Database::getInstance();
        $total = (int) $db->fetch(
            "SELECT COUNT(*) as count FROM audit_logs a WHERE {$where}",
            $params
        )['count'];

        $logs = $db->fetchAll(
            "SELECT a.*, ad.username, ad.full_name
             FROM audit_logs a
             LEFT JOIN admins ad ON ad.id = a.admin_id
             WHERE {$where}
             ORDER BY a.created_at DESC
             LIMIT ? OFFSET ?",
            array_merge($params, [$perPage, $offset])
        );

        $this->render('activity/index', [
            'title' => 'Activity Log | Admin Panel',
            'logs' => $logs,
            'page' => $page,
            'totalPages' => max(1, (int) ceil($total / $perPage)),
            'actionFilter' => $action,
            'entityFilter' => $entity,
            'breadcrumbs' => [
                ['label' => 'Settings & Tools', 'url' => url('admin/settings')],
                ['label' => 'Activity Log'],
            ],
        ]);
    }
}
