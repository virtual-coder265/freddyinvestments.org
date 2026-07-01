<?php
namespace App\Controllers;

use App\Controllers\Admin\AdminController;

/**
 * Legacy content controller — redirects to page-centric editors.
 */
class AdminContentController extends AdminController {
    public function index() {
        header('Location: ' . url('admin/site/home'));
        exit;
    }

    public function update() {
        header('Location: ' . url('admin/site/home'));
        exit;
    }
}
