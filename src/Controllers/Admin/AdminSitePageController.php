<?php
namespace App\Controllers\Admin;

use App\Admin\Breadcrumb;
use App\Admin\ContentSchema;
use App\Auth\AuthManager;
use App\Models\Asset;
use App\Models\AuditLog;
use App\Models\ContentSection;

/**
 * Page-centric site content editors.
 */
class AdminSitePageController extends AdminController {
    public function edit($page) {
        $pages = ContentSchema::pages();
        if (!in_array($page, $pages, true)) {
            $this->redirect('admin/site/home', 'Page not found.', 'error');
        }

        $meta = ContentSchema::pageMeta()[$page];
        $sections = ContentSchema::fieldsForPage($page);
        $firstSection = array_key_first($sections);

        $this->render('site/edit', [
            'title' => $meta['label'] . ' | Site Pages',
            'currentPage' => 'site-' . $page,
            'pageKey' => $page,
            'pageMeta' => $meta,
            'sections' => $sections,
            'activeSection' => $firstSection,
            'assets' => Asset::byType('image'),
            'linkedEntities' => ContentSchema::linkedEntities($page),
            'breadcrumbs' => Breadcrumb::forSitePage($page),
        ]);
    }

    public function update($page) {
        $this->requirePost();

        $pages = ContentSchema::pages();
        if (!in_array($page, $pages, true)) {
            $this->redirect('admin/site/home', 'Page not found.', 'error');
        }

        $this->validateCsrfOrRedirect('admin/site/' . $page);

        $sections = ContentSchema::fieldsForPage($page);

        foreach ($sections as $section => $fields) {
            foreach ($fields as $field => $meta) {
                $inputName = "{$page}__{$section}__{$field}";
                $type = $meta['type'] ?? 'text';

                if ($type === 'toggle') {
                    $value = isset($_POST[$inputName]) && $_POST[$inputName] === '1' ? '1' : '0';
                } else {
                    $value = $_POST[$inputName] ?? '';
                }

                if ($type === 'image') {
                    $value = $value === '' ? '' : (string) intval($value);
                }

                ContentSection::setValue(
                    $page,
                    $section,
                    $field,
                    sanitize_cms($value),
                    $type === 'toggle' ? 'text' : $type,
                    $meta['label'] ?? null,
                    AuthManager::id()
                );
            }
        }

        AuditLog::record('update', 'content_sections', null, ['page' => $page]);
        $this->redirect('admin/site/' . $page, ucfirst($page) . ' page updated successfully.');
    }
}
