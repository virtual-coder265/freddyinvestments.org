<?php
$heroSlides = [
    cms_content_image('home', 'hero', 'slide_1_image', 'hero4.jpeg'),
    cms_content_image('home', 'hero', 'slide_2_image', 'hero1.jpeg'),
    cms_content_image('home', 'hero', 'slide_3_image', 'hero2.jpeg'),
    cms_content_image('home', 'hero', 'slide_4_image', 'hero3.jpeg'),
    cms_content_image('home', 'hero', 'slide_5_image', 'banner5.jpeg'),
];
?>

<!-- Hero Section aligned to prototype.png -->
<section id="hero" data-hero-slider-section class="relative min-h-[85vh] flex items-center justify-center bg-slate-950 overflow-hidden py-16">
    <!-- Background image slider and overlay -->
    <div class="absolute inset-0 z-0 hero-slider" data-hero-slider data-hero-slider-interval="6500" aria-hidden="true">
        <?php foreach ($heroSlides as $index => $slide): ?>
            <div class="hero-slide<?php echo $index === 0 ? ' is-active' : ''; ?>" data-hero-slide>
                <img
                    src="<?php echo e($slide); ?>"
                    alt=""
                    class="hero-slide-image"
                    <?php echo $index === 0 ? 'fetchpriority="high"' : ''; ?>
                >
            </div>
        <?php endforeach; ?>
        <div class="absolute inset-0 hero-overlay-dark"></div>
    </div>
    
    <!-- Hero Contents -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-12">
        <div class="max-w-3xl text-left space-y-6">
            <span class="text-sm font-semibold font-mono tracking-widest text-gold-500 uppercase block">
                <?php echo e(cms_content('home', 'hero', 'eyebrow', 'Building Excellence')); ?>
            </span>
            
            <h1 class="text-4xl sm:text-6xl font-black font-display tracking-tight text-white leading-[1.1] reveal-fade-up">
                <?php
                $heroHeading = cms_content('home', 'hero', 'heading', "Transforming Spaces.\nCreating Legacies.");
                $heroLines = preg_split('/\r\n|\r|\n/', $heroHeading);
                echo e($heroLines[0] ?? $heroHeading);
                ?>
                <?php if (!empty($heroLines[1])): ?><br><span class="text-gold"><?php echo e($heroLines[1]); ?></span><?php endif; ?>
            </h1>
            
            <p class="text-base sm:text-lg text-slate-200 max-w-xl font-normal leading-relaxed reveal-fade-up" style="transition-delay: 0.08s;">
                <?php echo e(cms_content('home', 'hero', 'body', 'We deliver high-quality construction and landscaping solutions that are durable, functional and beautifully designed.')); ?>
            </p>
            
            <div class="pt-6 flex flex-wrap gap-4 reveal-fade-up" style="transition-delay: 0.16s;">
                <a href="<?php echo url('services'); ?>" 
                   class="bg-forest-solid inline-flex items-center justify-center px-6 py-3.5 rounded-lg text-sm font-bold shadow-lg transition-all duration-250">
                    <?php echo e(cms_content('home', 'hero', 'primary_cta', 'Our Services')); ?>
                </a>
                <a href="<?php echo url('portfolio'); ?>" 
                   class="inline-flex items-center justify-center px-6 py-3.5 border-2 border-white hover:bg-white hover:text-forest-950 text-white rounded-lg text-sm font-bold transition-all duration-250">
                    <?php echo e(cms_content('home', 'hero', 'secondary_cta', 'View Projects')); ?>
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom Slider Dots -->
    <div class="absolute bottom-8 left-0 right-0 z-10 flex justify-center gap-2" data-hero-slider-dots>
        <?php foreach ($heroSlides as $index => $slide): ?>
            <button
                type="button"
                class="slider-dot<?php echo $index === 0 ? ' active' : ''; ?>"
                data-hero-slide-dot="<?php echo $index; ?>"
                aria-label="Show hero image <?php echo $index + 1; ?>"
                aria-pressed="<?php echo $index === 0 ? 'true' : 'false'; ?>"
            ></button>
        <?php endforeach; ?>
    </div>
</section>

