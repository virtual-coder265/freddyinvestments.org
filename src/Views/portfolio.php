<!-- Header Hero -->
<section class="relative bg-forest-950 py-20 overflow-hidden border-b border-forest-900/60">
    <div class="absolute inset-0 z-0 opacity-25">
        <img src="<?php echo e(cms_content_image('portfolio', 'hero', 'background_image', 'banner3.jpeg')); ?>" alt="Portfolio Banner background" class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-forest-950/70"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mt-6">
        <span class="text-xs font-semibold font-mono tracking-widest text-gold-500 uppercase block"><?php echo e(cms_content('portfolio', 'hero', 'eyebrow', 'Our Masterpieces')); ?></span>
        <h1 class="text-4xl sm:text-5xl font-black font-display text-white tracking-tight mt-2">
            <?php echo e(cms_content('portfolio', 'hero', 'heading', 'Project Capability Portfolio')); ?>
        </h1>
        <p class="text-slate-300 mt-4 max-w-2xl mx-auto text-sm sm:text-base">
            <?php echo e(cms_content('portfolio', 'hero', 'body', 'Witness our master craftsmanship firsthand. Explore our actual construction works and landscape designs.')); ?>
        </p>
    </div>
</section>

<!-- Filterable Grid -->
<section class="py-24 bg-white text-slate-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h2 class="text-2xl font-black font-display text-forest-900"><?php echo e(cms_content('portfolio', 'intro', 'heading', 'Our Recent Work')); ?></h2>
            <p class="text-sm text-slate-600 mt-3"><?php echo e(cms_content('portfolio', 'intro', 'body', '')); ?></p>
        </div>
        
        <!-- Category Filter Buttons -->
        <div class="flex flex-wrap justify-center gap-4 mb-16 reveal-fade-up">
            <button class="filter-btn active px-6 py-2.5 rounded-xl text-xs font-mono tracking-widest uppercase font-bold bg-forest-900 text-white shadow-md transition-all duration-300" data-filter="all">
                All Projects
            </button>
            <button class="filter-btn px-6 py-2.5 rounded-xl text-xs font-mono tracking-widest uppercase font-bold bg-[#f8fafc] text-slate-600 hover:text-forest-900 transition-all duration-300 border border-slate-200" data-filter="construction">
                Construction Works
            </button>
            <button class="filter-btn px-6 py-2.5 rounded-xl text-xs font-mono tracking-widest uppercase font-bold bg-[#f8fafc] text-slate-600 hover:text-forest-900 transition-all duration-300 border border-slate-200" data-filter="landscaping">
                Landscaping Designs
            </button>
        </div>

        <!-- Project Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $displayProjects = [];
            if (!empty($projects)) {
                foreach ($projects as $project) {
                    $displayProjects[] = [
                        'title' => $project['title'],
                        'category' => $project['category'] ?: 'general',
                        'catName' => $project['category_label'] ?: ucfirst($project['category'] ?: 'Project'),
                        'desc' => $project['description'],
                        'imageUrl' => cms_image_url($project['image_id'], $project['fallback_image']),
                        'location' => $project['location'] ?: 'Mangochi District'
                    ];
                }
            }

            if (empty($displayProjects)) {
                $displayProjects = [
                [
                    'title' => 'Structural Bricklaying & Plastering',
                    'category' => 'construction',
                    'catName' => 'Construction',
                    'desc' => 'High-grade brick masonry, smooth plastering and structural concrete support completed safely.',
                    'imageUrl' => asset_url('images/project1.jpeg'),
                    'location' => 'Mangochi District'
                ],
                [
                    'title' => 'Commercial Concrete Slabs',
                    'category' => 'construction',
                    'catName' => 'Construction',
                    'desc' => 'Solid foundation concrete works cast for heavy-duty commercial complex buildings.',
                    'imageUrl' => asset_url('images/project2.jpeg'),
                    'location' => 'Mangochi District'
                ],
                [
                    'title' => 'Monkey Bay Garden Setup',
                    'category' => 'landscaping',
                    'catName' => 'Landscaping',
                    'desc' => 'Beautiful botanical shade gardens, specialized organic rockeries and flowerbed arrangements.',
                    'imageUrl' => asset_url('images/project3.jpeg'),
                    'location' => 'Mangochi District'
                ],
                [
                    'title' => 'Interlocking Brick Driveway Paving',
                    'category' => 'landscaping',
                    'catName' => 'Landscaping',
                    'desc' => 'Durable paving blocks laid for high-load residential driveway parking spaces.',
                    'imageUrl' => asset_url('images/IMG-20260414-WA0133.jpg.jpeg'),
                    'location' => 'Mangochi District'
                ],
                [
                    'title' => 'Lush Green Sodding & Edging',
                    'category' => 'landscaping',
                    'catName' => 'Landscaping',
                    'desc' => 'Level lawn establishment using premium turf sods, concrete trims, and walkway pavement outlines.',
                    'imageUrl' => asset_url('images/IMG-20260414-WA0118.jpg.jpeg'),
                    'location' => 'Mangochi District'
                ],
                [
                    'title' => 'Corporate Complex Exterior Paving',
                    'category' => 'construction',
                    'catName' => 'Construction',
                    'desc' => 'Masonry brick boundary walls and solid perimeter paths surrounding commercial complex office grounds.',
                    'imageUrl' => asset_url('images/banner1.jpeg'),
                    'location' => 'Mangochi District'
                ],
                [
                    'title' => 'Private Estate Boundary Brickwork',
                    'category' => 'construction',
                    'catName' => 'Construction',
                    'desc' => 'Solid block boundaries and custom brick masonry designs built securely for private estates.',
                    'imageUrl' => asset_url('images/banner5.jpeg'),
                    'location' => 'Mangochi District'
                ],
                [
                    'title' => 'Perimeter Screen & Tree Barriers',
                    'category' => 'landscaping',
                    'catName' => 'Landscaping',
                    'desc' => 'Border tree planning to establish lush green windbreak screens and natural boundary shade.',
                    'imageUrl' => asset_url('images/IMG-20260414-WA0156.jpg.jpeg'),
                    'location' => 'Mangochi District'
                ]
            ];
            }
            foreach ($displayProjects as $index => $proj):
            ?>
                <div class="portfolio-item group bg-white border border-slate-200/60 rounded-2xl overflow-hidden shadow-sm hover:shadow-md hover:border-forest-900/30 transition-all duration-300 reveal-fade-up" 
                     data-category="<?php echo e($proj['category']); ?>"
                     style="transition-delay: <?php echo ($index * 0.05); ?>s;">
                    
                    <div class="relative h-56 overflow-hidden">
                        <img src="<?php echo e($proj['imageUrl']); ?>" alt="<?php echo e($proj['title']); ?>" class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-103">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                        <span class="absolute top-4 left-4 text-xs font-mono font-bold tracking-wider px-3 py-1 rounded bg-forest-900 border border-gold-500 text-white shadow">
                            <?php echo e($proj['catName']); ?>
                        </span>
                    </div>

                    <div class="p-6 space-y-2">
                        <h3 class="text-base font-bold text-forest-900 font-display group-hover:text-forest-800 transition-colors duration-150"><?php echo e($proj['title']); ?></h3>
                        <p class="text-xs text-slate-500 leading-relaxed"><?php echo e($proj['desc']); ?></p>
                        <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[10px] font-mono text-slate-400"><?php echo e($proj['location']); ?></span>
                            <a href="<?php echo url('contact'); ?>" class="inline-flex items-center text-xs font-semibold text-forest-800 hover:text-forest-950 transition-colors duration-150">
                                Inquire Similar &nbsp;&rarr;
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
