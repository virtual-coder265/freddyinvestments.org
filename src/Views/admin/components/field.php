<?php
/**
 * Renders a single CMS field.
 * Expects: $page, $section, $field, $meta, $value, $imageAssets
 */
$name = "{$page}__{$section}__{$field}";
$fieldType = $meta['type'] ?? 'text';
$label = $meta['label'] ?? $field;
$isTextarea = $fieldType === 'textarea';
$isImage = $fieldType === 'image';
$isToggle = $fieldType === 'toggle';
$previewId = htmlspecialchars($name) . '_preview';
$selectedAsset = $isImage && $value !== '' ? \App\Models\Asset::find($value) : null;
$previewUrl = $selectedAsset ? media_url($selectedAsset['filepath']) : '';
?>
<div class="admin-field <?= ($isTextarea || $isImage) ? 'admin-grid-span-2' : '' ?>">
    <label for="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($label) ?></label>

    <?php if ($isToggle): ?>
        <div class="admin-toggle">
            <input type="hidden" name="<?= htmlspecialchars($name) ?>" value="0">
            <input type="checkbox" id="<?= htmlspecialchars($name) ?>" name="<?= htmlspecialchars($name) ?>" value="1" <?= ($value === '1' || $value === 1 || $value === true) ? 'checked' : '' ?>>
            <span>Enabled</span>
        </div>
    <?php elseif ($isImage): ?>
        <div class="admin-image-picker">
            <div>
                <select
                    id="<?= htmlspecialchars($name) ?>"
                    name="<?= htmlspecialchars($name) ?>"
                    class="admin-select cms-image-select"
                    data-preview-target="<?= $previewId ?>"
                >
                    <option value="" data-preview="">Use default image</option>
                    <?php foreach ($imageAssets as $asset): ?>
                        <option
                            value="<?= (int) $asset['id'] ?>"
                            data-preview="<?= htmlspecialchars(media_url($asset['filepath'])) ?>"
                            <?= (string) $value === (string) $asset['id'] ? 'selected' : '' ?>
                        >
                            <?= htmlspecialchars($asset['original_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="button" class="admin-btn admin-btn-outline admin-btn-sm" style="margin-top:.5rem;"
                    data-media-picker-trigger
                    data-target-input="<?= htmlspecialchars($name) ?>"
                    data-target-preview="<?= $previewId ?>"
                >Browse Media Library</button>
                <p style="font-size:.75rem;color:#64748b;margin-top:.25rem;">Upload new files in Media Library, then select here.</p>
            </div>
            <div class="admin-image-preview" id="<?= $previewId ?>">
                <?php if ($previewUrl): ?>
                    <img src="<?= htmlspecialchars($previewUrl) ?>" alt="">
                <?php else: ?>
                    <span class="cms-image-empty">Default</span>
                <?php endif; ?>
            </div>
        </div>
    <?php elseif ($isTextarea): ?>
        <textarea id="<?= htmlspecialchars($name) ?>" name="<?= htmlspecialchars($name) ?>" class="admin-textarea" rows="4"><?= e($value) ?></textarea>
    <?php else: ?>
        <input type="text" id="<?= htmlspecialchars($name) ?>" name="<?= htmlspecialchars($name) ?>" value="<?= e($value) ?>" class="admin-input">
    <?php endif; ?>
</div>
