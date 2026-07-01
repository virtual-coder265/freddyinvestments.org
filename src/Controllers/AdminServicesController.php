<?php
namespace App\Controllers;

use App\Controllers\Admin\AdminController;
use App\Models\Asset;
use App\Models\AuditLog;
use App\Models\Service;

/**
 * Admin Services Controller
 */
class AdminServicesController extends AdminController {
    protected $currentPage = 'services';

    public function index() {
        $search = sanitize($_GET['q'] ?? '');
        $status = sanitize($_GET['status'] ?? '');
        $services = Service::ordered();

        if ($search !== '' || $status !== '') {
            $services = array_values(array_filter($services, function ($service) use ($search, $status) {
                if ($status !== '' && ($service['status'] ?? '') !== $status) {
                    return false;
                }
                if ($search === '') {
                    return true;
                }
                $haystack = strtolower(($service['name'] ?? '') . ' ' . ($service['slug'] ?? ''));
                return strpos($haystack, strtolower($search)) !== false;
            }));
        }
        
        $this->render('services/index', [
            'title' => 'Services | Admin Panel',
            'services' => $services,
            'search' => $search,
            'statusFilter' => $status,
            'breadcrumbs' => [
                ['label' => 'Content Library', 'url' => url('admin/services')],
                ['label' => 'Services'],
            ],
        ]);
    }

    /**
     * Show create form
     */
    public function create() {
        $this->render('services/form', [
            'title' => 'Create Service | Admin Panel',
            'service' => null,
            'assets' => Asset::byType('image'),
            'action' => 'create',
            'currentPage' => 'services'
        ]);
    }

    /**
     * Store new service
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('admin/services'));
            exit;
        }

        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!validate_csrf($csrfToken)) {
            $_SESSION['error'] = 'Invalid security token.';
            header('Location: ' . url('admin/services/create'));
            exit;
        }

        $name = sanitize_cms($_POST['name'] ?? '');
        $slug = sanitize_cms($_POST['slug'] ?? '');
        $description = sanitize_cms($_POST['description'] ?? '');
        $icon = sanitize_cms($_POST['icon'] ?? '');
        $imageId = !empty($_POST['image_id']) ? (int) $_POST['image_id'] : null;
        $orderPosition = (int) ($_POST['order_position'] ?? 0);
        $status = sanitize($_POST['status'] ?? 'active');

        if (empty($name) || empty($slug)) {
            $_SESSION['error'] = 'Name and slug are required.';
            header('Location: ' . url('admin/services/create'));
            exit;
        }

        Service::create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'icon' => $icon,
            'image_id' => $imageId,
            'order_position' => $orderPosition,
            'status' => $status,
            'created_by' => \App\Auth\AuthManager::id()
        ]);

        AuditLog::record('create', 'service', null, ['slug' => $slug]);
        $_SESSION['success'] = 'Service created successfully.';
        header('Location: ' . url('admin/services'));
        exit;
    }

    /**
     * Edit service
     */
    public function edit($id) {
        $service = Service::find($id);
        if (!$service) {
            $_SESSION['error'] = 'Service not found.';
            header('Location: ' . url('admin/services'));
            exit;
        }

        $this->render('services/form', [
            'title' => 'Edit Service | Admin Panel',
            'service' => $service,
            'assets' => Asset::byType('image'),
            'action' => 'edit',
            'currentPage' => 'services'
        ]);
    }

    /**
     * Update service
     */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('admin/services'));
            exit;
        }

        $service = Service::find($id);
        if (!$service) {
            $_SESSION['error'] = 'Service not found.';
            header('Location: ' . url('admin/services'));
            exit;
        }

        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!validate_csrf($csrfToken)) {
            $_SESSION['error'] = 'Invalid security token.';
            header('Location: ' . url("admin/services/{$id}/edit"));
            exit;
        }

        $name = sanitize_cms($_POST['name'] ?? '');
        $slug = sanitize_cms($_POST['slug'] ?? '');
        $description = sanitize_cms($_POST['description'] ?? '');
        $icon = sanitize_cms($_POST['icon'] ?? '');
        $imageId = !empty($_POST['image_id']) ? (int) $_POST['image_id'] : null;
        $orderPosition = (int) ($_POST['order_position'] ?? 0);
        $status = sanitize($_POST['status'] ?? 'active');

        \App\Database\Database::getInstance()->update(
            'services',
            [
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'icon' => $icon,
                'image_id' => $imageId,
                'order_position' => $orderPosition,
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ],
            'id = ?',
            [$id]
        );

        AuditLog::record('update', 'service', $id, ['slug' => $slug]);
        $_SESSION['success'] = 'Service updated successfully.';
        header('Location: ' . url('admin/services'));
        exit;
    }

    /**
     * Delete service
     */
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('admin/services'));
            exit;
        }

        $service = Service::find($id);
        if (!$service) {
            $_SESSION['error'] = 'Service not found.';
            header('Location: ' . url('admin/services'));
            exit;
        }

        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!validate_csrf($csrfToken)) {
            $_SESSION['error'] = 'Invalid security token.';
            header('Location: ' . url('admin/services'));
            exit;
        }

        $service->delete();
        AuditLog::record('delete', 'service', $id);
        $_SESSION['success'] = 'Service deleted successfully.';
        header('Location: ' . url('admin/services'));
        exit;
    }
}
