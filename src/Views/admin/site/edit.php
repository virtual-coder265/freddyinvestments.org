<?php
use App\Admin\ContentSchema;
use App\Models\ContentSection;

$pageKey = $pageKey ?? 'home';
$pageMeta = $pageMeta ?? [];
$sections = $sections ?? [];
$activeSection = $activeSection ?? array_key_first($sections);
$imageAssets = $assets ?? [];
$linkedEntities = $linkedEntities ?? [];
?>

<div class="admin-page-header">
    <div>
        <h3 style="margin:0;font-size:1.125rem;font-weight:700;">Edit <?= htmlspecialchars($pageMeta['label'] ?? ucfirst($pageKey)) ?></h3>
        <p style="margin:.25rem 0 0;font-size:.875rem;color:#64748b;">Manage all content sections for this public page.</p>
    </div>
    <a href="<?= url(ltrim($pageMeta['public_url'] ?? '/', '/')) ?>" target="_blank" rel="noopener" class="admin-btn admin-btn-outline">
        <i class="fas fa-external-link-alt"></i> Preview Page
    </a>
</div>

<?php if (!empty($linkedEntities)): ?>
    <div class="admin-context-sidebar">
        <h4>Related Content</h4>
        <ul>
            <?php foreach ($linkedEntities as $link): ?>
                <li><a href="<?= htmlspecialchars($link['url']) ?>"><?= htmlspecialchars($link['label']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="<?= url('admin/site/' . $pageKey . '/update') ?>" data-admin-form>
    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

    <div class="admin-card" data-admin-tabs>
        <div class="admin-tabs">
            <?php foreach ($sections as $sectionKey => $sectionFields): ?>
                <button type="button" class="admin-tab <?= $sectionKey === $activeSection ? 'active' : '' ?>" data-tab="<?= htmlspecialchars($sectionKey) ?>">
                    <?= htmlspecialchars(ContentSchema::sectionLabel($sectionKey)) ?>
                </button>
            <?php endforeach; ?>
        </div>

        <?php foreach ($sections as $sectionKey => $sectionFields): ?>
            <div class="admin-card-body admin-tab-panel <?= $sectionKey === $activeSection ? 'active' : '' ?>" data-tab-panel="<?= htmlspecialchars($sectionKey) ?>">
                <div class="admin-grid-2">
                    <?php foreach ($sectionFields as $fieldKey => $meta): ?>
                        <?php
                        $value = ContentSection::get($pageKey, $sectionKey, $fieldKey, $meta['default'] ?? '');
                        $page = $pageKey;
                        $section = $sectionKey;
                        $field = $fieldKey;
                        require __DIR__ . '/../components/field.php';
                        ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="admin-save-bar">
            <span style="font-size:.8125rem;color:#64748b;">Changes apply to the live <?= htmlspecialchars(strtolower($pageMeta['label'] ?? 'page')) ?>.</span>
            <button type="submit" class="admin-btn admin-btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </div>
    </div>
</form>
