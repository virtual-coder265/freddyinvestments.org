<?php
namespace App\Controllers;

use App\Models\Project;
use App\Models\Quote;
use App\Models\Service;
use App\Models\Tip;

/**
 * PageController - Manages core page views rendering
 */
class PageController {
    
    /**
     * Reusable renderer that loads header, specific page view, and footer templates
     */
    protected function render($view, $data = []) {
        // Extract array keys into variable names
        extract($data);
        
        // Fallback title
        $title = isset($title) ? $title : 'Freddy Investments | Building Construction & Landscaping';
        $currentPage = isset($currentPage) ? $currentPage : '';
        $metaDescription = $metaDescription ?? cms_setting('default_meta_description', 'Freddy Investments specializes in premium building construction and landscaping services. Transforming residential and commercial spaces in Malawi.');
        $metaKeywords = $metaKeywords ?? cms_setting('default_meta_keywords', 'construction, landscaping, bricklaying, roofing, paving, garden design, monkey bay, mangochi, malawi, building contractor');
        
        // Paths to templates
        $headerPath = __DIR__ . '/../Views/layout/header.php';
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';
        $footerPath = __DIR__ . '/../Views/layout/footer.php';
        
        if (file_exists($headerPath)) {
            require_once $headerPath;
        }
        
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            echo "<div class='p-12 text-center text-red-500'>Error: View file [{$view}] not found.</div>";
        }
        
        if (file_exists($footerPath)) {
            require_once $footerPath;
        }
    }

    public function home() {
        $tipsCount = (int) cms_content('home', 'latest_tips', 'count', '3');
        $showTips = cms_toggle('home', 'latest_tips', 'show_section', '0');

        $this->render('home', [
            'title' => 'Freddy Investments | Construction & Landscaping Services',
            'currentPage' => 'home',
            'services' => $this->activeServices(),
            'projects' => $this->featuredProjects(),
            'quotes' => cms_toggle('home', 'testimonials', 'show_section', '1') ? $this->activeQuotes() : [],
            'tips' => $showTips ? $this->recentTips($tipsCount) : [],
            'showTestimonials' => cms_toggle('home', 'testimonials', 'show_section', '1'),
        ]);
    }

    public function about() {
        $this->render('about', [
            'title' => 'About Us | Freddy Investments',
            'currentPage' => 'about'
        ]);
    }

    public function services() {
        $this->render('services', [
            'title' => 'Our Services | Freddy Investments',
            'currentPage' => 'services',
            'services' => $this->activeServices()
        ]);
    }

    public function portfolio() {
        $this->render('portfolio', [
            'title' => 'Project Portfolio & Gallery | Freddy Investments',
            'currentPage' => 'portfolio',
            'projects' => $this->activeProjects()
        ]);
    }

    public function contact() {
        $this->render('contact', [
            'title' => 'Contact Us | Freddy Investments',
            'currentPage' => 'contact',
            'services' => $this->activeServices()
        ]);
    }

    public function tipsIndex() {
        $this->render('tips/index', [
            'title' => 'Tips & Blog | Freddy Investments',
            'currentPage' => 'tips',
            'tips' => $this->recentTips(50),
        ]);
    }

    public function tipsShow($slug) {
        $tip = Tip::findBySlug($slug);
        if (!$tip) {
            http_response_code(404);
            header('Location: ' . url('tips'));
            exit;
        }

        $this->render('tips/show', [
            'title' => $tip['title'] . ' | Freddy Investments',
            'currentPage' => 'tips',
            'tip' => $tip,
        ]);
    }

    protected function activeServices() {
        try {
            return Service::active();
        } catch (\Throwable $e) {
            return [];
        }
    }

    protected function activeProjects() {
        try {
            return Project::active();
        } catch (\Throwable $e) {
            return [];
        }
    }

    protected function featuredProjects() {
        try {
            return Project::featured(6);
        } catch (\Throwable $e) {
            return [];
        }
    }

    protected function activeQuotes() {
        try {
            return Quote::active();
        } catch (\Throwable $e) {
            return [];
        }
    }

    protected function recentTips($limit = 3) {
        try {
            return Tip::recent($limit);
        } catch (\Throwable $e) {
            return [];
        }
    }
}
