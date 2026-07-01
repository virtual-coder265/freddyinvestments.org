<?php
namespace App\Controllers;

use App\Controllers\Admin\AdminController;

/**
 * Legacy assets routes — redirect to Media Library.
 */
class AdminAssetsController extends AdminController {
    public function index() {
        header('Location: ' . url('admin/media'));
        exit;
    }

    public function upload() {
        header('Location: ' . url('admin/media'));
        exit;
    }

    public function update($id) {
        header('Location: ' . url('admin/media'));
        exit;
    }

    public function delete($id) {
        header('Location: ' . url('admin/media'));
        exit;
    }
}
