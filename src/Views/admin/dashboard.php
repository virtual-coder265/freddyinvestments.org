<div class="admin-stats-grid">
    <div class="admin-stat-card">
        <div class="admin-stat-icon" style="background:#dbeafe;color:#2563eb;"><i class="fas fa-tools"></i></div>
        <div>
            <div style="font-size:.8125rem;color:#64748b;">Services</div>
            <div style="font-size:1.75rem;font-weight:700;"><?= (int) ($total_services ?? 0) ?></div>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-icon" style="background:#d1fae5;color:#059669;"><i class="fas fa-briefcase"></i></div>
        <div>
            <div style="font-size:.8125rem;color:#64748b;">Projects</div>
            <div style="font-size:1.75rem;font-weight:700;"><?= (int) ($total_projects ?? 0) ?></div>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-icon" style="background:#ffedd5;color:#ea580c;"><i class="fas fa-envelope"></i></div>
        <div>
            <div style="font-size:.8125rem;color:#64748b;">Unread Messages</div>
            <div style="font-size:1.75rem;font-weight:700;"><?= (int) ($unread_messages ?? 0) ?></div>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-icon" style="background:#ede9fe;color:#7c3aed;"><i class="fas fa-lightbulb"></i></div>
        <div>
            <div style="font-size:.8125rem;color:#64748b;">Tips & Blog</div>
            <div style="font-size:1.75rem;font-weight:700;"><?= (int) ($total_tips ?? 0) ?></div>
        </div>
    </div>
</div>

<div class="admin-layout-with-sidebar">
    <div>
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Recent Messages</h3>
                <a href="<?= url('admin/messages') ?>" class="admin-btn admin-btn-outline admin-btn-sm">View All</a>
            </div>
            <div class="admin-card-body" style="padding:0;">
                <?php if (!empty($recent_messages)): ?>
                    <?php foreach ($recent_messages as $msg): ?>
                        <div style="padding:1rem 1.5rem;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;gap:1rem;">
                            <div>
                                <strong><?= htmlspecialchars($msg['name']) ?></strong>
                                <div style="font-size:.8125rem;color:#64748b;"><?= htmlspecialchars($msg['email']) ?></div>
                                <div style="font-size:.75rem;color:#94a3b8;margin-top:.25rem;"><?= htmlspecialchars(substr($msg['message'], 0, 100)) ?>...</div>
                            </div>
                            <span class="admin-status-pill <?= ($msg['status'] ?? '') === 'unread' ? 'admin-status-inactive' : 'admin-status-active' ?>"><?= ucfirst($msg['status']) ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="admin-empty">No messages yet.</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header"><h3>Recent Activity</h3></div>
            <div class="admin-card-body" style="padding:0;">
                <?php if (!empty($recent_activity)): ?>
                    <?php foreach ($recent_activity as $log): ?>
                        <div style="padding:.875rem 1.5rem;border-bottom:1px solid #f1f5f9;font-size:.8125rem;">
                            <strong><?= htmlspecialchars($log['full_name'] ?? $log['username'] ?? 'Admin') ?></strong>
                            <?= htmlspecialchars($log['action']) ?>
                            <?= htmlspecialchars($log['entity_type'] ?? '') ?>
                            <span style="color:#94a3b8;float:right;"><?= htmlspecialchars($log['created_at'] ?? '') ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="admin-empty">No activity yet.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div>
        <div class="admin-card">
            <div class="admin-card-header"><h3>Quick Actions</h3></div>
            <div class="admin-card-body" style="display:flex;flex-direction:column;gap:.5rem;">
                <a href="<?= url('admin/site/home') ?>" class="admin-btn admin-btn-primary">Edit Homepage</a>
                <a href="<?= url('admin/media') ?>" class="admin-btn admin-btn-secondary">Upload Media</a>
                <a href="<?= url('admin/messages') ?>" class="admin-btn admin-btn-outline">View Inbox</a>
                <a href="<?= url('admin/services/create') ?>" class="admin-btn admin-btn-outline">New Service</a>
                <a href="<?= url('admin/tips/create') ?>" class="admin-btn admin-btn-outline">New Tip</a>
                <a href="<?= url('admin/settings') ?>" class="admin-btn admin-btn-outline">Site Settings</a>
            </div>
        </div>
    </div>
</div>
