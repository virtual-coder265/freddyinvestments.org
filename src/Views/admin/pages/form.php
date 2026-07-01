<?php
// Page form (create/edit)
?>

<div class="flex items-center justify-between mb-6">
    <h3 class="text-lg font-bold text-slate-900"><?= $action === 'create' ? 'Create New Page' : 'Edit Page' ?></h3>
    <a href="<?= url('admin/pages') ?>" class="text-slate-600 hover:text-slate-900 transition">
        <i class="fas fa-arrow-left mr-2"></i>Back to Pages
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="<?= $action === 'create' ? url('admin/pages/store') : url("admin/pages/{$page['id']}/update") ?>" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

        <!-- Title -->
        <div>
            <label class="block text-sm font-semibold text-slate-900 mb-2">Page Title *</label>
            <input type="text" name="title" value="<?= htmlspecialchars($page['title'] ?? '') ?>" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Enter page title">
        </div>

        <!-- Slug -->
        <div>
            <label class="block text-sm font-semibold text-slate-900 mb-2">Slug *</label>
            <input type="text" name="slug" value="<?= htmlspecialchars($page['slug'] ?? '') ?>" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="page-slug">
            <p class="text-xs text-slate-600 mt-1">URL-friendly version of the page title</p>
        </div>

        <!-- Content -->
        <div>
            <label class="block text-sm font-semibold text-slate-900 mb-2">Content</label>
            <textarea name="content" rows="10" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Enter page content..."><?= htmlspecialchars($page['content'] ?? '') ?></textarea>
        </div>

        <!-- Status -->
        <div>
            <label class="block text-sm font-semibold text-slate-900 mb-2">Status</label>
            <select name="status" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                <option value="draft" <?= ($page['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                <option value="published" <?= ($page['status'] ?? '') === 'published' ? 'selected' : '' ?>>Published</option>
            </select>
        </div>

        <!-- Featured Image -->
        <div>
            <label class="block text-sm font-semibold text-slate-900 mb-2">Featured Image</label>
            <select name="featured_image" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                <option value="">No featured image</option>
                <?php foreach (($assets ?? []) as $asset): ?>
                    <option value="<?= htmlspecialchars($asset['filepath']) ?>" <?= ($page['featured_image'] ?? '') === $asset['filepath'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($asset['original_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Meta Description -->
        <div>
            <label class="block text-sm font-semibold text-slate-900 mb-2">Meta Description</label>
            <textarea name="meta_description" rows="3" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Page meta description for SEO..."><?= htmlspecialchars($page['meta_description'] ?? '') ?></textarea>
        </div>

        <!-- Meta Keywords -->
        <div>
            <label class="block text-sm font-semibold text-slate-900 mb-2">Meta Keywords</label>
            <textarea name="meta_keywords" rows="2" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Comma-separated SEO keywords..."><?= htmlspecialchars($page['meta_keywords'] ?? '') ?></textarea>
        </div>

        <!-- Submit -->
        <div class="flex gap-4">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                <i class="fas fa-save mr-2"></i><?= $action === 'create' ? 'Create Page' : 'Update Page' ?>
            </button>
            <a href="<?= url('admin/pages') ?>" class="bg-slate-300 hover:bg-slate-400 text-slate-900 font-semibold py-2 px-6 rounded-lg transition">
                <i class="fas fa-times mr-2"></i>Cancel
            </a>
        </div>
    </form>
</div>
