<?php
namespace App\Controllers\Admin;

use App\Admin\AdminMenu;
use App\Middleware\AuthMiddleware;

/**
 * Base controller for all authenticated admin screens.
 */
abstract class AdminController {
    protected $currentPage = '';
    protected $breadcrumbs = [];
    protected $requiredRole = null;

    public function __construct() {
        if ($this->requiredRole !== null) {
            AuthMiddleware::requireRole($this->requiredRole);
        } else {
            AuthMiddleware::handle();
        }
    }

    protected function render($view, $data = []) {
        $data['title'] = $data['title'] ?? 'Admin Panel';
        $data['currentPage'] = $data['currentPage'] ?? $this->currentPage;
        $data['breadcrumbs'] = $data['breadcrumbs'] ?? $this->breadcrumbs;
        $data['menuGroups'] = AdminMenu::groups($data['currentPage']);

        extract($data);

        require __DIR__ . '/../../Views/admin/layout/header.php';

        $viewPath = __DIR__ . '/../../Views/admin/' . $view . '.php';
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            echo "<div class='admin-alert admin-alert-error'>View not found: " . htmlspecialchars($view) . "</div>";
        }

        require __DIR__ . '/../../Views/admin/layout/footer.php';
    }

    protected function redirect($path, $message = null, $type = 'success') {
        if ($message !== null) {
            $_SESSION[$type === 'error' ? 'error' : 'success'] = $message;
        }
        header('Location: ' . url($path));
        exit;
    }

    protected function requirePost() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/dashboard');
        }
    }

    protected function validateCsrfOrRedirect($redirectPath) {
        if (!validate_csrf($_POST['csrf_token'] ?? '')) {
            $this->redirect($redirectPath, 'Invalid security token.', 'error');
        }
    }
}
