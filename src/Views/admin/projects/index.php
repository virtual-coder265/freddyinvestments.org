<?php
// Projects list
?>

<div class="flex items-center justify-between mb-6">
    <h3 class="text-lg font-bold text-slate-900">Projects</h3>
    <a href="<?= url('admin/projects/create') ?>" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded-lg transition">
        <i class="fas fa-plus mr-2"></i>New Project
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Project</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Category</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Order</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Status</th>
                <th class="px-6 py-3 text-right text-xs font-semibold text-slate-600 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            <?php if (!empty($projects)): ?>
                <?php foreach ($projects as $project): ?>
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-900"><?= htmlspecialchars($project['title']) ?></p>
                            <p class="text-xs text-slate-500"><?= htmlspecialchars($project['slug']) ?></p>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600"><?= htmlspecialchars($project['category_label'] ?: $project['category']) ?></td>
                        <td class="px-6 py-4 text-sm text-slate-600"><?= (int) $project['order_position'] ?></td>
                        <td class="px-6 py-4">
                            <span class="<?= $project['status'] === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' ?> text-xs font-semibold px-3 py-1 rounded-full">
                                <?= ucfirst($project['status']) ?>
                            </span>
                            <?php if ((int) $project['featured'] === 1): ?>
                                <span class="ml-2 bg-amber-100 text-amber-700 text-xs font-semibold px-3 py-1 rounded-full">Featured</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="<?= url("admin/projects/{$project['id']}/edit") ?>" class="text-blue-600 hover:text-blue-800 font-semibold text-sm mr-4">Edit</a>
                            <form method="POST" action="<?= url("admin/projects/{$project['id']}/delete") ?>" class="inline" onsubmit="return confirm('Delete this project?');">
                                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-600">No projects yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