<!-- Floating Metrics Bar below Hero -->
<section class="relative z-20 -mt-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="floating-metrics-bar grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 p-8 gap-y-6">
        <?php
        $metricIcons = ['award', 'clock', 'users', 'smile'];
        for ($m = 1; $m <= 4; $m++):
        ?>
        <div class="flex items-start gap-4 px-2 <?= $m < 4 ? 'sm:metric-divider' : '' ?> <?= $m === 3 ? 'lg:metric-divider sm:pl-6' : ($m === 4 ? 'lg:pl-6' : ($m === 2 ? 'lg:metric-divider sm:pl-6' : '')) ?>">
            <div class="text-forest-800 mt-1">
                <i data-lucide="<?= $metricIcons[$m - 1] ?>" class="w-8 h-8"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold font-display text-forest-900 uppercase tracking-wide"><?php echo e(cms_content('home', 'metrics', 'metric_' . $m . '_title', 'Metric ' . $m)); ?></h3>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed"><?php echo e(cms_content('home', 'metrics', 'metric_' . $m . '_body', '')); ?></p>
            </div>
        </div>
        <?php endfor; ?>
    </div>
</section>

<!-- Welcome & Quote Request Form Section -->
<section id="about" class="py-24 bg-white text-slate-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- Left & Middle: Text + Double stacked images (Lg col span 8) -->
            <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Text block -->
                <div class="space-y-6 reveal-fade-up">
                    <span class="text-xs font-semibold font-mono tracking-widest text-forest-800 uppercase block"><?php echo e(cms_content('home', 'welcome', 'eyebrow', 'Welcome to Freddy Investments')); ?></span>
                    <h2 class="text-3xl font-black font-display text-forest-900 tracking-tight leading-tight">
                        <?php echo e(cms_content('home', 'welcome', 'heading', 'Building More Than Structures - We Build Lasting Relationships')); ?>
                    </h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        <?php echo e(cms_content('home', 'welcome', 'body', 'Freddy Investments is a trusted construction and landscaping company committed to bringing your vision to life. From modern builds to outdoor transformations, we combine expertise, creativity and integrity to deliver projects that stand the test of time.')); ?>
                    </p>
                    
                    <!-- Bullet lists with green checks -->
                    <ul class="space-y-3.5 text-sm font-semibold text-slate-800">
                        <?php for ($b = 1; $b <= 3; $b++): ?>
                        <li class="flex items-center">
                            <span class="w-5 h-5 rounded-full bg-forest-100 flex items-center justify-center mr-3 text-green-accent">
                                <i data-lucide="check" class="w-3.5 h-3.5"></i>
                            </span>
                            <?php echo e(cms_content('home', 'welcome', 'bullet_' . $b, '')); ?>
                        </li>
                        <?php endfor; ?>
                    </ul>

                    <div class="pt-4">
                        <a href="<?php echo url('about'); ?>" class="bg-forest-solid inline-flex items-center justify-center px-5 py-3 rounded-lg text-sm font-bold text-white shadow-md">
                            <?php echo e(cms_content('home', 'welcome', 'cta_label', 'Learn More About Us →')); ?>
                        </a>
                    </div>
                </div>

                <!-- Stacked images block -->
                <div class="welcome-image-stack flex flex-col gap-6 justify-center relative reveal-fade-in" style="transition-delay: 0.1s;">
                    <div class="relative w-11/12 rounded-2xl overflow-hidden shadow-lg border border-slate-100">
                        <img src="<?php echo e(cms_content_image('home', 'welcome', 'image_primary', 'project1.jpeg')); ?>" alt="Concrete building construction masonry site" class="w-full h-48 object-cover">
                    </div>
                    <div class="relative w-11/12 self-end rounded-2xl overflow-hidden shadow-lg border border-slate-100 -mt-8 z-10">
                        <img src="<?php echo e(cms_content_image('home', 'welcome', 'image_secondary', 'IMG-20260414-WA0133.jpg.jpeg')); ?>" alt="Stepping stones in a beautiful lawn garden" class="w-full h-48 object-cover">
                    </div>
                    
                    <!-- Overlapping 5+ years green badge -->
                    <div class="welcome-badge-5 absolute top-1/2 left-4 -translate-y-12 z-20 p-4 w-28 h-28 flex flex-col items-center justify-center text-center">
                        <span class="block text-3xl font-extrabold text-gold-500 font-display"><?php echo e(cms_content('home', 'welcome', 'badge_years', '5+')); ?></span>
                        <span class="block text-[8px] font-mono font-bold tracking-widest text-white uppercase mt-0.5"><?php echo e(cms_content('home', 'welcome', 'badge_label_1', 'Years of')); ?></span>
                        <span class="block text-[8px] font-mono font-bold tracking-widest text-white uppercase"><?php echo e(cms_content('home', 'welcome', 'badge_label_2', 'Excellence')); ?></span>
                    </div>
                </div>
            </div>

            <!-- Right: Get a Free Quotation Form (Lg col span 4) -->
            <div class="lg:col-span-4 reveal-fade-in" style="transition-delay: 0.15s;">
                <div class="quote-request-card">
                    <!-- Form Title bar -->
                    <div class="quote-card-header px-6 py-5 text-center">
                        <h3 class="text-lg font-bold text-white font-display tracking-tight"><?php echo e(cms_content('home', 'quote_form', 'title', 'Get a Free Quotation')); ?></h3>
                        <p class="text-xxs text-slate-300 mt-1"><?php echo e(cms_content('home', 'quote_form', 'subtitle', 'Tell us about your project and we will get back to you.')); ?></p>
                    </div>
                    
                    <!-- Session messages inside the form -->
                    <div class="px-6 pt-6">
                        <?php if (isset($_SESSION['form_success'])): ?>
                            <div class="p-3 bg-emerald-50/80 border border-emerald-200 rounded-lg text-xxs text-emerald-800 leading-normal mb-4">
                                <?php echo $_SESSION['form_success']; unset($_SESSION['form_success']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['form_errors']['security'])): ?>
                            <div class="p-3 bg-red-50/80 border border-red-200 rounded-lg text-xxs text-red-800 leading-normal mb-4">
                                <?php echo $_SESSION['form_errors']['security']; unset($_SESSION['form_errors']['security']); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php
                    $old = isset($_SESSION['form_old']) ? $_SESSION['form_old'] : [];
                    $errors = isset($_SESSION['form_errors']) ? $_SESSION['form_errors'] : [];
                    unset($_SESSION['form_old']);
                    unset($_SESSION['form_errors']);
                    ?>

                    <form id="secure-contact-form" action="<?php echo url('contact/submit'); ?>" method="POST" class="p-6 space-y-4">
                        <!-- CSRF Token -->
                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

                        <!-- Name -->
                        <div>
                            <input type="text" id="name" name="name" 
                                   value="<?php echo isset($old['name']) ? $old['name'] : ''; ?>" 
                                   placeholder="Full Name *" required
                                   class="form-input-corporate w-full px-3.5 py-2.5 text-xs">
                            <span class="form-error-msg text-[10px] text-red-500 mt-1 block"><?php echo isset($errors['name']) ? $errors['name'] : ''; ?></span>
                        </div>

                        <!-- Phone -->
                        <div>
                            <input type="text" id="phone" name="phone" 
                                   value="<?php echo isset($old['phone']) ? $old['phone'] : ''; ?>" 
                                   placeholder="Phone Number *" required
                                   class="form-input-corporate w-full px-3.5 py-2.5 text-xs">
                            <span class="form-error-msg text-[10px] text-red-500 mt-1 block"><?php echo isset($errors['phone']) ? $errors['phone'] : ''; ?></span>
                        </div>

                        <!-- Email -->
                        <div>
                            <input type="email" id="email" name="email" 
                                   value="<?php echo isset($old['email']) ? $old['email'] : ''; ?>" 
                                   placeholder="Email Address *" required
                                   class="form-input-corporate w-full px-3.5 py-2.5 text-xs">
                            <span class="form-error-msg text-[10px] text-red-500 mt-1 block"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
                        </div>

                        <!-- Service category selection -->
                        <div>
                            <select id="service" name="service" required
                                    class="form-input-corporate w-full px-3.5 py-2.5 text-xs bg-[#f8fafc]">
                                <option value="" disabled <?php echo !isset($old['service']) ? 'selected' : ''; ?>>Service Required *</option>
                                <?php if (!empty($services)): ?>
                                    <?php foreach ($services as $service): ?>
                                        <option value="<?php echo e($service['slug']); ?>" <?php echo (isset($old['service']) && $old['service'] === $service['slug']) ? 'selected' : ''; ?>><?php echo e($service['name']); ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="building" <?php echo (isset($old['service']) && $old['service'] === 'building') ? 'selected' : ''; ?>>Building Construction</option>
                                    <option value="landscaping" <?php echo (isset($old['service']) && $old['service'] === 'landscaping') ? 'selected' : ''; ?>>Landscaping Services</option>
                                    <option value="paving" <?php echo (isset($old['service']) && $old['service'] === 'paving') ? 'selected' : ''; ?>>Paving & Driveways</option>
                                    <option value="renovation" <?php echo (isset($old['service']) && $old['service'] === 'renovation') ? 'selected' : ''; ?>>Renovations & Extensions</option>
                                <?php endif; ?>
                            </select>
                            <span class="form-error-msg text-[10px] text-red-500 mt-1 block"><?php echo isset($errors['service']) ? $errors['service'] : ''; ?></span>
                        </div>

                        <!-- Message details -->
                        <div>
                            <textarea id="message" name="message" rows="3" required
                                      placeholder="Tell us about your project *"
                                      class="form-input-corporate w-full px-3.5 py-2.5 text-xs"><?php echo isset($old['message']) ? $old['message'] : ''; ?></textarea>
                            <span class="form-error-msg text-[10px] text-red-500 mt-1 block"><?php echo isset($errors['message']) ? $errors['message'] : ''; ?></span>
                        </div>

                        <!-- Submit quote request -->
                        <div class="pt-2">
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-3 bg-forest-900 hover:bg-forest-800 text-white font-bold rounded-lg text-xs tracking-wider uppercase transition-all duration-200">
                                <?php echo e(cms_content('home', 'quote_form', 'submit_label', 'Submit Request →')); ?>
                            </button>
                        </div>

                        <p class="text-[10px] text-slate-400 text-center flex items-center justify-center gap-1.5 pt-1.5 border-t border-slate-100">
                            <i data-lucide="lock" class="w-3 h-3 text-slate-400"></i> <?php echo e(cms_content('home', 'quote_form', 'privacy_note', 'We respect your privacy.')); ?>
                        </p>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Why Choose Us aligned to prototype.png -->
