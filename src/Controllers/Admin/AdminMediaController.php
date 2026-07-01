<?php
namespace App\Controllers\Admin;

use App\Models\AuditLog;
use App\Models\Asset;

/**
 * Media library management.
 */
class AdminMediaController extends AdminController {
    protected $currentPage = 'media';

    public function index() {
        $search = sanitize($_GET['q'] ?? '');
        $type = sanitize($_GET['type'] ?? '');

        $assets = $this->filterAssets($search, $type);
        $viewMode = ($_GET['view'] ?? 'grid') === 'list' ? 'list' : 'grid';

        $this->render('media/index', [
            'title' => 'Media Library | Admin Panel',
            'assets' => $assets,
            'search' => $search,
            'typeFilter' => $type,
            'viewMode' => $viewMode,
            'breadcrumbs' => [
                ['label' => 'Media Library'],
            ],
        ]);
    }

    public function upload() {
        $this->requirePost();
        $this->validateCsrfOrRedirect('admin/media');

        if (!isset($_FILES['files']) && !isset($_FILES['file'])) {
            $this->redirect('admin/media', 'No file uploaded.', 'error');
        }

        $uploadDir = dirname(dirname(dirname(__DIR__))) . '/public/uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $maxFileSize = 5 * 1024 * 1024;
        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'application/pdf' => 'pdf',
        ];

        $files = $this->normalizeUploadedFiles($_FILES['files'] ?? $_FILES['file']);
        $uploaded = 0;
        $errors = [];

        foreach ($files as $file) {
            if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
                $errors[] = ($file['name'] ?? 'File') . ': upload failed.';
                continue;
            }

            if ($file['size'] > $maxFileSize) {
                $errors[] = $file['name'] . ': exceeds 5MB limit.';
                continue;
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = $finfo ? finfo_file($finfo, $file['tmp_name']) : null;
            if ($finfo) finfo_close($finfo);

            if (!isset($allowedTypes[$mimeType])) {
                $errors[] = $file['name'] . ': file type not allowed.';
                continue;
            }

            $extension = $allowedTypes[$mimeType];
            $filename = uniqid('asset_', true) . '.' . $extension;
            $filepath = $uploadDir . $filename;

            if (!move_uploaded_file($file['tmp_name'], $filepath)) {
                $errors[] = $file['name'] . ': failed to save.';
                continue;
            }

            Asset::create([
                'filename' => $filename,
                'original_name' => $file['name'],
                'filepath' => '/uploads/' . $filename,
                'file_size' => $file['size'],
                'mime_type' => $mimeType,
                'asset_type' => substr($mimeType, 0, 5) === 'image' ? 'image' : 'document',
                'alt_text' => sanitize_cms($_POST['alt_text'] ?? ''),
                'description' => sanitize_cms($_POST['description'] ?? ''),
                'uploaded_by' => \App\Auth\AuthManager::id(),
            ]);

            AuditLog::record('upload', 'asset', null, ['filename' => $filename]);
            $uploaded++;
        }

        if ($uploaded > 0) {
            $_SESSION['success'] = $uploaded . ' file(s) uploaded successfully.';
        }
        if (!empty($errors)) {
            $_SESSION['error'] = implode(' ', $errors);
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode(['success' => $uploaded > 0, 'uploaded' => $uploaded, 'errors' => $errors]);
            exit;
        }

        header('Location: ' . url('admin/media'));
        exit;
    }

    public function update($id) {
        $this->requirePost();
        $this->validateCsrfOrRedirect('admin/media');

        $asset = Asset::find($id);
        if (!$asset) {
            $this->redirect('admin/media', 'Media not found.', 'error');
        }

        \App\Database\Database::getInstance()->update(
            'assets',
            [
                'alt_text' => sanitize_cms($_POST['alt_text'] ?? ''),
                'description' => sanitize_cms($_POST['description'] ?? ''),
            ],
            'id = ?',
            [$id]
        );
        AuditLog::record('update', 'asset', $id);
        $this->redirect('admin/media', 'Media updated successfully.');
    }

    public function delete($id) {
        $this->requirePost();
        $this->validateCsrfOrRedirect('admin/media');

        $asset = Asset::find($id);
        if (!$asset) {
            $this->redirect('admin/media', 'Media not found.', 'error');
        }

        $filepath = dirname(dirname(dirname(__DIR__))) . '/public' . $asset['filepath'];
        if (file_exists($filepath)) {
            unlink($filepath);
        }

        $asset->delete();
        AuditLog::record('delete', 'asset', $id);
        $this->redirect('admin/media', 'Media deleted successfully.');
    }

    protected function filterAssets($search, $type) {
        try {
            $all = Asset::all();
        } catch (\Throwable $e) {
            return [];
        }

        return array_values(array_filter($all, function ($asset) use ($search, $type) {
            if ($type !== '' && ($asset['asset_type'] ?? '') !== $type) {
                return false;
            }
            if ($search === '') {
                return true;
            }
            $haystack = strtolower(($asset['original_name'] ?? '') . ' ' . ($asset['alt_text'] ?? ''));
            return strpos($haystack, strtolower($search)) !== false;
        }));
    }

    protected function normalizeUploadedFiles($files) {
        if (!is_array($files['name'])) {
            return [$files];
        }

        $normalized = [];
        foreach ($files['name'] as $index => $name) {
            $normalized[] = [
                'name' => $name,
                'type' => $files['type'][$index] ?? '',
                'tmp_name' => $files['tmp_name'][$index] ?? '',
                'error' => $files['error'][$index] ?? UPLOAD_ERR_NO_FILE,
                'size' => $files['size'][$index] ?? 0,
            ];
        }
        return $normalized;
    }
}
