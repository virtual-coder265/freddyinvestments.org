<?php
$siteName = cms_setting('site_name', 'Freddy Investments');
$siteDescription = cms_setting('site_description', 'Construction & Gardens');
$companyAddress = cms_setting('company_address', 'Box 3514, Monkey Bay, Mangochi');
$companyPhone = cms_setting('company_phone', '+265 (0) 997 991 077');
$companyEmail = cms_setting('company_email', 'mphasifreddyinvestments@gmail.com');
$facebookUrl = cms_setting('social_facebook', '#') ?: '#';
$instagramUrl = cms_setting('social_instagram', '#') ?: '#';
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo e($metaDescription ?? cms_setting('default_meta_description', 'Freddy Investments specializes in premium building construction and landscaping services. Transforming residential and commercial spaces in Malawi.')); ?>">
    <meta name="keywords" content="<?php echo e($metaKeywords ?? cms_setting('default_meta_keywords', 'construction, landscaping, bricklaying, roofing, paving, garden design, monkey bay, mangochi, malawi, building contractor')); ?>">
    <meta name="author" content="<?php echo e($siteName); ?>">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo e($title); ?>">
    <meta property="og:description" content="<?php echo e($metaDescription ?? cms_setting('default_meta_description', 'Transforming ideas into reality through quality construction and creative landscaping services in Malawi.')); ?>">
    <meta property="og:image" content="<?php echo asset_url('images/logo.png'); ?>">
    <meta property="og:url" content="<?php echo url(); ?>">
    <meta property="og:type" content="website">

    <title><?php echo e($title); ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo asset_url('images/favicon.png'); ?>">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        forest: {
                            50: '#f4f6f5',
                            100: '#e7ecea',
                            800: '#0d4235',
                            900: '#0a3329',
                            950: '#051c17',
                        },
                        gold: {
                            400: '#d2bd9f',
                            500: '#c5a880',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Custom Style Sheet -->
    <link rel="stylesheet" href="<?php echo asset_url('css/style.css'); ?>">
</head>
<body id="top" class="min-h-full flex flex-col bg-white text-slate-700 antialiased">

    <!-- Top Contact Bar aligned to prototype.png -->
    <div class="top-contact-bar w-full py-2.5 hidden sm:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between font-medium">
            <div class="flex items-center gap-6">
                <!-- Location -->
                <div class="flex items-center gap-1.5 hover:text-white transition-colors duration-150">
                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-gold-500"></i>
                    <span><?php echo e($companyAddress); ?></span>
                </div>
                <!-- Telephone -->
                <div class="flex items-center gap-1.5 hover:text-white transition-colors duration-150">
                    <i data-lucide="phone" class="w-3.5 h-3.5 text-gold-500"></i>
                    <a href="<?php echo e(phone_href($companyPhone)); ?>"><?php echo e($companyPhone); ?></a>
                </div>
            </div>
            
            <div class="flex items-center gap-6">
                <!-- Email -->
                <div class="flex items-center gap-1.5 hover:text-white transition-colors duration-150">
                    <i data-lucide="mail" class="w-3.5 h-3.5 text-gold-500"></i>
                    <a href="mailto:<?php echo e($companyEmail); ?>"><?php echo e($companyEmail); ?></a>
                </div>
                <!-- Social media -->
                <div class="flex items-center gap-3 border-l border-white/10 pl-4">
                    <a href="<?php echo e($facebookUrl); ?>" class="hover:text-white text-slate-300 transition-colors duration-150">
                        <i data-lucide="facebook" class="w-3.5 h-3.5"></i>
                    </a>
                    <a href="<?php echo e($instagramUrl); ?>" class="hover:text-white text-slate-300 transition-colors duration-150">
                        <i data-lucide="instagram" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Corporate Sticky Navigation Header -->
    <header class="sticky top-0 left-0 right-0 z-50">
        <nav class="corporate-nav w-full py-4 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    
                    <!-- Logo / Brand Title -->
                    <div class="flex-shrink-0">
                        <a href="<?php echo url(); ?>" class="flex items-center gap-3 group">
                            <img class="h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-103" src="<?php echo asset_url('images/logo.png'); ?>" alt="Freddy Investments Logo">
                            <div>
                                <span class="block text-lg font-bold font-display tracking-tight text-forest-900 uppercase"><?php echo e($siteName); ?></span>
                                <span class="block text-[10px] font-mono tracking-widest text-slate-400 group-hover:text-forest-800 uppercase transition-colors duration-200"><?php echo e($siteDescription); ?></span>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Desktop Menu Items (aligned to prototype.png) -->
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-center space-x-1 lg:space-x-2">
                            <?php
                            $navItems = [
                                'home' => ['label' => 'Home', 'route' => ''],
                                'about' => ['label' => 'About', 'route' => 'about'],
                                'services' => ['label' => 'Services', 'route' => 'services'],
                                'portfolio' => ['label' => 'Projects', 'route' => 'portfolio'],
                                'tips' => ['label' => 'Tips', 'route' => 'tips'],
                                'approach' => ['label' => 'Approach', 'route' => '#approach'],
                                'contact' => ['label' => 'Contact', 'route' => 'contact']
                            ];
                            
                            foreach ($navItems as $key => $item):
                                $isActive = ($currentPage === $key);
                                $isHash = (strpos($item['route'], '#') === 0);
                                $targetRoute = $isHash ? url() . $item['route'] : url($item['route']);
                                
                                $activeClass = $isActive 
                                    ? 'nav-link-active text-forest-900 rounded-none pb-1 font-semibold' 
                                    : 'text-slate-600 hover:text-forest-900 font-medium pb-1 border-b-2 border-transparent hover:border-forest-800/40 rounded-none';
                            ?>
                                <a href="<?php echo $targetRoute; ?>" 
                                   class="px-3.5 py-2 text-sm transition-all duration-150 <?php echo $activeClass; ?>">
                                    <?php echo $item['label']; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Get a Quote Action -->
                    <div class="hidden md:block">
                        <a href="<?php echo url('contact'); ?>" 
                           class="border-forest-btn inline-flex items-center justify-center px-5 py-2.5 border-2 text-sm font-semibold rounded-lg hover:shadow-md transition-all duration-200">
                            Get a Quote
                        </a>
                    </div>
                    
                    <!-- Mobile Hamburger Button -->
                    <div class="flex md:hidden">
                        <button id="mobile-menu-btn" type="button" 
                                class="inline-flex items-center justify-center p-2 rounded-lg text-slate-500 hover:text-forest-900 hover:bg-slate-50 focus:outline-none transition-colors duration-200" 
                                aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <!-- Menu Icon (Hamburger) -->
                            <svg class="h-6 w-6 block" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            <!-- Close Icon -->
                            <svg class="h-6 w-6 hidden" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                </div>
            </div>

            <!-- Mobile Menu Dropdown -->
            <div class="hidden md:hidden transition-all duration-350" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-slate-100 shadow-xl">
                    <?php foreach ($navItems as $key => $item): 
                        $isActive = ($currentPage === $key);
                        $isHash = (strpos($item['route'], '#') === 0);
                        $targetRoute = $isHash ? url() . $item['route'] : url($item['route']);
                        
                        $mobileActiveClass = $isActive 
                            ? 'bg-forest-50 text-forest-900 pl-4 border-l-4 border-forest-800 font-bold' 
                            : 'text-slate-600 hover:bg-slate-50 hover:text-forest-900 pl-3 font-medium';
                    ?>
                        <a href="<?php echo $targetRoute; ?>" 
                           class="block px-3 py-3 rounded-md text-base transition-all duration-150 <?php echo $mobileActiveClass; ?>">
                            <?php echo $item['label']; ?>
                        </a>
                    <?php endforeach; ?>
                    <div class="pt-4 pb-2 px-3">
                        <a href="<?php echo url('contact'); ?>" 
                           class="block w-full text-center px-4 py-3 bg-forest-900 hover:bg-forest-800 text-white font-bold rounded-lg transition-all duration-200">
                            Get a Quote
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Container -->
    <main class="flex-grow">
