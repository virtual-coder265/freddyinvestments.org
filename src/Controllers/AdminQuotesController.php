<?php
namespace App\Controllers;

use App\Controllers\Admin\AdminController;
use App\Models\Asset;
use App\Models\AuditLog;
use App\Models\Quote;

/**
 * Admin Quotes / Testimonials Controller
 */
class AdminQuotesController extends AdminController {
    protected $currentPage = 'quotes';

    public function index() {
        $quotes = Quote::all();
        
        $this->render('quotes/index', [
            'title' => 'Testimonials | Admin Panel',
            'quotes' => $quotes,
            'breadcrumbs' => [
                ['label' => 'Content Library', 'url' => url('admin/quotes')],
                ['label' => 'Testimonials'],
            ],
        ]);
    }

    public function create() {
        $this->render('quotes/form', [
            'title' => 'Create Quote | Admin Panel',
            'quote' => null,
            'assets' => Asset::byType('image'),
            'action' => 'create',
            'currentPage' => 'quotes'
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('admin/quotes'));
            exit;
        }

        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!validate_csrf($csrfToken)) {
            $_SESSION['error'] = 'Invalid security token.';
            header('Location: ' . url('admin/quotes/create'));
            exit;
        }

        $client_name = sanitize_cms($_POST['client_name'] ?? '');
        $client_company = sanitize_cms($_POST['client_company'] ?? '');
        $quote_text = sanitize_cms($_POST['quote_text'] ?? '');
        $rating = intval($_POST['rating'] ?? 5);
        $imageId = !empty($_POST['image_id']) ? (int) $_POST['image_id'] : null;
        $status = sanitize($_POST['status'] ?? 'active');

        if (empty($client_name) || empty($quote_text)) {
            $_SESSION['error'] = 'Client name and quote text are required.';
            header('Location: ' . url('admin/quotes/create'));
            exit;
        }

        Quote::create([
            'client_name' => $client_name,
            'client_company' => $client_company,
            'quote_text' => $quote_text,
            'rating' => $rating,
            'image_id' => $imageId,
            'status' => $status,
            'created_by' => \App\Auth\AuthManager::id()
        ]);

        AuditLog::record('create', 'quote', null, ['client_name' => $client_name]);
        $_SESSION['success'] = 'Quote created successfully.';
        header('Location: ' . url('admin/quotes'));
        exit;
    }

    public function edit($id) {
        $quote = Quote::find($id);
        if (!$quote) {
            $_SESSION['error'] = 'Quote not found.';
            header('Location: ' . url('admin/quotes'));
            exit;
        }

        $this->render('quotes/form', [
            'title' => 'Edit Quote | Admin Panel',
            'quote' => $quote,
            'assets' => Asset::byType('image'),
            'action' => 'edit',
            'currentPage' => 'quotes'
        ]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('admin/quotes'));
            exit;
        }

        $quote = Quote::find($id);
        if (!$quote) {
            $_SESSION['error'] = 'Quote not found.';
            header('Location: ' . url('admin/quotes'));
            exit;
        }

        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!validate_csrf($csrfToken)) {
            $_SESSION['error'] = 'Invalid security token.';
            header('Location: ' . url("admin/quotes/{$id}/edit"));
            exit;
        }

        $client_name = sanitize_cms($_POST['client_name'] ?? '');
        $client_company = sanitize_cms($_POST['client_company'] ?? '');
        $quote_text = sanitize_cms($_POST['quote_text'] ?? '');
        $rating = intval($_POST['rating'] ?? 5);
        $imageId = !empty($_POST['image_id']) ? (int) $_POST['image_id'] : null;
        $status = sanitize($_POST['status'] ?? 'active');

        \App\Database\Database::getInstance()->update(
            'quotes',
            [
                'client_name' => $client_name,
                'client_company' => $client_company,
                'quote_text' => $quote_text,
                'rating' => $rating,
                'image_id' => $imageId,
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ],
            'id = ?',
            [$id]
        );

        AuditLog::record('update', 'quote', $id, ['client_name' => $client_name]);
        $_SESSION['success'] = 'Quote updated successfully.';
        header('Location: ' . url('admin/quotes'));
        exit;
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . url('admin/quotes'));
            exit;
        }

        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!validate_csrf($csrfToken)) {
            $_SESSION['error'] = 'Invalid security token.';
            header('Location: ' . url('admin/quotes'));
            exit;
        }

        $quote = Quote::find($id);
        if (!$quote) {
            $_SESSION['error'] = 'Quote not found.';
            header('Location: ' . url('admin/quotes'));
            exit;
        }

        $quote->delete();
        AuditLog::record('delete', 'quote', $id);
        $_SESSION['success'] = 'Quote deleted successfully.';
        header('Location: ' . url('admin/quotes'));
        exit;
    }
}