<section class="py-24 bg-sage-alternate border-y border-slate-100 text-slate-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Headers -->
        <div class="text-center max-w-3xl mx-auto mb-16 reveal-fade-up">
            <span class="text-xs font-semibold font-mono tracking-widest text-forest-800 uppercase block"><?php echo e(cms_content('home', 'why_choose_us', 'eyebrow', 'Why Choose Us')); ?></span>
            <h2 class="text-3xl sm:text-4xl font-black font-display text-forest-900 tracking-tight mt-2"><?php echo e(cms_content('home', 'why_choose_us', 'heading', 'We Deliver Value at Every Step')); ?></h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-8">
            <?php
            $valueIcons = ['clock', 'users', 'dollar-sign', 'search', 'handshake'];
            for ($v = 1; $v <= 5; $v++):
            ?>
            <div class="flex flex-col items-center text-center p-2 reveal-fade-up" style="transition-delay: <?php echo ($v - 1) * 0.05; ?>s;">
                <div class="text-forest-800 mb-4 bg-white p-3 rounded-full shadow-sm border border-slate-100">
                    <i data-lucide="<?php echo $valueIcons[$v - 1]; ?>" class="w-6 h-6"></i>
                </div>
                <h3 class="text-sm font-bold font-display text-forest-900 uppercase tracking-wide"><?php echo e(cms_content('home', 'why_choose_us', 'item_' . $v . '_title', '')); ?></h3>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed"><?php echo e(cms_content('home', 'why_choose_us', 'item_' . $v . '_body', '')); ?></p>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- Our Services Section with 4 dark green cards in a row aligned to prototype.png -->
