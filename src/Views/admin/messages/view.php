<?php
// Message view/reply
?>

<div class="flex items-center justify-between mb-6">
    <h3 class="text-lg font-bold text-slate-900">Message from <?= htmlspecialchars($message['name']) ?></h3>
    <a href="<?= url('admin/messages') ?>" class="text-slate-600 hover:text-slate-900 transition">
        <i class="fas fa-arrow-left mr-2"></i>Back to Messages
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Message Content -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="border-b border-slate-200 pb-4 mb-4">
                <p class="text-sm text-slate-600">From</p>
                <h3 class="text-xl font-bold text-slate-900"><?= htmlspecialchars($message['name']) ?></h3>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-sm text-slate-600">Email</p>
                    <p class="font-semibold text-slate-900"><?= htmlspecialchars($message['email']) ?></p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Phone</p>
                    <p class="font-semibold text-slate-900"><?= htmlspecialchars($message['phone'] ?? 'Not provided') ?></p>
                </div>
            </div>

            <div class="mb-4">
                <p class="text-sm text-slate-600">Service Interested In</p>
                <p class="font-semibold text-slate-900"><?= htmlspecialchars($message['service'] ?? '-') ?></p>
            </div>

            <div class="border-t border-slate-200 pt-4">
                <p class="text-sm text-slate-600 mb-2">Message</p>
                <p class="text-slate-800 leading-relaxed"><?= nl2br(htmlspecialchars($message['message'])) ?></p>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-200 text-xs text-slate-500">
                <p><strong>Date:</strong> <?= date('M d, Y \a\t g:i A', strtotime($message['created_at'])) ?></p>
                <p><strong>Status:</strong> <?= ucfirst($message['status']) ?></p>
            </div>
        </div>

        <!-- Reply Form -->
        <?php if ($message['status'] !== 'replied'): ?>
            <div class="bg-white rounded-lg shadow p-6">
                <h4 class="text-lg font-bold text-slate-900 mb-4">Send Reply</h4>
                <form method="POST" action="<?= url('admin/messages/reply') ?>" class="space-y-4">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <input type="hidden" name="message_id" value="<?= $message['id'] ?>">

                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">Response *</label>
                        <textarea name="response" rows="6" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Type your response here..."></textarea>
                    </div>

                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                        <i class="fas fa-paper-plane mr-2"></i>Send Reply
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar Info -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="text-lg font-bold text-slate-900 mb-4">Quick Actions</h4>
            <div class="space-y-2">
                <a href="mailto:<?= htmlspecialchars($message['email']) ?>" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
                    <i class="fas fa-envelope mr-2"></i>Send Email
                </a>
                <?php if ($message['phone']): ?>
                    <a href="tel:<?= htmlspecialchars($message['phone']) ?>" class="block w-full text-center bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg transition">
                        <i class="fas fa-phone mr-2"></i>Call
                    </a>
                <?php endif; ?>
                <form method="POST" action="<?= url("admin/messages/{$message['id']}/delete") ?>" style="display:block;" onsubmit="return confirm('Delete this message?');">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <button type="submit" class="w-full text-center bg-red-600 hover:bg-red-700 text-white font-semibold py-2 rounded-lg transition">
                        <i class="fas fa-trash mr-2"></i>Delete Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
