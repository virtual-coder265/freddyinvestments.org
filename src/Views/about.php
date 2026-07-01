<!-- Header Hero -->
<section class="relative bg-forest-950 py-20 overflow-hidden border-b border-forest-900/60">
    <div class="absolute inset-0 z-0 opacity-25">
        <img src="<?php echo e(cms_content_image('about', 'hero', 'background_image', 'banner2.jpeg')); ?>" alt="About Us Banner background" class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-forest-950/70"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mt-6">
        <span class="text-xs font-semibold font-mono tracking-widest text-gold-500 uppercase block"><?php echo e(cms_content('about', 'hero', 'eyebrow', 'Who We Are')); ?></span>
        <h1 class="text-4xl sm:text-5xl font-black font-display text-white tracking-tight mt-2">
            <?php echo e(cms_content('about', 'hero', 'heading', 'About Freddy Investments')); ?>
        </h1>
        <p class="text-slate-300 mt-4 max-w-2xl mx-auto text-sm sm:text-base">
            <?php echo e(cms_content('about', 'hero', 'body', 'Providing high-quality building construction and expert landscaping services to residential home builders and commercial developers.')); ?>
        </p>
    </div>
</section>

<!-- Overview -->
<section class="py-24 bg-white text-slate-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            
            <!-- Story Left -->
            <div class="space-y-6 reveal-fade-up">
                <span class="text-xs font-semibold font-mono tracking-widest text-forest-800 uppercase block"><?php echo e(cms_content('about', 'story', 'eyebrow', 'Company Story')); ?></span>
                <h2 class="text-3xl font-black font-display text-forest-900 tracking-tight leading-tight">
                    <?php echo e(cms_content('about', 'story', 'heading', 'Dynamic Craftsmanship & Botanical Solutions')); ?>
                </h2>
                <p class="text-sm text-slate-655 leading-relaxed">
                    <?php echo e(cms_content('about', 'story', 'body_one', 'Freddy Investments is a dynamic and forward-thinking company specializing in premium building construction and landscaping services. We are fully committed to delivering high-quality, durable, and aesthetically appealing projects that meet the evolving needs and expectations of our clients.')); ?>
                </p>
                <p class="text-sm text-slate-500 leading-relaxed">
                    <?php echo e(cms_content('about', 'story', 'body_two', 'With a strong focus on on-site craftsmanship, technical innovation, and absolute reliability, Freddy Investments has successfully positioned itself as a trusted partner in transforming spaces.')); ?>
                </p>
            </div>

            <!-- Double Image Feature Right -->
            <div class="relative reveal-fade-in" style="transition-delay: 0.15s;">
                <div class="quote-request-card p-4 overflow-hidden relative z-10">
                    <img src="<?php echo e(cms_content_image('about', 'story', 'image', 'banner5.jpeg')); ?>" alt="Freddy Investments construction team project" class="w-full h-80 object-cover rounded-xl">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Vision & Mission Cards -->
<section class="py-24 bg-sage-alternate border-y border-slate-100 text-slate-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            
            <!-- Vision -->
            <div class="bg-white p-8 sm:p-10 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden group reveal-fade-up">
                <div class="w-12 h-12 rounded-xl bg-forest-50 text-forest-800 flex items-center justify-center mb-6">
                    <i data-lucide="eye" class="w-6 h-6"></i>
                </div>
                <h3 class="text-xl font-bold text-forest-900 font-display mb-4">Our Vision</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    <?php echo e(cms_content('about', 'vision_mission', 'vision', 'To become a leading construction and landscaping company known for excellence, innovation, and sustainable development across Monkey Bay, Mangochi, and all regions in Malawi.')); ?>
                </p>
            </div>

            <!-- Mission -->
            <div class="bg-white p-8 sm:p-10 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden group reveal-fade-up" style="transition-delay: 0.1s;">
                <div class="w-12 h-12 rounded-xl bg-forest-50 text-forest-800 flex items-center justify-center mb-6">
                    <i data-lucide="rocket" class="w-6 h-6"></i>
                </div>
                <h3 class="text-xl font-bold text-forest-900 font-display mb-4">Our Mission</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    <?php echo e(cms_content('about', 'vision_mission', 'mission', 'To provide high-quality construction and landscaping services that combine functionality, durability, and beauty while consistently exceeding client expectations.')); ?>
                </p>
            </div>

        </div>
    </div>
</section>

