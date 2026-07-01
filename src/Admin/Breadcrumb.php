<?php
namespace App\Admin;

/**
 * Breadcrumb trail builder for admin screens.
 */
class Breadcrumb {
    public static function make(array $items) {
        return $items;
    }

    public static function forSitePage($pageKey, $sectionLabel = null) {
        $pages = ContentSchema::pageMeta();
        $meta = $pages[$pageKey] ?? ['label' => ucfirst($pageKey)];

        $items = [
            ['label' => 'Site Pages', 'url' => url('admin/site/home')],
            ['label' => $meta['label'], 'url' => url('admin/site/' . $pageKey)],
        ];

        if ($sectionLabel !== null) {
            $items[] = ['label' => $sectionLabel];
        }

        return $items;
    }
}
