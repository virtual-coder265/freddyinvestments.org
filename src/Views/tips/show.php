<section class="py-20 bg-slate-950 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="<?php echo url('tips'); ?>" class="text-sm text-gold-500 hover:text-gold-400">← Back to Tips</a>
        <?php if (!empty($tip['category'])): ?>
            <span class="block text-xs font-semibold font-mono tracking-widest text-gold-500 uppercase mt-4"><?php echo e($tip['category']); ?></span>
        <?php endif; ?>
        <h1 class="text-4xl font-black font-display mt-2"><?php echo e($tip['title']); ?></h1>
    </div>
</section>

<section class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (!empty($tip['image_id'])): ?>
            <img src="<?php echo e(cms_image_url($tip['image_id'], 'project1.jpeg')); ?>" alt="<?php echo e($tip['title']); ?>" class="w-full rounded-2xl mb-8 max-h-96 object-cover">
        <?php endif; ?>
        <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed">
            <?php echo $tip['content'] ?? ''; ?>
        </div>
    </div>
</section>
