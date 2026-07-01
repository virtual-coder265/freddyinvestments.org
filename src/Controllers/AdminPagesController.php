<?php
namespace App\Controllers;

use App\Controllers\Admin\AdminController;

/**
 * Legacy pages CRUD — retired from admin navigation.
 */
class AdminPagesController extends AdminController {
    protected function redirectDeprecated() {
        $_SESSION['error'] = 'The Pages section has been replaced by Site Pages editors.';
        header('Location: ' . url('admin/site/home'));
        exit;
    }

    public function index() { $this->redirectDeprecated(); }
    public function create() { $this->redirectDeprecated(); }
    public function store() { $this->redirectDeprecated(); }
    public function edit($id) { $this->redirectDeprecated(); }
    public function update($id) { $this->redirectDeprecated(); }
    public function delete($id) { $this->redirectDeprecated(); }
}
