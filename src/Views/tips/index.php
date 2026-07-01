<section class="py-20 bg-slate-950 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-xs font-semibold font-mono tracking-widest text-gold-500 uppercase block">Tips & Insights</span>
        <h1 class="text-4xl font-black font-display mt-2">Construction & Landscaping Blog</h1>
        <p class="text-slate-300 mt-4 max-w-2xl mx-auto">Practical advice and insights from the Freddy Investments team.</p>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (!empty($tips)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($tips as $tip): ?>
                    <article class="border border-slate-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition">
                        <?php if (!empty($tip['image_id'])): ?>
                            <img src="<?php echo e(cms_image_url($tip['image_id'], 'project1.jpeg')); ?>" alt="<?php echo e($tip['title']); ?>" class="w-full h-48 object-cover">
                        <?php endif; ?>
                        <div class="p-6">
                            <?php if (!empty($tip['category'])): ?>
                                <span class="text-xs font-semibold text-forest-800 uppercase"><?php echo e($tip['category']); ?></span>
                            <?php endif; ?>
                            <h2 class="text-xl font-bold text-forest-900 mt-2">
                                <a href="<?php echo url('tips/' . ($tip['slug'] ?? slugify($tip['title']))); ?>" class="hover:text-forest-700">
                                    <?php echo e($tip['title']); ?>
                                </a>
                            </h2>
                            <p class="text-sm text-slate-600 mt-3 line-clamp-3"><?php echo e(strip_tags($tip['content'] ?? '')); ?></p>
                            <a href="<?php echo url('tips/' . ($tip['slug'] ?? slugify($tip['title']))); ?>" class="inline-block mt-4 text-sm font-bold text-forest-800">Read more →</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-16 text-slate-600">
                <p>No tips published yet. Check back soon.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
