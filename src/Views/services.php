<!-- Header Hero -->
<section class="relative bg-forest-950 py-20 overflow-hidden border-b border-forest-900/60">
    <div class="absolute inset-0 z-0 opacity-25">
        <img src="<?php echo e(cms_content_image('services', 'hero', 'background_image', 'banner4.jpeg')); ?>" alt="Services Banner background" class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-forest-950/70"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mt-6">
        <span class="text-xs font-semibold font-mono tracking-widest text-gold-500 uppercase block"><?php echo e(cms_content('services', 'hero', 'eyebrow', 'What We Offer')); ?></span>
        <h1 class="text-4xl sm:text-5xl font-black font-display text-white tracking-tight mt-2">
            <?php echo e(cms_content('services', 'hero', 'heading', 'Our Specialist Services')); ?>
        </h1>
        <p class="text-slate-300 mt-4 max-w-2xl mx-auto text-sm sm:text-base">
            <?php echo e(cms_content('services', 'hero', 'body', 'Providing expert building development and creative botanical landscaping schemas.')); ?>
        </p>
    </div>
</section>

<!-- Services Grid -->
<section class="py-24 bg-white text-slate-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h2 class="text-2xl font-black font-display text-forest-900"><?php echo e(cms_content('services', 'intro', 'heading', 'Comprehensive Construction & Landscaping')); ?></h2>
            <p class="text-sm text-slate-600 mt-3"><?php echo e(cms_content('services', 'intro', 'body', '')); ?></p>
        </div>
        
        <?php if (!empty($services)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($services as $index => $service): ?>
                    <div class="bg-[#f8fafc] border border-slate-100 p-8 rounded-2xl flex flex-col justify-between reveal-fade-up" style="transition-delay: <?php echo ($index * 0.05); ?>s;">
                        <div class="space-y-4">
                            <div class="w-10 h-10 rounded-full bg-forest-50 text-forest-800 flex items-center justify-center">
                                <i data-lucide="<?php echo e($service['icon'] ?: 'briefcase'); ?>" class="w-5 h-5"></i>
                            </div>
                            <h3 class="text-base font-bold text-forest-900 font-display"><?php echo e($service['name']); ?></h3>
                            <p class="text-xs text-slate-500 leading-relaxed"><?php echo e($service['description']); ?></p>
                        </div>
                        <div class="pt-6 mt-6 border-t border-slate-200/50">
                            <a href="<?php echo url('contact'); ?>" class="inline-flex items-center text-xs font-bold text-forest-800 hover:text-forest-900 transition-colors">
                                Book Site Consultation &nbsp;&rarr;
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
        <!-- Segment 1: Building Construction -->
        <div class="mb-24">
            <div class="flex items-center gap-3 mb-12 border-b border-slate-100 pb-4 reveal-fade-up">
                <div class="p-2.5 bg-forest-50 text-forest-800 rounded-xl">
                    <i data-lucide="building" class="w-6 h-6"></i>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black font-display text-forest-900">Building Construction</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                $conList = [
                    ['title' => 'Residential Housing Construction', 'desc' => 'We handle single and multi-story houses, custom residential estates, and complex brick structures.', 'icon' => 'home'],
                    ['title' => 'Commercial Complex Projects', 'desc' => 'We build commercial developments, corporate complexes, and secure perimeter boundaries.', 'icon' => 'building-2'],
                    ['title' => 'Bricklaying, Plastering & Roofing', 'desc' => 'Our master builders provide expert masonry alignment, decorative plastering, and custom truss-roof construction.', 'icon' => 'hammer'],
                    ['title' => 'Concrete Works & Foundations', 'desc' => 'We execute foundation casting, concrete slabs, supporting lintels, and paved bases with technical precision.', 'icon' => 'layers'],
                    ['title' => 'Renovations & Extensions', 'desc' => 'Alterations, additional room structures, and complete modern expansions designed to seamlessly match structural alignments.', 'icon' => 'wrench']
                ];
                foreach ($conList as $index => $item):
                ?>
                    <div class="bg-[#f8fafc] border border-slate-100 p-8 rounded-2xl flex flex-col justify-between reveal-fade-up" style="transition-delay: <?php echo ($index * 0.05); ?>s;">
                        <div class="space-y-4">
                            <div class="w-10 h-10 rounded-full bg-forest-50 text-forest-800 flex items-center justify-center">
                                <i data-lucide="<?php echo $item['icon']; ?>" class="w-5 h-5"></i>
                            </div>
                            <h3 class="text-base font-bold text-forest-900 font-display"><?php echo $item['title']; ?></h3>
                            <p class="text-xs text-slate-500 leading-relaxed"><?php echo $item['desc']; ?></p>
                        </div>
                        <div class="pt-6 mt-6 border-t border-slate-200/50">
                            <a href="<?php echo url('contact'); ?>" class="inline-flex items-center text-xs font-bold text-forest-800 hover:text-forest-900 transition-colors">
                                Book Site Consultation &nbsp;&rarr;
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Segment 2: Landscaping & Gardening -->
        <div>
            <div class="flex items-center gap-3 mb-12 border-b border-slate-100 pb-4 reveal-fade-up">
                <div class="p-2.5 bg-forest-50 text-forest-800 rounded-xl">
                    <i data-lucide="leaf" class="w-6 h-6"></i>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black font-display text-forest-900">Landscaping Services</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                $landList = [
                    ['title' => 'Lawn Establishment & Sodding', 'desc' => 'We level, aerate, and install premium green grass turf sodding, ensuring rich, routine maintenance.', 'icon' => 'flower-2'],
                    ['title' => 'Garden Design & Installation', 'desc' => 'Aesthetic planning, selecting custom flowers, laying organic borders, and implementing balanced flora designs.', 'icon' => 'sprout'],
                    ['title' => 'Paving & Walkway Layouts', 'desc' => 'Precision laying of interlocking paving blocks, durable stone steps, and custom gravel driveway borders.', 'icon' => 'layout-grid'],
                    ['title' => 'Tree Planting & Windbreaks', 'desc' => 'Establishing perimeter tree fences, balance shade, and windbreak barriers tailored for environmental protection.', 'icon' => 'trees'],
                    ['title' => 'Outdoor Space Beautification', 'desc' => 'Complete yard makeovers, incorporating decorative pebbles, paths, and custom environment design upgrades.', 'icon' => 'sparkles']
                ];
                foreach ($landList as $index => $item):
                ?>
                    <div class="bg-[#f8fafc] border border-slate-100 p-8 rounded-2xl flex flex-col justify-between reveal-fade-up" style="transition-delay: <?php echo ($index * 0.05); ?>s;">
                        <div class="space-y-4">
                            <div class="w-10 h-10 rounded-full bg-forest-50 text-forest-800 flex items-center justify-center">
                                <i data-lucide="<?php echo $item['icon']; ?>" class="w-5 h-5"></i>
                            </div>
                            <h3 class="text-base font-bold text-forest-900 font-display"><?php echo $item['title']; ?></h3>
                            <p class="text-xs text-slate-500 leading-relaxed"><?php echo $item['desc']; ?></p>
                        </div>
                        <div class="pt-6 mt-6 border-t border-slate-200/50">
                            <a href="<?php echo url('contact'); ?>" class="inline-flex items-center text-xs font-bold text-forest-800 hover:text-forest-900 transition-colors">
                                Book Site Consultation &nbsp;&rarr;
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</section>