<section id="services" class="py-24 bg-white text-slate-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 reveal-fade-up">
            <span class="text-xs font-semibold font-mono tracking-widest text-forest-800 uppercase block"><?php echo e(cms_content('home', 'service_cards', 'section_eyebrow', 'Our Services')); ?></span>
            <h2 class="text-3xl sm:text-4xl font-black font-display text-forest-900 tracking-tight mt-2 inline-block relative pb-4">
                <?php echo e(cms_content('home', 'service_cards', 'section_heading', 'Our Services')); ?>
                <span class="absolute bottom-0 left-1/4 right-1/4 h-1 bg-forest-800 rounded"></span>
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php
            $cardIcons = ['building', 'leaf', 'layout-grid', 'home'];
            $cardDefaults = [
                1 => ['project1.jpeg', 'Building construction masonry works'],
                2 => ['landscaping-banner1.jpeg', 'Lawn grass establishment garden design'],
                3 => ['IMG-20260414-WA0133.jpg.jpeg', 'Interlocking driveway paving brick walks'],
                4 => ['banner5.jpeg', 'House renovation construction villa extensions'],
            ];
            for ($c = 1; $c <= 4; $c++):
            ?>
            <div class="service-card-dark rounded-2xl overflow-hidden flex flex-col justify-between reveal-fade-up" style="transition-delay: <?php echo ($c - 1) * 0.05; ?>s;">
                <div>
                    <div class="relative h-48 overflow-hidden">
                        <img src="<?php echo e(cms_content_image('home', 'service_cards', 'card_' . $c . '_image', $cardDefaults[$c][0])); ?>" alt="<?php echo e($cardDefaults[$c][1]); ?>" class="w-full h-full object-cover">
                        <div class="service-icon-holder absolute -bottom-6 left-6 w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition-colors duration-300">
                            <i data-lucide="<?php echo $cardIcons[$c - 1]; ?>" class="w-5 h-5"></i>
                        </div>
                    </div>
                    <div class="p-6 pt-8 space-y-3">
                        <h3 class="text-lg font-bold text-white font-display"><?php echo e(cms_content('home', 'service_cards', 'card_' . $c . '_title', '')); ?></h3>
                        <p class="text-xs text-slate-400 leading-relaxed"><?php echo e(cms_content('home', 'service_cards', 'card_' . $c . '_body', '')); ?></p>
                    </div>
                </div>
                <div class="p-6 pt-0">
                    <a href="<?php echo url('services'); ?>" class="inline-flex items-center text-xs font-bold text-white hover:text-gold-500 transition-colors duration-150">
                        Learn More &nbsp;&rarr;
                    </a>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- Featured Projects Section with scrolling card designs aligned to prototype.png -->
