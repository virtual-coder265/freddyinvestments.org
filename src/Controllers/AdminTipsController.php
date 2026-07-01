<?php
namespace App\Controllers;

use App\Controllers\Admin\AdminController;
use App\Models\Asset;
use App\Models\AuditLog;
use App\Models\Tip;

/**
 * Admin Tips Controller
 */
class AdminTipsController extends AdminController {
    protected $currentPage = 'tips';

    public function index() {
        $category = sanitize($_GET['category'] ?? '');
        $tips = Tip::ordered();

        if ($category !== '') {
            $tips = array_values(array_filter($tips, function ($tip) use ($category) {
                return ($tip['category'] ?? '') === $category;
            }));
        }
        
        $this->render('tips/index', [
            'title' => 'Tips & Blog | Admin Panel',
            'tips' => $tips,
            'categoryFilter' => $category,
            'breadcrumbs' => [
                ['label' => 'Content Library', 'url' => url('admin/tips')],
                ['label' => 'Tips & Blog'],
            ],
        ]);
    }

    public function create() {
        $this->render('tips/form', [
            'title' => 'Create Tip | Admin Panel',
            'tip' => null,
            'assets' => Asset::byType('image'),
            'action' => 'create',
            'currentPage' => 'tips'
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('admin/tips'));
            exit;
        }

        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!validate_csrf($csrfToken)) {
            $_SESSION['error'] = 'Invalid security token.';
            header('Location: ' . url('admin/tips/create'));
            exit;
        }

        $title = sanitize_cms($_POST['title'] ?? '');
        $content = sanitize_html($_POST['content'] ?? '');
        $slug = sanitize_cms($_POST['slug'] ?? slugify($title));
        $imageId = !empty($_POST['image_id']) ? (int) $_POST['image_id'] : null;
        $category = sanitize_cms($_POST['category'] ?? '');
        $orderPosition = (int) ($_POST['order_position'] ?? 0);
        $status = sanitize($_POST['status'] ?? 'active');

        if (empty($title)) {
            $_SESSION['error'] = 'Title is required.';
            header('Location: ' . url('admin/tips/create'));
            exit;
        }

        Tip::create([
            'title' => $title,
            'slug' => $slug ?: slugify($title),
            'content' => $content,
            'image_id' => $imageId,
            'category' => $category,
            'order_position' => $orderPosition,
            'status' => $status,
            'created_by' => \App\Auth\AuthManager::id()
        ]);

        AuditLog::record('create', 'tip', null, ['title' => $title]);
        $_SESSION['success'] = 'Tip created successfully.';
        header('Location: ' . url('admin/tips'));
        exit;
    }

    public function edit($id) {
        $tip = Tip::find($id);
        if (!$tip) {
            $_SESSION['error'] = 'Tip not found.';
            header('Location: ' . url('admin/tips'));
            exit;
        }

        $this->render('tips/form', [
            'title' => 'Edit Tip | Admin Panel',
            'tip' => $tip,
            'assets' => Asset::byType('image'),
            'action' => 'edit',
            'currentPage' => 'tips'
        ]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('admin/tips'));
            exit;
        }

        $tip = Tip::find($id);
        if (!$tip) {
            $_SESSION['error'] = 'Tip not found.';
            header('Location: ' . url('admin/tips'));
            exit;
        }

        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!validate_csrf($csrfToken)) {
            $_SESSION['error'] = 'Invalid security token.';
            header('Location: ' . url("admin/tips/{$id}/edit"));
            exit;
        }

        $title = sanitize_cms($_POST['title'] ?? '');
        $content = sanitize_html($_POST['content'] ?? '');
        $slug = sanitize_cms($_POST['slug'] ?? slugify($title));
        $imageId = !empty($_POST['image_id']) ? (int) $_POST['image_id'] : null;
        $category = sanitize_cms($_POST['category'] ?? '');
        $orderPosition = (int) ($_POST['order_position'] ?? 0);
        $status = sanitize($_POST['status'] ?? 'active');

        \App\Database\Database::getInstance()->update(
            'tips',
            [
                'title' => $title,
                'slug' => $slug ?: slugify($title),
                'content' => $content,
                'image_id' => $imageId,
                'category' => $category,
                'order_position' => $orderPosition,
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ],
            'id = ?',
            [$id]
        );

        AuditLog::record('update', 'tip', $id, ['title' => $title]);
        $_SESSION['success'] = 'Tip updated successfully.';
        header('Location: ' . url('admin/tips'));
        exit;
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('admin/tips'));
            exit;
        }

        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!validate_csrf($csrfToken)) {
            $_SESSION['error'] = 'Invalid security token.';
            header('Location: ' . url('admin/tips'));
            exit;
        }

        $tip = Tip::find($id);
        if (!$tip) {
            $_SESSION['error'] = 'Tip not found.';
            header('Location: ' . url('admin/tips'));
            exit;
        }

        $tip->delete();
        AuditLog::record('delete', 'tip', $id);
        $_SESSION['success'] = 'Tip deleted successfully.';
        header('Location: ' . url('admin/tips'));
        exit;
    }
}
