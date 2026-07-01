<?php
// Tips list view
?>

<div class="flex items-center justify-between mb-6">
    <h3 class="text-lg font-bold text-slate-900">All Tips</h3>
    <a href="<?= url('admin/tips/create') ?>" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded-lg transition">
        <i class="fas fa-plus mr-2"></i>Create New Tip
    </a>
</div>

<div class="bg-white rounded-lg shadow">
    <table class="w-full">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="text-left px-6 py-3 font-semibold text-slate-900">Title</th>
                <th class="text-left px-6 py-3 font-semibold text-slate-900">Category</th>
                <th class="text-left px-6 py-3 font-semibold text-slate-900">Status</th>
                <th class="text-right px-6 py-3 font-semibold text-slate-900">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            <?php if (!empty($tips)): ?>
                <?php foreach ($tips as $tip): ?>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-semibold text-slate-900"><?= htmlspecialchars($tip['title']) ?></td>
                        <td class="px-6 py-4 text-slate-600"><?= htmlspecialchars($tip['category'] ?? '-') ?></td>
                        <td class="px-6 py-4">
                            <span class="<?= $tip['status'] === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' ?> text-xs px-3 py-1 rounded-full font-semibold">
                                <?= ucfirst($tip['status']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="<?= url("admin/tips/{$tip['id']}/edit") ?>" class="text-blue-600 hover:text-blue-800 transition font-semibold">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                            <form method="POST" action="<?= url("admin/tips/{$tip['id']}/delete") ?>" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                                <button type="submit" class="text-red-600 hover:text-red-800 transition font-semibold">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-slate-600">
                        <i class="fas fa-lightbulb text-3xl mb-3 opacity-50"></i>
                        <p>No tips found. <a href="<?= url('admin/tips/create') ?>" class="text-emerald-600 hover:text-emerald-700 font-semibold">Create one now</a></p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
