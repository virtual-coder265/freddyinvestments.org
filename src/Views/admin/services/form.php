<?php
// Service form (create/edit)
?>

<div class="flex items-center justify-between mb-6">
    <h3 class="text-lg font-bold text-slate-900"><?= $action === 'create' ? 'Create New Service' : 'Edit Service' ?></h3>
    <a href="<?= url('admin/services') ?>" class="text-slate-600 hover:text-slate-900 transition">
        <i class="fas fa-arrow-left mr-2"></i>Back to Services
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="<?= $action === 'create' ? url('admin/services/store') : url("admin/services/{$service['id']}/update") ?>" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

        <!-- Name -->
        <div>
            <label class="block text-sm font-semibold text-slate-900 mb-2">Service Name *</label>
            <input type="text" name="name" value="<?= htmlspecialchars($service['name'] ?? '') ?>" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Enter service name">
        </div>

        <!-- Slug -->
        <div>
            <label class="block text-sm font-semibold text-slate-900 mb-2">Slug *</label>
            <input type="text" name="slug" value="<?= htmlspecialchars($service['slug'] ?? '') ?>" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="service-slug">
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-semibold text-slate-900 mb-2">Description</label>
            <textarea name="description" rows="6" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Enter service description..."><?= htmlspecialchars($service['description'] ?? '') ?></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Lucide Icon</label>
                <input type="text" name="icon" value="<?= htmlspecialchars($service['icon'] ?? '') ?>" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="building">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Order</label>
                <input type="number" name="order_position" value="<?= htmlspecialchars($service['order_position'] ?? 0) ?>" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Image</label>
                <select name="image_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <option value="">No image</option>
                    <?php foreach (($assets ?? []) as $asset): ?>
                        <option value="<?= $asset['id'] ?>" <?= (string) ($service['image_id'] ?? '') === (string) $asset['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($asset['original_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Status -->
        <div>
            <label class="block text-sm font-semibold text-slate-900 mb-2">Status</label>
            <select name="status" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                <option value="active" <?= ($service['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= ($service['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>

        <!-- Submit -->
        <div class="flex gap-4">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                <i class="fas fa-save mr-2"></i><?= $action === 'create' ? 'Create Service' : 'Update Service' ?>
            </button>
            <a href="<?= url('admin/services') ?>" class="bg-slate-300 hover:bg-slate-400 text-slate-900 font-semibold py-2 px-6 rounded-lg transition">
                <i class="fas fa-times mr-2"></i>Cancel
            </a>
        </div>
    </form>
</div>
