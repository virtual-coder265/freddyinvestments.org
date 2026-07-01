<?php
$currentPage = $currentPage ?? '';
$menuGroups = $menuGroups ?? [];
$breadcrumbs = $breadcrumbs ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin Panel') ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset_url('admin/admin.css') ?>">
</head>
<body class="admin-body">
<div class="admin-shell">
    <div id="admin-sidebar-overlay" class="admin-sidebar-overlay"></div>

    <aside id="admin-sidebar" class="admin-sidebar">
        <div class="admin-sidebar-brand">
            <h1>Freddy Admin</h1>
            <p>Content Management</p>
        </div>

        <nav class="admin-nav">
            <?php foreach ($menuGroups as $group): ?>
                <?php if (!empty($group['children'])): ?>
                    <div class="admin-nav-group <?= !empty($group['open']) ? 'is-open' : '' ?>">
                        <button type="button" class="admin-nav-group-toggle <?= !empty($group['open']) ? 'active' : '' ?>" data-nav-group-toggle>
                            <i class="fas <?= htmlspecialchars($group['icon']) ?>"></i>
                            <?= htmlspecialchars($group['label']) ?>
                        </button>
                        <div class="admin-nav-children">
                            <?php foreach ($group['children'] as $child): ?>
                                <a href="<?= htmlspecialchars($child['url']) ?>" class="admin-nav-child <?= !empty($child['active']) ? 'active' : '' ?>">
                                    <span><?= htmlspecialchars($child['label']) ?></span>
                                    <?php if (!empty($child['badge'])): ?>
                                        <span class="admin-nav-badge"><?= htmlspecialchars($child['badge']) ?></span>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= htmlspecialchars($group['url']) ?>" class="admin-nav-link <?= !empty($group['active']) ? 'active' : '' ?>">
                        <i class="fas <?= htmlspecialchars($group['icon']) ?>"></i>
                        <?= htmlspecialchars($group['label']) ?>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>

        <div class="admin-sidebar-footer">
            <strong><?= htmlspecialchars($_SESSION['admin_full_name'] ?? 'Admin') ?></strong>
            <div style="color:#94a3b8;font-size:.75rem;"><?= htmlspecialchars($_SESSION['admin_role'] ?? 'admin') ?></div>
            <a href="<?= url('admin/logout') ?>" style="color:#94a3b8;font-size:.75rem;margin-top:.5rem;display:inline-block;">Sign out</a>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <div class="admin-topbar-left">
                <button type="button" id="admin-menu-toggle" class="admin-menu-toggle" aria-label="Toggle menu">
                    <i class="fas fa-bars"></i>
                </button>
                <h2><?= htmlspecialchars($title ?? 'Admin Panel') ?></h2>
            </div>
            <div class="admin-topbar-actions">
                <a href="<?= url('/') ?>" target="_blank" rel="noopener"><i class="fas fa-eye"></i> View Site</a>
                <a href="<?= url('admin/logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </header>

        <main class="admin-content">
            <?php if (!empty($breadcrumbs)): ?>
                <?php require __DIR__ . '/../components/breadcrumbs.php'; ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="admin-alert admin-alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?= htmlspecialchars($_SESSION['success']) ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="admin-alert admin-alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
