<?php
$settings = $settings ?? [];
$activeTab = $activeTab ?? 'general';
$tabs = [
    'general' => 'General',
    'contact' => 'Contact',
    'social' => 'Social & SEO',
    'maintenance' => 'Maintenance',
];
?>

<div class="admin-page-header">
    <h3 style="margin:0;font-size:1.125rem;font-weight:700;">Site Settings</h3>
</div>

<div class="admin-settings-tabs admin-tabs">
    <?php foreach ($tabs as $key => $label): ?>
        <a href="<?= url('admin/settings?tab=' . $key) ?>" class="admin-tab <?= $activeTab === $key ? 'active' : '' ?>" style="text-decoration:none;" data-tab="<?= $key ?>"><?= htmlspecialchars($label) ?></a>
    <?php endforeach; ?>
</div>

<div class="admin-card">
    <form method="POST" action="<?= url('admin/settings/update') ?>" class="admin-card-body" data-admin-form>
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        <input type="hidden" name="tab" value="<?= htmlspecialchars($activeTab) ?>">

        <?php if ($activeTab === 'general'): ?>
            <div class="admin-grid-2">
                <div class="admin-field">
                    <label>Site Name</label>
                    <input type="text" name="site_name" value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>" class="admin-input">
                </div>
                <div class="admin-field">
                    <label>Site Description</label>
                    <input type="text" name="site_description" value="<?= htmlspecialchars($settings['site_description'] ?? '') ?>" class="admin-input">
                </div>
                <div class="admin-field admin-grid-span-2">
                    <label>Footer Description</label>
                    <textarea name="footer_description" class="admin-textarea" rows="3"><?= htmlspecialchars($settings['footer_description'] ?? '') ?></textarea>
                </div>
                <div class="admin-field admin-grid-span-2">
                    <label>About Company</label>
                    <textarea name="about_company" class="admin-textarea" rows="4"><?= htmlspecialchars($settings['about_company'] ?? '') ?></textarea>
                </div>
            </div>
        <?php elseif ($activeTab === 'contact'): ?>
            <div class="admin-grid-2">
                <div class="admin-field"><label>Email</label><input type="email" name="company_email" value="<?= htmlspecialchars($settings['company_email'] ?? '') ?>" class="admin-input"></div>
                <div class="admin-field"><label>Phone</label><input type="tel" name="company_phone" value="<?= htmlspecialchars($settings['company_phone'] ?? '') ?>" class="admin-input"></div>
                <div class="admin-field"><label>Secondary Phone</label><input type="tel" name="company_phone_secondary" value="<?= htmlspecialchars($settings['company_phone_secondary'] ?? '') ?>" class="admin-input"></div>
                <div class="admin-field"><label>WhatsApp</label><input type="tel" name="whatsapp_number" value="<?= htmlspecialchars($settings['whatsapp_number'] ?? '') ?>" class="admin-input"></div>
                <div class="admin-field admin-grid-span-2"><label>Address</label><textarea name="company_address" class="admin-textarea" rows="2"><?= htmlspecialchars($settings['company_address'] ?? '') ?></textarea></div>
                <div class="admin-field admin-grid-span-2"><label>Business Hours</label><textarea name="business_hours" class="admin-textarea" rows="3"><?= htmlspecialchars($settings['business_hours'] ?? '') ?></textarea></div>
            </div>
        <?php elseif ($activeTab === 'maintenance'): ?>
            <p style="font-size:.875rem;color:#64748b;margin:0 0 1rem;">
                Repairs text stored with broken ampersands (e.g. <code>&amp;amp;</code> showing on the site instead of <code>&amp;</code>).
                Safe to run more than once.
            </p>
            <button type="submit" formaction="<?= url('admin/settings/fix-encoded-content') ?>" class="admin-btn admin-btn-primary">
                <i class="fas fa-wrench"></i> Repair Encoded Ampersands
            </button>
        <?php else: ?>
            <div class="admin-grid-2">
                <div class="admin-field"><label>Facebook URL</label><input type="url" name="social_facebook" value="<?= htmlspecialchars($settings['social_facebook'] ?? '') ?>" class="admin-input"></div>
                <div class="admin-field"><label>Instagram URL</label><input type="url" name="social_instagram" value="<?= htmlspecialchars($settings['social_instagram'] ?? '') ?>" class="admin-input"></div>
                <div class="admin-field"><label>Twitter URL</label><input type="url" name="social_twitter" value="<?= htmlspecialchars($settings['social_twitter'] ?? '') ?>" class="admin-input"></div>
                <div class="admin-field"><label>LinkedIn URL</label><input type="url" name="social_linkedin" value="<?= htmlspecialchars($settings['social_linkedin'] ?? '') ?>" class="admin-input"></div>
                <div class="admin-field admin-grid-span-2"><label>Default Meta Description</label><textarea name="default_meta_description" class="admin-textarea" rows="2"><?= htmlspecialchars($settings['default_meta_description'] ?? '') ?></textarea></div>
                <div class="admin-field admin-grid-span-2"><label>Default Meta Keywords</label><input type="text" name="default_meta_keywords" value="<?= htmlspecialchars($settings['default_meta_keywords'] ?? '') ?>" class="admin-input"></div>
            </div>
        <?php endif; ?>

        <?php if ($activeTab !== 'maintenance'): ?>
        <div class="admin-save-bar" style="margin:1.5rem -1.5rem -1.5rem;">
            <span style="font-size:.8125rem;color:#64748b;">Settings apply site-wide.</span>
            <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Save Settings</button>
        </div>
        <?php endif; ?>
    </form>
</div>