<!-- Core Values Section -->
<section class="py-24 bg-white text-slate-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-16 reveal-fade-up">
            <span class="text-xs font-semibold font-mono tracking-widest text-forest-800 uppercase block">Our Core Foundation</span>
            <h2 class="text-3xl font-black font-display text-forest-900 tracking-tight mt-2">Core Corporate Values</h2>
        </div>

        <!-- Values Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
            <?php
            $values = [
                ['title' => 'Integrity', 'desc' => 'We operate with absolute honesty and transparency on all estimates.', 'icon' => 'shield'],
                ['title' => 'Quality', 'desc' => 'We deliver workmanship that stands the test of time using premium materials.', 'icon' => 'check-square'],
                ['title' => 'Professionalism', 'desc' => 'We uphold high standards of timeline delivery, safety, and cleaning.', 'icon' => 'briefcase'],
                ['title' => 'Innovation', 'desc' => 'We embrace modern construction techniques and creative landscaping.', 'icon' => 'lightbulb'],
                ['title' => 'Satisfaction', 'desc' => 'Our clients are at the center of everything we plan and construct.', 'icon' => 'heart']
            ];
            foreach ($values as $index => $val):
            ?>
                <div class="bg-[#f8fafc] border border-slate-100 p-6 rounded-2xl text-center flex flex-col items-center reveal-fade-up" style="transition-delay: <?php echo ($index * 0.05); ?>s;">
                    <div class="w-12 h-12 bg-white border border-slate-150 rounded-full flex items-center justify-center mb-4 text-forest-800 shadow-sm">
                        <i data-lucide="<?php echo $val['icon']; ?>" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-sm font-bold text-forest-900 font-display mb-2"><?php echo $val['title']; ?></h3>
                    <p class="text-xs text-slate-500 leading-relaxed"><?php echo $val['desc']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- HSE policy and Team structure -->
<section class="py-24 bg-sage-alternate border-t border-slate-100 text-slate-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            
            <!-- HSE policy Left -->
            <div class="space-y-6 reveal-fade-up">
                <div class="flex items-center gap-3">
                    <i data-lucide="shield-alert" class="w-8 h-8 text-forest-800"></i>
                    <h2 class="text-2xl sm:text-3xl font-black font-display text-forest-900 tracking-tight">HSE Commitment</h2>
                </div>
                <p class="text-sm text-slate-650 leading-relaxed">
                    We prioritize the safety of our workers, clients, and the environment by adhering strictly to code regulations and promoting green garden architectures.
                </p>
                
                <ul class="space-y-3.5 text-xs text-slate-600">
                    <li class="flex items-start">
                        <i data-lucide="check" class="w-4 h-4 text-green-accent mr-3 shrink-0 mt-0.5"></i>
                        <span>Adhering to safety regulations and structural building standards in Malawi.</span>
                    </li>
                    <li class="flex items-start">
                        <i data-lucide="check" class="w-4 h-4 text-green-accent mr-3 shrink-0 mt-0.5"></i>
                        <span>Providing proper safety equipment (helmets, protective gear) on-site.</span>
                    </li>
                    <li class="flex items-start">
                        <i data-lucide="check" class="w-4 h-4 text-green-accent mr-3 shrink-0 mt-0.5"></i>
                        <span>Promoting environmentally friendly techniques and tree screen barriers.</span>
                    </li>
                    <li class="flex items-start">
                        <i data-lucide="check" class="w-4 h-4 text-green-accent mr-3 shrink-0 mt-0.5"></i>
                        <span>Ensuring clean, organic, and organized workspaces at the end of each day.</span>
                    </li>
                </ul>
            </div>

            <!-- Team Roles right -->
            <div class="space-y-6 reveal-fade-up" style="transition-delay: 0.1s;">
                <div class="flex items-center gap-3">
                    <i data-lucide="users" class="w-8 h-8 text-forest-800"></i>
                    <h2 class="text-2xl sm:text-3xl font-black font-display text-forest-900 tracking-tight">Our Workforce</h2>
                </div>
                <p class="text-sm text-slate-650 leading-relaxed">
                    Our team consists of dedicated local professionals committed to transforming your coordinates.
                </p>
                
                <div class="space-y-4">
                    <div class="bg-white p-4 rounded-xl flex items-center justify-between border border-slate-100 shadow-sm">
                        <span class="font-bold text-forest-900 text-xs">Skilled Builders & Artisans</span>
                        <span class="text-[10px] text-slate-400 font-mono">Masonry, Bricklaying, Plastering</span>
                    </div>
                    <div class="bg-white p-4 rounded-xl flex items-center justify-between border border-slate-100 shadow-sm">
                        <span class="font-bold text-forest-900 text-xs">Landscaping Specialists</span>
                        <span class="text-[10px] text-slate-400 font-mono">Turf sodding & Garden Designers</span>
                    </div>
                    <div class="bg-white p-4 rounded-xl flex items-center justify-between border border-slate-100 shadow-sm">
                        <span class="font-bold text-forest-900 text-xs">Project Supervisors</span>
                        <span class="text-[10px] text-slate-400 font-mono">Quality Checks & Deadlines control</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
