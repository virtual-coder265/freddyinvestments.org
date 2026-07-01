<?php
use App\Models\Asset;
use App\Models\ContentSection;

$imageAssets = $assets ?? [];
?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h3 class="text-lg font-bold text-slate-900">Public Content Sections</h3>
        <p class="text-sm text-slate-600">Edit the text used by the current public page design.</p>
    </div>
</div>

<form method="POST" action="<?= url('admin/content/update') ?>" class="space-y-6">
    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

    <?php foreach ($fields as $page => $sections): ?>
        <div class="bg-white rounded-lg shadow">
            <div class="border-b border-slate-200 px-6 py-4">
                <h4 class="text-base font-bold text-slate-900 uppercase"><?= htmlspecialchars($page) ?></h4>
            </div>

            <div class="p-6 space-y-8">
                <?php foreach ($sections as $section => $sectionFields): ?>
                    <div>
                        <h5 class="text-sm font-bold text-emerald-700 uppercase tracking-wide mb-4"><?= htmlspecialchars(str_replace('_', ' ', $section)) ?></h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php foreach ($sectionFields as $field => $meta): ?>
                                <?php
                                $name = "{$page}__{$section}__{$field}";
                                $value = ContentSection::get($page, $section, $field, $meta['default'] ?? '');
                                $fieldType = $meta['type'] ?? 'text';
                                $isTextarea = $fieldType === 'textarea';
                                $isImage = $fieldType === 'image';
                                $selectedAsset = $isImage && $value !== '' ? Asset::find($value) : null;
                                $previewUrl = $selectedAsset ? media_url($selectedAsset['filepath']) : '';
                                ?>
                                <div class="<?= ($isTextarea || $isImage) ? 'md:col-span-2' : '' ?>">
                                    <label class="block text-sm font-semibold text-slate-900 mb-2"><?= htmlspecialchars($meta['label'] ?? $field) ?></label>
                                    <?php if ($isImage): ?>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                                            <div class="md:col-span-2">
                                                <select
                                                    name="<?= htmlspecialchars($name) ?>"
                                                    class="cms-image-select w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                                    data-preview-target="<?= htmlspecialchars($name) ?>_preview"
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
                                                <p class="text-xs text-slate-500 mt-1">Upload media in Assets, then choose it here. Leaving blank keeps the current default image.</p>
                                            </div>
                                            <div>
                                                <div class="w-full h-28 bg-slate-100 border border-slate-200 rounded-lg overflow-hidden flex items-center justify-center">
                                                    <img
                                                        id="<?= htmlspecialchars($name) ?>_preview"
                                                        src="<?= htmlspecialchars($previewUrl) ?>"
                                                        alt=""
                                                        class="w-full h-full object-cover <?= $previewUrl === '' ? 'hidden' : '' ?>"
                                                    >
                                                    <span class="cms-image-empty text-xs text-slate-400 <?= $previewUrl !== '' ? 'hidden' : '' ?>">Default image</span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php elseif ($isTextarea): ?>
                                        <textarea name="<?= htmlspecialchars($name) ?>" rows="4" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"><?= htmlspecialchars($value) ?></textarea>
                                    <?php else: ?>
                                        <input type="text" name="<?= htmlspecialchars($name) ?>" value="<?= htmlspecialchars($value) ?>" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-6 rounded-lg transition">
        <i class="fas fa-save mr-2"></i>Save Content Sections
    </button>
</form>

<script>
    document.querySelectorAll('.cms-image-select').forEach(function (select) {
        select.addEventListener('change', function () {
            var preview = document.getElementById(select.dataset.previewTarget);
            if (!preview) {
                return;
            }

            var option = select.options[select.selectedIndex];
            var previewUrl = option ? option.dataset.preview : '';
            var emptyLabel = preview.parentElement.querySelector('.cms-image-empty');

            if (previewUrl) {
                preview.src = previewUrl;
                preview.classList.remove('hidden');
                if (emptyLabel) {
                    emptyLabel.classList.add('hidden');
                }
            } else {
                preview.removeAttribute('src');
                preview.classList.add('hidden');
                if (emptyLabel) {
                    emptyLabel.classList.remove('hidden');
                }
            }
        });
    });
</script>
