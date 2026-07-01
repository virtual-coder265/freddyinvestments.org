<?php
// Quote form (create/edit)
?>

<div class="flex items-center justify-between mb-6">
    <h3 class="text-lg font-bold text-slate-900"><?= $action === 'create' ? 'Add New Quote' : 'Edit Quote' ?></h3>
    <a href="<?= url('admin/quotes') ?>" class="text-slate-600 hover:text-slate-900 transition">
        <i class="fas fa-arrow-left mr-2"></i>Back to Quotes
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="<?= $action === 'create' ? url('admin/quotes/store') : url("admin/quotes/{$quote['id']}/update") ?>" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

        <!-- Client Name -->
        <div>
            <label class="block text-sm font-semibold text-slate-900 mb-2">Client Name *</label>
            <input type="text" name="client_name" value="<?= htmlspecialchars($quote['client_name'] ?? '') ?>" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Enter client name">
        </div>

        <!-- Company -->
        <div>
            <label class="block text-sm font-semibold text-slate-900 mb-2">Company</label>
            <input type="text" name="client_company" value="<?= htmlspecialchars($quote['client_company'] ?? '') ?>" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Client company name">
        </div>

        <!-- Quote Text -->
        <div>
            <label class="block text-sm font-semibold text-slate-900 mb-2">Quote *</label>
            <textarea name="quote_text" rows="6" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Enter the testimonial/quote text..."><?= htmlspecialchars($quote['quote_text'] ?? '') ?></textarea>
        </div>

        <!-- Rating -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Rating</label>
                <select name="rating" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <?php for ($rating = 1; $rating <= 5; $rating++): ?>
                        <option value="<?= $rating ?>" <?= (int) ($quote['rating'] ?? 5) === $rating ? 'selected' : '' ?>><?= $rating ?> Star<?= $rating === 1 ? '' : 's' ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Client Image</label>
                <select name="image_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <option value="">No image</option>
                    <?php foreach (($assets ?? []) as $asset): ?>
                        <option value="<?= $asset['id'] ?>" <?= (string) ($quote['image_id'] ?? '') === (string) $asset['id'] ? 'selected' : '' ?>>
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
                <option value="active" <?= ($quote['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= ($quote['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>

        <!-- Submit -->
        <div class="flex gap-4">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                <i class="fas fa-save mr-2"></i><?= $action === 'create' ? 'Add Quote' : 'Update Quote' ?>
            </button>
            <a href="<?= url('admin/quotes') ?>" class="bg-slate-300 hover:bg-slate-400 text-slate-900 font-semibold py-2 px-6 rounded-lg transition">
                <i class="fas fa-times mr-2"></i>Cancel
            </a>
        </div>
    </form>
</div>
