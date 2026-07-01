<?php
// Pages list view
?>

<div class="flex items-center justify-between mb-6">
    <h3 class="text-lg font-bold text-slate-900">All Pages</h3>
    <a href="<?= url('admin/pages/create') ?>" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded-lg transition">
        <i class="fas fa-plus mr-2"></i>Create New Page
    </a>
</div>

<div class="bg-white rounded-lg shadow">
    <table class="w-full">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="text-left px-6 py-3 font-semibold text-slate-900">Title</th>
                <th class="text-left px-6 py-3 font-semibold text-slate-900">Slug</th>
                <th class="text-left px-6 py-3 font-semibold text-slate-900">Status</th>
                <th class="text-left px-6 py-3 font-semibold text-slate-900">Created</th>
                <th class="text-right px-6 py-3 font-semibold text-slate-900">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            <?php if (!empty($pages)): ?>
                <?php foreach ($pages as $page): ?>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 font-semibold text-slate-900"><?= htmlspecialchars($page['title']) ?></td>
                        <td class="px-6 py-4 text-slate-600"><?= htmlspecialchars($page['slug']) ?></td>
                        <td class="px-6 py-4">
                            <span class="<?= $page['status'] === 'published' ? 'bg-emerald-100 text-emerald-700' : 'bg-yellow-100 text-yellow-700' ?> text-xs px-3 py-1 rounded-full font-semibold">
                                <?= ucfirst($page['status']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-sm"><?= date('M d, Y', strtotime($page['created_at'])) ?></td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="<?= url("admin/pages/{$page['id']}/edit") ?>" class="text-blue-600 hover:text-blue-800 transition font-semibold">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                            <form method="POST" action="<?= url("admin/pages/{$page['id']}/delete") ?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this page?');">
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
                    <td colspan="5" class="px-6 py-8 text-center text-slate-600">
                        <i class="fas fa-file-lines text-3xl mb-3 opacity-50"></i>
                        <p>No pages found. <a href="<?= url('admin/pages/create') ?>" class="text-emerald-600 hover:text-emerald-700 font-semibold">Create one now</a></p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
