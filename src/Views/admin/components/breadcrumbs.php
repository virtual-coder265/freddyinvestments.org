<nav class="admin-breadcrumbs" aria-label="Breadcrumb">
    <?php foreach ($breadcrumbs as $index => $crumb): ?>
        <?php if ($index > 0): ?><span class="sep">/</span><?php endif; ?>
        <?php if (!empty($crumb['url'])): ?>
            <a href="<?= htmlspecialchars($crumb['url']) ?>"><?= htmlspecialchars($crumb['label']) ?></a>
        <?php else: ?>
            <span><?= htmlspecialchars($crumb['label']) ?></span>
        <?php endif; ?>
    <?php endforeach; ?>
</nav>
