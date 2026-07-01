<?php
namespace App\Controllers;

use App\Auth\AuthManager;
use App\Controllers\Admin\AdminController;
use App\Database\Database;
use App\Models\Asset;
use App\Models\AuditLog;
use App\Models\Project;

/**
 * Admin Projects Controller
 */
class AdminProjectsController extends AdminController {
    protected $currentPage = 'projects';

    public function index() {
        $search = sanitize($_GET['q'] ?? '');
        $projects = Project::ordered();

        if ($search !== '') {
            $projects = array_values(array_filter($projects, function ($project) use ($search) {
                $haystack = strtolower(($project['title'] ?? '') . ' ' . ($project['category'] ?? ''));
                return strpos($haystack, strtolower($search)) !== false;
            }));
        }

        $this->render('projects/index', [
            'title' => 'Projects | Admin Panel',
            'projects' => $projects,
            'search' => $search,
            'breadcrumbs' => [
                ['label' => 'Content Library', 'url' => url('admin/projects')],
                ['label' => 'Projects'],
            ],
        ]);
    }

    public function create() {
        $this->render('projects/form', [
            'title' => 'Create Project | Admin Panel',
            'project' => null,
            'assets' => Asset::byType('image'),
            'action' => 'create',
            'currentPage' => 'projects'
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('admin/projects'));
            exit;
        }

        if (!validate_csrf($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Invalid security token.';
            header('Location: ' . url('admin/projects/create'));
            exit;
        }

        $data = $this->validatedProjectData();
        if (!$data) {
            header('Location: ' . url('admin/projects/create'));
            exit;
        }

        $project = Project::create($data + ['created_by' => AuthManager::id()]);
        AuditLog::record('create', 'project', $project ? $project['id'] : null, $data);

        $_SESSION['success'] = 'Project created successfully.';
        header('Location: ' . url('admin/projects'));
        exit;
    }

    public function edit($id) {
        $project = Project::find($id);
        if (!$project) {
            $_SESSION['error'] = 'Project not found.';
            header('Location: ' . url('admin/projects'));
            exit;
        }

        $this->render('projects/form', [
            'title' => 'Edit Project | Admin Panel',
            'project' => $project,
            'assets' => Asset::byType('image'),
            'action' => 'edit',
            'currentPage' => 'projects'
        ]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('admin/projects'));
            exit;
        }

        $project = Project::find($id);
        if (!$project) {
            $_SESSION['error'] = 'Project not found.';
            header('Location: ' . url('admin/projects'));
            exit;
        }

        if (!validate_csrf($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Invalid security token.';
            header('Location: ' . url("admin/projects/{$id}/edit"));
            exit;
        }

        $data = $this->validatedProjectData();
        if (!$data) {
            header('Location: ' . url("admin/projects/{$id}/edit"));
            exit;
        }

        Database::getInstance()->update('projects', $data + ['updated_at' => date('Y-m-d H:i:s')], 'id = ?', [$id]);
        AuditLog::record('update', 'project', $id, $data);

        $_SESSION['success'] = 'Project updated successfully.';
        header('Location: ' . url('admin/projects'));
        exit;
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('admin/projects'));
            exit;
        }

        if (!validate_csrf($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Invalid security token.';
            header('Location: ' . url('admin/projects'));
            exit;
        }

        $project = Project::find($id);
        if (!$project) {
            $_SESSION['error'] = 'Project not found.';
            header('Location: ' . url('admin/projects'));
            exit;
        }

        $project->delete();
        AuditLog::record('delete', 'project', $id);

        $_SESSION['success'] = 'Project deleted successfully.';
        header('Location: ' . url('admin/projects'));
        exit;
    }

    protected function validatedProjectData() {
        $title = sanitize_cms($_POST['title'] ?? '');
        $slug = sanitize_cms($_POST['slug'] ?? '');

        if ($title === '' || $slug === '') {
            $_SESSION['error'] = 'Title and slug are required.';
            return null;
        }

        return [
            'title' => $title,
            'slug' => $slug,
            'category' => sanitize_cms($_POST['category'] ?? ''),
            'category_label' => sanitize_cms($_POST['category_label'] ?? ''),
            'description' => sanitize_cms($_POST['description'] ?? ''),
            'location' => sanitize_cms($_POST['location'] ?? ''),
            'image_id' => !empty($_POST['image_id']) ? (int) $_POST['image_id'] : null,
            'fallback_image' => sanitize_cms($_POST['fallback_image'] ?? ''),
            'featured' => isset($_POST['featured']) ? 1 : 0,
            'order_position' => (int) ($_POST['order_position'] ?? 0),
            'status' => sanitize($_POST['status'] ?? 'active')
        ];
    }
}
