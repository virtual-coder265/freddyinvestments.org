<?php
namespace App\Admin;

use App\Models\Message;

/**
 * Single source of truth for admin navigation.
 */
class AdminMenu {
    public static function groups($currentPage = '') {
        $unread = 0;
        try {
            $unread = Message::count("status = ?", ['unread']);
        } catch (\Throwable $e) {
            $unread = 0;
        }

        return [
            [
                'id' => 'dashboard',
                'label' => 'Dashboard',
                'icon' => 'fa-chart-line',
                'url' => url('admin/dashboard'),
                'active' => $currentPage === 'dashboard',
            ],
            [
                'id' => 'site-pages',
                'label' => 'Site Pages',
                'icon' => 'fa-file-lines',
                'open' => strpos($currentPage, 'site-') === 0,
                'children' => [
                    ['id' => 'site-home', 'label' => 'Homepage', 'url' => url('admin/site/home'), 'active' => $currentPage === 'site-home', 'preview' => url('/')],
                    ['id' => 'site-about', 'label' => 'About', 'url' => url('admin/site/about'), 'active' => $currentPage === 'site-about', 'preview' => url('about')],
                    ['id' => 'site-services', 'label' => 'Services Page', 'url' => url('admin/site/services'), 'active' => $currentPage === 'site-services', 'preview' => url('services')],
                    ['id' => 'site-portfolio', 'label' => 'Portfolio Page', 'url' => url('admin/site/portfolio'), 'active' => $currentPage === 'site-portfolio', 'preview' => url('portfolio')],
                    ['id' => 'site-contact', 'label' => 'Contact Page', 'url' => url('admin/site/contact'), 'active' => $currentPage === 'site-contact', 'preview' => url('contact')],
                ],
            ],
            [
                'id' => 'content-library',
                'label' => 'Content Library',
                'icon' => 'fa-layer-group',
                'open' => in_array($currentPage, ['services', 'projects', 'quotes', 'tips'], true),
                'children' => [
                    ['id' => 'services', 'label' => 'Services', 'url' => url('admin/services'), 'active' => $currentPage === 'services'],
                    ['id' => 'projects', 'label' => 'Projects', 'url' => url('admin/projects'), 'active' => $currentPage === 'projects'],
                    ['id' => 'quotes', 'label' => 'Testimonials', 'url' => url('admin/quotes'), 'active' => $currentPage === 'quotes'],
                    ['id' => 'tips', 'label' => 'Tips & Blog', 'url' => url('admin/tips'), 'active' => $currentPage === 'tips'],
                ],
            ],
            [
                'id' => 'media',
                'label' => 'Media Library',
                'icon' => 'fa-images',
                'url' => url('admin/media'),
                'active' => $currentPage === 'media',
            ],
            [
                'id' => 'settings-tools',
                'label' => 'Settings & Tools',
                'icon' => 'fa-cog',
                'open' => in_array($currentPage, ['settings', 'messages', 'activity'], true),
                'children' => [
                    ['id' => 'settings', 'label' => 'Settings', 'url' => url('admin/settings'), 'active' => $currentPage === 'settings'],
                    ['id' => 'messages', 'label' => 'Messages', 'url' => url('admin/messages'), 'active' => $currentPage === 'messages', 'badge' => $unread > 0 ? (string) $unread : null],
                    ['id' => 'activity', 'label' => 'Activity Log', 'url' => url('admin/activity'), 'active' => $currentPage === 'activity'],
                ],
            ],
        ];
    }
}
