<?php
use App\Models\Asset;

try {
    $modalAssets = Asset::byType('image');
} catch (\Throwable $e) {
    $modalAssets = [];
}
?>
<div id="admin-media-modal" class="admin-modal" role="dialog" aria-modal="true" aria-label="Media Library">
    <div class="admin-modal-backdrop"></div>
    <div class="admin-modal-dialog">
        <div class="admin-modal-header">
            <h3 style="margin:0;font-size:1rem;">Select Media</h3>
            <button type="button" class="admin-btn admin-btn-outline admin-btn-sm" data-media-modal-close>&times; Close</button>
        </div>
        <div class="admin-modal-body">
            <div class="admin-media-grid">
                <?php foreach ($modalAssets as $asset): ?>
                    <?php if (($asset['asset_type'] ?? '') === 'image'): ?>
                        <button type="button" class="admin-media-item" style="cursor:pointer;border:none;text-align:left;"
                            data-media-select="<?= (int) $asset['id'] ?>"
                            data-media-url="<?= htmlspecialchars(media_url($asset['filepath'])) ?>"
                        >
                            <img src="<?= htmlspecialchars(media_url($asset['filepath'])) ?>" alt="<?= htmlspecialchars($asset['alt_text'] ?? '') ?>">
                            <div class="admin-media-item-info"><?= htmlspecialchars($asset['original_name']) ?></div>
                        </button>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php if (empty($modalAssets)): ?>
                <div class="admin-empty">
                    <p>No images in the media library yet.</p>
                    <a href="<?= url('admin/media') ?>" class="admin-btn admin-btn-primary">Upload Media</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
