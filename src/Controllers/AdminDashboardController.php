<?php
namespace App\Controllers;

use App\Controllers\Admin\AdminController;
use App\Models\AuditLog;
use App\Models\Message;
use App\Models\Project;
use App\Models\Service;
use App\Models\Tip;
use App\Database\Database;

/**
 * Admin Dashboard Controller
 */
class AdminDashboardController extends AdminController {
    protected $currentPage = 'dashboard';

    public function index() {
        $recentActivity = [];
        try {
            $recentActivity = Database::getInstance()->fetchAll(
                'SELECT a.*, ad.full_name, ad.username FROM audit_logs a LEFT JOIN admins ad ON ad.id = a.admin_id ORDER BY a.created_at DESC LIMIT 8'
            );
        } catch (\Throwable $e) {
            $recentActivity = [];
        }

        $this->render('dashboard', [
            'title' => 'Dashboard | Admin Panel',
            'unread_messages' => $this->safeCount(fn() => Message::count("status = ?", ['unread'])),
            'total_services' => $this->safeCount(fn() => Service::count()),
            'total_projects' => $this->safeCount(fn() => Project::count()),
            'total_tips' => $this->safeCount(fn() => Tip::count()),
            'recent_messages' => $this->safeList(fn() => Message::recent(5)),
            'recent_activity' => $recentActivity,
        ]);
    }

    protected function safeCount(callable $fn) {
        try {
            return $fn();
        } catch (\Throwable $e) {
            return 0;
        }
    }

    protected function safeList(callable $fn) {
        try {
            return $fn();
        } catch (\Throwable $e) {
            return [];
        }
    }
}
