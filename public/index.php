<?php
/**
 * Freddy Investments - Front Controller
 */

require_once __DIR__ . '/../src/bootstrap.php';

use App\Router;
use App\Database\DatabaseInitializer;

// Run lightweight schema migrations on each request
try {
    (new DatabaseInitializer())->migrate();
} catch (\Throwable $e) {
    error_log('Migration skipped: ' . $e->getMessage());
}

$router = new Router();

// ============================================
// PUBLIC ROUTES
// ============================================

$router->get('', 'App\Controllers\PageController@home');
$router->get('home', 'App\Controllers\PageController@home');
$router->get('about', 'App\Controllers\PageController@about');
$router->get('services', 'App\Controllers\PageController@services');
$router->get('portfolio', 'App\Controllers\PageController@portfolio');
$router->get('contact', 'App\Controllers\PageController@contact');
$router->get('tips', 'App\Controllers\PageController@tipsIndex');
$router->get('tips/{slug}', 'App\Controllers\PageController@tipsShow');

$router->post('contact/submit', 'App\Controllers\ContactController@submit');

// ============================================
// ADMIN ROUTES
// ============================================

$router->get('admin', 'App\Controllers\AdminAuthController@entry');
$router->get('admin/login', 'App\Controllers\AdminAuthController@showLogin');
$router->post('admin/login-process', 'App\Controllers\AdminAuthController@login');
$router->get('admin/logout', 'App\Controllers\AdminAuthController@logout');

$router->get('admin/dashboard', 'App\Controllers\AdminDashboardController@index');

// Site page editors (page-centric CMS)
$router->get('admin/site/{page}', 'App\Controllers\Admin\AdminSitePageController@edit');
$router->post('admin/site/{page}/update', 'App\Controllers\Admin\AdminSitePageController@update');

// Legacy content route — redirect handled in controller
$router->get('admin/content', 'App\Controllers\AdminContentController@index');
$router->post('admin/content/update', 'App\Controllers\AdminContentController@update');

// Legacy pages CRUD — redirect handled in controller
$router->get('admin/pages', 'App\Controllers\AdminPagesController@index');
$router->get('admin/pages/create', 'App\Controllers\AdminPagesController@create');
$router->post('admin/pages/store', 'App\Controllers\AdminPagesController@store');
$router->get('admin/pages/{id}/edit', 'App\Controllers\AdminPagesController@edit');
$router->post('admin/pages/{id}/update', 'App\Controllers\AdminPagesController@update');
$router->post('admin/pages/{id}/delete', 'App\Controllers\AdminPagesController@delete');

// Content Library
$router->get('admin/services', 'App\Controllers\AdminServicesController@index');
$router->get('admin/services/create', 'App\Controllers\AdminServicesController@create');
$router->post('admin/services/store', 'App\Controllers\AdminServicesController@store');
$router->get('admin/services/{id}/edit', 'App\Controllers\AdminServicesController@edit');
$router->post('admin/services/{id}/update', 'App\Controllers\AdminServicesController@update');
$router->post('admin/services/{id}/delete', 'App\Controllers\AdminServicesController@delete');

$router->get('admin/projects', 'App\Controllers\AdminProjectsController@index');
$router->get('admin/projects/create', 'App\Controllers\AdminProjectsController@create');
$router->post('admin/projects/store', 'App\Controllers\AdminProjectsController@store');
$router->get('admin/projects/{id}/edit', 'App\Controllers\AdminProjectsController@edit');
$router->post('admin/projects/{id}/update', 'App\Controllers\AdminProjectsController@update');
$router->post('admin/projects/{id}/delete', 'App\Controllers\AdminProjectsController@delete');

$router->get('admin/tips', 'App\Controllers\AdminTipsController@index');
$router->get('admin/tips/create', 'App\Controllers\AdminTipsController@create');
$router->post('admin/tips/store', 'App\Controllers\AdminTipsController@store');
$router->get('admin/tips/{id}/edit', 'App\Controllers\AdminTipsController@edit');
$router->post('admin/tips/{id}/update', 'App\Controllers\AdminTipsController@update');
$router->post('admin/tips/{id}/delete', 'App\Controllers\AdminTipsController@delete');

$router->get('admin/quotes', 'App\Controllers\AdminQuotesController@index');
$router->get('admin/quotes/create', 'App\Controllers\AdminQuotesController@create');
$router->post('admin/quotes/store', 'App\Controllers\AdminQuotesController@store');
$router->get('admin/quotes/{id}/edit', 'App\Controllers\AdminQuotesController@edit');
$router->post('admin/quotes/{id}/update', 'App\Controllers\AdminQuotesController@update');
$router->post('admin/quotes/{id}/delete', 'App\Controllers\AdminQuotesController@delete');

// Settings & Tools
$router->get('admin/messages', 'App\Controllers\AdminMessagesController@index');
$router->get('admin/messages/{id}/view', 'App\Controllers\AdminMessagesController@view');
$router->post('admin/messages/reply', 'App\Controllers\AdminMessagesController@reply');
$router->post('admin/messages/{id}/delete', 'App\Controllers\AdminMessagesController@delete');

$router->get('admin/settings', 'App\Controllers\AdminSettingsController@index');
$router->post('admin/settings/update', 'App\Controllers\AdminSettingsController@update');
$router->post('admin/settings/fix-encoded-content', 'App\Controllers\AdminSettingsController@fixEncodedContent');

$router->get('admin/activity', 'App\Controllers\Admin\AdminActivityController@index');

// Media Library (new routes + legacy asset redirects)
$router->get('admin/media', 'App\Controllers\Admin\AdminMediaController@index');
$router->post('admin/media/upload', 'App\Controllers\Admin\AdminMediaController@upload');
$router->post('admin/media/{id}/update', 'App\Controllers\Admin\AdminMediaController@update');
$router->post('admin/media/{id}/delete', 'App\Controllers\Admin\AdminMediaController@delete');

$router->get('admin/assets', 'App\Controllers\AdminAssetsController@index');
$router->post('admin/assets/upload', 'App\Controllers\AdminAssetsController@upload');
$router->post('admin/assets/{id}/update', 'App\Controllers\AdminAssetsController@update');
$router->post('admin/assets/{id}/delete', 'App\Controllers\AdminAssetsController@delete');

$route = isset($_GET['route']) ? trim($_GET['route'], '/') : '';
$router->resolve($route);