<section id="projects" class="py-24 bg-forest-900 text-slate-300 relative overflow-hidden border-t border-forest-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left 1/3 Content column -->
            <div class="lg:col-span-4 space-y-6 reveal-fade-up">
                <span class="text-xs font-semibold font-mono tracking-widest text-gold-500 uppercase block"><?php echo e(cms_content('home', 'featured_projects', 'eyebrow', 'Featured Projects')); ?></span>
                <h2 class="text-3xl sm:text-4xl font-black font-display text-white tracking-tight leading-tight">
                    <?php echo e(cms_content('home', 'featured_projects', 'heading', 'See Our Work')); ?>
                </h2>
                <p class="text-xs text-slate-300 leading-relaxed">
                    <?php echo e(cms_content('home', 'featured_projects', 'body', '')); ?>
                </p>
                <div class="pt-4">
                    <a href="<?php echo url('portfolio'); ?>" class="inline-flex items-center justify-center px-5 py-3 border border-white/60 text-white hover:bg-white hover:text-forest-900 rounded-lg text-xs font-bold transition-all duration-200">
                        <?php echo e(cms_content('home', 'featured_projects', 'cta_label', 'View All Projects →')); ?>
                    </a>
                </div>
            </div>

            <!-- Right 2/3 horizontal scrolling image showcase -->
            <div class="lg:col-span-8 overflow-x-auto pb-4 flex gap-6 scrollbar-thin reveal-fade-in" style="transition-delay: 0.1s;">
                <?php if (!empty($projects)): ?>
                    <?php foreach ($projects as $project): ?>
                        <div class="min-w-[280px] sm:min-w-[320px] bg-forest-950 border border-white/5 rounded-2xl overflow-hidden shadow-xl shrink-0 group">
                            <div class="h-48 overflow-hidden relative">
                                <img src="<?php echo e(cms_image_url($project['image_id'], $project['fallback_image'] ?: 'project1.jpeg')); ?>" alt="<?php echo e($project['title']); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-103">
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php foreach (['project1.jpeg', 'project2.jpeg', 'project3.jpeg', 'banner1.jpeg'] as $fallbackProjectImage): ?>
                        <div class="min-w-[280px] sm:min-w-[320px] bg-forest-950 border border-white/5 rounded-2xl overflow-hidden shadow-xl shrink-0 group">
                            <div class="h-48 overflow-hidden relative">
                                <img src="<?php echo asset_url('images/' . $fallbackProjectImage); ?>" alt="Freddy Investments project" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-103">
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>

        </div>
    </div>
