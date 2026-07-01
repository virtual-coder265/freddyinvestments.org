<?php
$page = $page ?? 1;
$totalPages = $totalPages ?? 1;
$actionFilter = $actionFilter ?? '';
$entityFilter = $entityFilter ?? '';
?>

<div class="admin-page-header">
    <h3 style="margin:0;font-size:1.125rem;font-weight:700;">Activity Log</h3>
</div>

<form method="GET" action="<?= url('admin/activity') ?>" class="admin-search-bar">
    <select name="action" class="admin-select" style="max-width:160px;">
        <option value="">All actions</option>
        <?php foreach (['login', 'logout', 'create', 'update', 'delete', 'upload', 'reply'] as $act): ?>
            <option value="<?= $act ?>" <?= $actionFilter === $act ? 'selected' : '' ?>><?= ucfirst($act) ?></option>
        <?php endforeach; ?>
    </select>
    <input type="text" name="entity" value="<?= htmlspecialchars($entityFilter) ?>" class="admin-input" placeholder="Entity type..." style="max-width:180px;">
    <button type="submit" class="admin-btn admin-btn-outline">Filter</button>
</form>

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>When</th>
                <th>User</th>
                <th>Action</th>
                <th>Entity</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($logs)): ?>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td style="white-space:nowrap;font-size:.8125rem;"><?= htmlspecialchars($log['created_at'] ?? '') ?></td>
                        <td><?= htmlspecialchars($log['full_name'] ?? $log['username'] ?? 'System') ?></td>
                        <td><span class="admin-status-pill admin-status-draft"><?= htmlspecialchars($log['action']) ?></span></td>
                        <td><?= htmlspecialchars(($log['entity_type'] ?? '') . ($log['entity_id'] ? ' #' . $log['entity_id'] : '')) ?></td>
                        <td style="font-size:.8125rem;color:#64748b;max-width:280px;overflow:hidden;text-overflow:ellipsis;"><?= htmlspecialchars($log['changes'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" class="admin-empty">No activity recorded yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if ($totalPages > 1): ?>
    <div style="display:flex;gap:.5rem;justify-content:center;margin-top:1rem;">
        <?php if ($page > 1): ?>
            <a href="<?= url('admin/activity?page=' . ($page - 1) . '&action=' . urlencode($actionFilter) . '&entity=' . urlencode($entityFilter)) ?>" class="admin-btn admin-btn-outline admin-btn-sm">Previous</a>
        <?php endif; ?>
        <span style="padding:.375rem .75rem;font-size:.8125rem;">Page <?= (int) $page ?> of <?= (int) $totalPages ?></span>
        <?php if ($page < $totalPages): ?>
            <a href="<?= url('admin/activity?page=' . ($page + 1) . '&action=' . urlencode($actionFilter) . '&entity=' . urlencode($entityFilter)) ?>" class="admin-btn admin-btn-outline admin-btn-sm">Next</a>
        <?php endif; ?>
    </div>
<?php endif; ?>
