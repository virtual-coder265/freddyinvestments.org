<?php
// Project form
?>

<div class="flex items-center justify-between mb-6">
    <h3 class="text-lg font-bold text-slate-900"><?= $action === 'create' ? 'Create New Project' : 'Edit Project' ?></h3>
    <a href="<?= url('admin/projects') ?>" class="text-slate-600 hover:text-slate-900 transition">
        <i class="fas fa-arrow-left mr-2"></i>Back to Projects
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="<?= $action === 'create' ? url('admin/projects/store') : url("admin/projects/{$project['id']}/update") ?>" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Project Title *</label>
                <input type="text" name="title" value="<?= htmlspecialchars($project['title'] ?? '') ?>" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Project title">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Slug *</label>
                <input type="text" name="slug" value="<?= htmlspecialchars($project['slug'] ?? '') ?>" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="project-slug">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Category Key</label>
                <input type="text" name="category" value="<?= htmlspecialchars($project['category'] ?? '') ?>" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="construction">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Category Label</label>
                <input type="text" name="category_label" value="<?= htmlspecialchars($project['category_label'] ?? '') ?>" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Construction">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-900 mb-2">Description</label>
            <textarea name="description" rows="5" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Project description..."><?= htmlspecialchars($project['description'] ?? '') ?></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Location</label>
                <input type="text" name="location" value="<?= htmlspecialchars($project['location'] ?? '') ?>" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Mangochi District">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Order</label>
                <input type="number" name="order_position" value="<?= htmlspecialchars($project['order_position'] ?? 0) ?>" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="active" <?= ($project['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($project['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">CMS Image</label>
                <select name="image_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">Use fallback image</option>
                    <?php foreach ($assets as $asset): ?>
                        <option value="<?= $asset['id'] ?>" <?= (string) ($project['image_id'] ?? '') === (string) $asset['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($asset['original_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Fallback Bundled Image</label>
                <input type="text" name="fallback_image" value="<?= htmlspecialchars($project['fallback_image'] ?? '') ?>" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="project1.jpeg">
            </div>
        </div>

        <label class="inline-flex items-center">
            <input type="checkbox" name="featured" value="1" <?= !empty($project['featured']) ? 'checked' : '' ?> class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
            <span class="ml-2 text-sm font-semibold text-slate-700">Feature this project on the homepage</span>
        </label>

        <div class="flex gap-4">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                <i class="fas fa-save mr-2"></i><?= $action === 'create' ? 'Create Project' : 'Update Project' ?>
            </button>
            <a href="<?= url('admin/projects') ?>" class="bg-slate-300 hover:bg-slate-400 text-slate-900 font-semibold py-2 px-6 rounded-lg transition">
                Cancel
            </a>
        </div>
    </form>
</div>