</section>

<?php if (!empty($quotes)): ?>
<!-- Testimonials Section -->
<section class="py-20 bg-white text-slate-700 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12 reveal-fade-up">
            <span class="text-xs font-semibold font-mono tracking-widest text-forest-800 uppercase block"><?php echo e(cms_content('home', 'testimonials', 'eyebrow', 'Client Feedback')); ?></span>
            <h2 class="text-3xl sm:text-4xl font-black font-display text-forest-900 tracking-tight mt-2"><?php echo e(cms_content('home', 'testimonials', 'heading', 'What Clients Say')); ?></h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php foreach (array_slice($quotes, 0, 3) as $index => $quote): ?>
                <div class="bg-[#f8fafc] border border-slate-100 rounded-2xl p-6 reveal-fade-up" style="transition-delay: <?php echo ($index * 0.05); ?>s;">
                    <div class="text-gold-500 mb-4">
                        <?php for ($i = 0; $i < (int) ($quote['rating'] ?? 5); $i++): ?>
                            <span>★</span>
                        <?php endfor; ?>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed">"<?php echo e($quote['quote_text']); ?>"</p>
                    <div class="mt-6">
                        <p class="font-bold text-forest-900 text-sm"><?php echo e($quote['client_name']); ?></p>
                        <?php if (!empty($quote['client_company'])): ?>
                            <p class="text-xs text-slate-500"><?php echo e($quote['client_company']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="py-16 bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            <?php
            $footerIcons = ['check-circle', 'trending-up', 'shield-check', 'users'];
            for ($fm = 1; $fm <= 4; $fm++):
            ?>
            <div class="flex items-center gap-4 justify-center reveal-fade-up" style="transition-delay: <?php echo ($fm - 1) * 0.05; ?>s;">
                <i data-lucide="<?php echo $footerIcons[$fm - 1]; ?>" class="w-6 h-6 text-forest-800 shrink-0"></i>
                <div class="text-left">
                    <h4 class="text-xs font-bold text-forest-900 uppercase font-display tracking-wider"><?php echo e(cms_content('home', 'footer_metrics', 'metric_' . $fm . '_title', '')); ?></h4>
                    <p class="text-[10px] text-slate-400 mt-0.5"><?php echo e(cms_content('home', 'footer_metrics', 'metric_' . $fm . '_body', '')); ?></p>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<?php if (!empty($tips)): ?>
<section class="py-20 bg-[#f8fafc] border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-xs font-semibold font-mono tracking-widest text-forest-800 uppercase block"><?php echo e(cms_content('home', 'latest_tips', 'eyebrow', 'Tips & Insights')); ?></span>
            <h2 class="text-3xl font-black font-display text-forest-900 mt-2"><?php echo e(cms_content('home', 'latest_tips', 'heading', 'Latest From Our Blog')); ?></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php foreach ($tips as $tip): ?>
                <article class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                    <h3 class="font-bold text-forest-900"><a href="<?php echo url('tips/' . ($tip['slug'] ?? slugify($tip['title']))); ?>"><?php echo e($tip['title']); ?></a></h3>
                    <p class="text-sm text-slate-600 mt-2"><?php echo e(substr(strip_tags($tip['content'] ?? ''), 0, 120)); ?>...</p>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-8">
            <a href="<?php echo url('tips'); ?>" class="inline-flex items-center text-sm font-bold text-forest-800">View all tips →</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Anchor link approach scrolling integration -->
<div id="approach" class="h-0 pointer-events-none"></div>
