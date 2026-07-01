<?php
$search = $search ?? '';
$statusFilter = $statusFilter ?? '';
?>

<div class="admin-page-header">
    <h3 style="margin:0;font-size:1.125rem;font-weight:700;">Services</h3>
    <a href="<?= url('admin/services/create') ?>" class="admin-btn admin-btn-primary"><i class="fas fa-plus"></i> New Service</a>
</div>

<form method="GET" class="admin-search-bar">
    <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" class="admin-input" placeholder="Search services...">
    <select name="status" class="admin-select" style="max-width:140px;">
        <option value="">All statuses</option>
        <option value="active" <?= $statusFilter === 'active' ? 'selected' : '' ?>>Active</option>
        <option value="inactive" <?= $statusFilter === 'inactive' ? 'selected' : '' ?>>Inactive</option>
    </select>
    <button type="submit" class="admin-btn admin-btn-outline">Filter</button>
</form>

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Status</th>
                <th style="text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($services)): ?>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($service['name']) ?></strong></td>
                        <td><?= htmlspecialchars($service['slug']) ?></td>
                        <td><span class="admin-status-pill <?= ($service['status'] ?? '') === 'active' ? 'admin-status-active' : 'admin-status-inactive' ?>"><?= ucfirst($service['status']) ?></span></td>
                        <td style="text-align:right;">
                            <a href="<?= url('admin/services/' . $service['id'] . '/edit') ?>" class="admin-btn admin-btn-outline admin-btn-sm">Edit</a>
                            <form method="POST" action="<?= url('admin/services/' . $service['id'] . '/delete') ?>" data-confirm="Delete this service?" style="display:inline;">
                                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" class="admin-empty">No services found. <a href="<?= url('admin/services/create') ?>">Create one</a></td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
