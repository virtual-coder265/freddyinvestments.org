<div class="admin-page-header">
    <h3 style="margin:0;font-size:1.125rem;font-weight:700;">Messages</h3>
    <?php if (($unread_count ?? 0) > 0): ?>
        <span class="admin-status-pill admin-status-inactive"><?= (int) $unread_count ?> unread</span>
    <?php endif; ?>
</div>

<form method="GET" class="admin-search-bar">
    <input type="text" name="q" value="<?= htmlspecialchars($search ?? '') ?>" class="admin-input" placeholder="Search messages...">
    <button type="submit" class="admin-btn admin-btn-outline">Search</button>
</form>

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>From</th>
                <th>Message</th>
                <th>Status</th>
                <th>Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($messages)): ?>
                <?php foreach ($messages as $msg): ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($msg['name']) ?></strong><br>
                            <small style="color:#64748b;"><?= htmlspecialchars($msg['email']) ?></small>
                        </td>
                        <td style="max-width:280px;"><?= htmlspecialchars(substr($msg['message'], 0, 80)) ?>...</td>
                        <td><span class="admin-status-pill <?= ($msg['status'] ?? '') === 'unread' ? 'admin-status-inactive' : 'admin-status-active' ?>"><?= ucfirst($msg['status']) ?></span></td>
                        <td style="font-size:.8125rem;white-space:nowrap;"><?= htmlspecialchars($msg['created_at'] ?? '') ?></td>
                        <td><a href="<?= url('admin/messages/' . $msg['id'] . '/view') ?>" class="admin-btn admin-btn-outline admin-btn-sm">View</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5" class="admin-empty">No messages found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if (($totalPages ?? 1) > 1): ?>
    <div style="display:flex;gap:.5rem;justify-content:center;margin-top:1rem;">
        <?php if (($page ?? 1) > 1): ?>
            <a href="<?= url('admin/messages?page=' . (($page ?? 1) - 1) . '&q=' . urlencode($search ?? '')) ?>" class="admin-btn admin-btn-outline admin-btn-sm">Previous</a>
        <?php endif; ?>
        <span style="padding:.375rem .75rem;font-size:.8125rem;">Page <?= (int) ($page ?? 1) ?> of <?= (int) ($totalPages ?? 1) ?></span>
        <?php if (($page ?? 1) < ($totalPages ?? 1)): ?>
            <a href="<?= url('admin/messages?page=' . (($page ?? 1) + 1) . '&q=' . urlencode($search ?? '')) ?>" class="admin-btn admin-btn-outline admin-btn-sm">Next</a>
        <?php endif; ?>
    </div>
<?php endif; ?>
