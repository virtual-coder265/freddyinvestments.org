<?php
$viewMode = $viewMode ?? 'grid';
$search = $search ?? '';
$typeFilter = $typeFilter ?? '';
?>

<div class="admin-page-header">
    <h3 style="margin:0;font-size:1.125rem;font-weight:700;">Media Library</h3>
    <button type="button" class="admin-btn admin-btn-primary" onclick="document.getElementById('media-upload-modal').classList.add('is-open')">
        <i class="fas fa-upload"></i> Upload
    </button>
</div>

<form method="GET" action="<?= url('admin/media') ?>" class="admin-search-bar">
    <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" class="admin-input" placeholder="Search files...">
    <select name="type" class="admin-select" style="max-width:140px;">
        <option value="">All types</option>
        <option value="image" <?= $typeFilter === 'image' ? 'selected' : '' ?>>Images</option>
        <option value="document" <?= $typeFilter === 'document' ? 'selected' : '' ?>>Documents</option>
    </select>
    <input type="hidden" name="view" value="<?= htmlspecialchars($viewMode) ?>">
    <button type="submit" class="admin-btn admin-btn-outline">Filter</button>
    <a href="<?= url('admin/media?view=' . ($viewMode === 'grid' ? 'list' : 'grid')) ?>" class="admin-btn admin-btn-outline">
        <?= $viewMode === 'grid' ? 'List view' : 'Grid view' ?>
    </a>
</form>

<div id="media-upload-modal" class="admin-modal">
    <div class="admin-modal-backdrop" onclick="this.closest('.admin-modal').classList.remove('is-open')"></div>
    <div class="admin-modal-dialog" style="max-width:560px;">
        <div class="admin-modal-header">
            <h3 style="margin:0;">Upload Media</h3>
            <button type="button" class="admin-btn admin-btn-outline admin-btn-sm" onclick="document.getElementById('media-upload-modal').classList.remove('is-open')">&times;</button>
        </div>
        <div class="admin-modal-body">
            <form method="POST" action="<?= url('admin/media/upload') ?>" enctype="multipart/form-data" id="media-upload-form">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <div class="admin-field">
                    <label>Files (max 5MB each — JPG, PNG, GIF, PDF)</label>
                    <input type="file" name="files[]" multiple required accept="image/jpeg,image/png,image/gif,application/pdf" class="admin-input">
                </div>
                <div class="admin-field">
                    <label>Alt Text (optional)</label>
                    <input type="text" name="alt_text" class="admin-input">
                </div>
                <div class="admin-field">
                    <label>Description (optional)</label>
                    <textarea name="description" class="admin-textarea" rows="2"></textarea>
                </div>
                <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-upload"></i> Upload</button>
            </form>
        </div>
    </div>
</div>

<?php if ($viewMode === 'list'): ?>
    <div class="admin-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>File</th>
                    <th>Type</th>
                    <th>Size</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($assets)): ?>
                    <?php foreach ($assets as $asset): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($asset['original_name']) ?></strong>
                                <?php if (!empty($asset['alt_text'])): ?>
                                    <br><small style="color:#64748b;"><?= htmlspecialchars($asset['alt_text']) ?></small>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($asset['asset_type']) ?></td>
                            <td><?= number_format(($asset['file_size'] ?? 0) / 1024, 1) ?> KB</td>
                            <td>
                                <form method="POST" action="<?= url('admin/media/' . $asset['id'] . '/delete') ?>" data-confirm="Delete this file?" style="display:inline;">
                                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="admin-empty">No media files found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="admin-media-grid">
        <?php if (!empty($assets)): ?>
            <?php foreach ($assets as $asset): ?>
                <div class="admin-media-item">
                    <?php if (($asset['asset_type'] ?? '') === 'image'): ?>
                        <img src="<?= htmlspecialchars(media_url($asset['filepath'])) ?>" alt="<?= htmlspecialchars($asset['alt_text'] ?? '') ?>">
                    <?php else: ?>
                        <div style="height:120px;display:flex;align-items:center;justify-content:center;background:#f1f5f9;">
                            <i class="fas fa-file-pdf" style="font-size:2rem;color:#94a3b8;"></i>
                        </div>
                    <?php endif; ?>
                    <div class="admin-media-item-info">
                        <div style="font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?= htmlspecialchars($asset['original_name']) ?></div>
                        <div><?= number_format(($asset['file_size'] ?? 0) / 1024, 1) ?> KB</div>
                        <form method="POST" action="<?= url('admin/media/' . $asset['id'] . '/update') ?>" style="margin-top:.5rem;">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                            <input type="text" name="alt_text" value="<?= htmlspecialchars($asset['alt_text'] ?? '') ?>" class="admin-input" style="font-size:.6875rem;padding:.25rem .5rem;margin-bottom:.25rem;" placeholder="Alt text">
                            <textarea name="description" class="admin-textarea" rows="2" style="font-size:.6875rem;min-height:48px;"><?= htmlspecialchars($asset['description'] ?? '') ?></textarea>
                            <button type="submit" class="admin-btn admin-btn-outline admin-btn-sm" style="margin-top:.25rem;">Save</button>
                        </form>
                        <form method="POST" action="<?= url('admin/media/' . $asset['id'] . '/delete') ?>" data-confirm="Delete this file?" style="margin-top:.25rem;">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                            <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="admin-empty admin-grid-span-2" style="grid-column:1/-1;">
                <i class="fas fa-images" style="font-size:2.5rem;color:#cbd5e1;margin-bottom:.75rem;"></i>
                <p>No media uploaded yet.</p>
                <button type="button" class="admin-btn admin-btn-primary" onclick="document.getElementById('media-upload-modal').classList.add('is-open')">Upload your first file</button>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
