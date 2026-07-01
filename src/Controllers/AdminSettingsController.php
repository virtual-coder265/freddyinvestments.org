<?php
namespace App\Controllers;

use App\Controllers\Admin\AdminController;
use App\Models\AuditLog;
use App\Models\BusinessSetting;

/**
 * Admin Settings Controller
 */
class AdminSettingsController extends AdminController {
    protected $currentPage = 'settings';
    protected $requiredRole = 'admin';

    public function index() {
        $settings = BusinessSetting::all();
        $tab = sanitize($_GET['tab'] ?? 'general');
        
        $this->render('settings/index', [
            'title' => 'Settings | Admin Panel',
            'settings' => $settings,
            'activeTab' => $tab,
            'breadcrumbs' => [
                ['label' => 'Settings & Tools', 'url' => url('admin/settings')],
                ['label' => 'Settings'],
            ],
        ]);
    }

    public function update() {
        $this->requirePost();
        $this->validateCsrfOrRedirect('admin/settings');

        $settings_to_update = [
            'site_name', 'site_description', 'company_email', 'company_phone',
            'company_phone_secondary', 'whatsapp_number', 'company_address',
            'footer_description', 'default_meta_description', 'default_meta_keywords',
            'social_facebook', 'social_instagram', 'social_twitter', 'social_linkedin',
            'about_company', 'business_hours',
        ];

        foreach ($settings_to_update as $key) {
            if (isset($_POST[$key])) {
                BusinessSetting::set($key, sanitize_cms($_POST[$key]));
            }
        }

        AuditLog::record('update', 'business_settings', null, 'Updated site settings');
        $tab = sanitize($_POST['tab'] ?? 'general');
        $this->redirect('admin/settings?tab=' . $tab, 'Settings updated successfully.');
    }

    public function fixEncodedContent() {
        $this->requirePost();
        $this->validateCsrfOrRedirect('admin/settings?tab=maintenance');

        $count = fix_encoded_content();
        AuditLog::record('maintenance', 'content', null, "Fixed {$count} encoded text field(s)");
        $this->redirect(
            'admin/settings?tab=maintenance',
            $count > 0
                ? "Repaired {$count} text field(s) with broken ampersands."
                : 'No encoded ampersands found — content is already clean.'
        );
    }
}
