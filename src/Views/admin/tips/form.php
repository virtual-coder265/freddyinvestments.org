<div class="admin-page-header">
    <h3 style="margin:0;"><?= $action === 'create' ? 'Create Tip' : 'Edit Tip' ?></h3>
    <a href="<?= url('admin/tips') ?>" class="admin-btn admin-btn-outline admin-btn-sm">← Back</a>
</div>

<div class="admin-card">
    <form method="POST" action="<?= $action === 'create' ? url('admin/tips/store') : url('admin/tips/' . $tip['id'] . '/update') ?>" class="admin-card-body" data-admin-form>
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

        <div class="admin-field">
            <label>Title *</label>
            <input type="text" name="title" value="<?= htmlspecialchars($tip['title'] ?? '') ?>" required class="admin-input">
        </div>

        <div class="admin-field">
            <label>URL Slug</label>
            <input type="text" name="slug" value="<?= htmlspecialchars($tip['slug'] ?? '') ?>" class="admin-input" placeholder="auto-generated from title">
        </div>

        <div class="admin-field">
            <label>Content</label>
            <textarea id="tip-content" name="content" class="admin-textarea" rows="12" placeholder="Write your tip content here..."><?= htmlspecialchars($tip['content'] ?? '') ?></textarea>
            <p style="font-size:.75rem;color:#64748b;margin-top:.25rem;">Basic HTML tags are supported on the public tip page.</p>
        </div>

        <div class="admin-grid-2">
            <div class="admin-field">
                <label>Category</label>
                <input type="text" name="category" value="<?= htmlspecialchars($tip['category'] ?? '') ?>" class="admin-input">
            </div>
            <div class="admin-field">
                <label>Order</label>
                <input type="number" name="order_position" value="<?= htmlspecialchars($tip['order_position'] ?? 0) ?>" class="admin-input">
            </div>
            <div class="admin-field">
                <label>Featured Image</label>
                <select name="image_id" class="admin-select">
                    <option value="">No image</option>
                    <?php foreach (($assets ?? []) as $asset): ?>
                        <option value="<?= $asset['id'] ?>" <?= (string) ($tip['image_id'] ?? '') === (string) $asset['id'] ? 'selected' : '' ?>><?= htmlspecialchars($asset['original_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="admin-field">
                <label>Status</label>
                <select name="status" class="admin-select">
                    <option value="active" <?= ($tip['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($tip['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </div>

        <div style="margin-top:1rem;">
            <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Save Tip</button>
        </div>
    </form>
</div>
