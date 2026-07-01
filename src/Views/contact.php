<!-- Header Hero -->
<section class="relative bg-forest-950 py-20 overflow-hidden border-b border-forest-900/60">
    <div class="absolute inset-0 z-0 opacity-25">
        <img src="<?php echo e(cms_content_image('contact', 'hero', 'background_image', 'hero3.jpeg')); ?>" alt="Contact Banner background" class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-forest-950/70"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mt-6">
        <span class="text-xs font-semibold font-mono tracking-widest text-gold-500 uppercase block"><?php echo e(cms_content('contact', 'hero', 'eyebrow', 'Get Connected')); ?></span>
        <h1 class="text-4xl sm:text-5xl font-black font-display text-white tracking-tight mt-2">
            <?php echo e(cms_content('contact', 'hero', 'heading', 'Secure Contact Portal')); ?>
        </h1>
        <p class="text-slate-300 mt-4 max-w-2xl mx-auto text-sm sm:text-base">
            <?php echo e(cms_content('contact', 'hero', 'body', 'Reach our administrative offices in Monkey Bay. Request detailed pricing estimates or book an on-site consultation.')); ?>
        </p>
    </div>
</section>

<!-- Contact Form & Details Section -->
<section class="py-24 bg-white text-slate-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- Left: Contact Cards (Col span 4) -->
            <div class="lg:col-span-4 space-y-6 reveal-fade-up">
                
                <div class="space-y-2 mb-8">
                    <span class="text-xs font-semibold font-mono tracking-widest text-forest-800 uppercase block">Immediate Assistance</span>
                    <h2 class="text-2xl sm:text-3xl font-black font-display text-forest-900 tracking-tight">Our Offices</h2>
                </div>
                
                <!-- Card 1: Location -->
                <div class="bg-[#f8fafc] p-6 rounded-2xl flex gap-4 border border-slate-100 border-l-4 border-l-forest-800 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-forest-50 flex items-center justify-center shrink-0 text-forest-800">
                        <i data-lucide="map-pin" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-forest-900 uppercase tracking-wider font-display">Office Address</h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed font-medium">
                            <?php echo nl2br(e(cms_setting('company_address', "Box 3514,\nMonkey Bay, Mangochi,\nMalawi"))); ?>
                        </p>
                    </div>
                </div>

                <!-- Card 2: Phone -->
                <div class="bg-[#f8fafc] p-6 rounded-2xl flex gap-4 border border-slate-100 border-l-4 border-l-forest-800 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-forest-50 flex items-center justify-center shrink-0 text-forest-800">
                        <i data-lucide="phone" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-forest-900 uppercase tracking-wider font-display">Phone Lines</h3>
                        <div class="text-xs text-slate-500 mt-2 space-y-1 font-semibold">
                            <?php $phone = cms_setting('company_phone', '+265 (0) 997 991 077'); ?>
                            <?php $phoneSecondary = cms_setting('company_phone_secondary', '+265 (0) 988 481 246'); ?>
                            <a href="<?php echo e(phone_href($phone)); ?>" class="block hover:text-forest-900"><?php echo e($phone); ?></a>
                            <?php if ($phoneSecondary !== ''): ?>
                                <a href="<?php echo e(phone_href($phoneSecondary)); ?>" class="block hover:text-forest-900"><?php echo e($phoneSecondary); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Email -->
                <div class="bg-[#f8fafc] p-6 rounded-2xl flex gap-4 border border-slate-100 border-l-4 border-l-forest-800 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-forest-50 flex items-center justify-center shrink-0 text-forest-800">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-forest-900 uppercase tracking-wider font-display">Official Email</h3>
                        <?php $email = cms_setting('company_email', 'mphasifreddyinvestments@gmail.com'); ?>
                        <a href="mailto:<?php echo e($email); ?>" class="block text-xs text-slate-500 mt-2 hover:text-forest-900 font-semibold break-all">
                            <?php echo e($email); ?>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Right: Quote Request Form (Col span 8) -->
            <div class="lg:col-span-8 reveal-fade-in" style="transition-delay: 0.1s;">
                <div class="quote-request-card">
                    <!-- Form Title bar -->
                    <div class="quote-card-header px-8 py-6 text-center">
                        <h3 class="text-xl font-bold text-white font-display tracking-tight">Get a Free Quotation</h3>
                        <p class="text-xs text-slate-350 mt-1">Tell us about your project and we will get back to you.</p>
                    </div>
                    
                    <div class="px-8 pt-8">
                        <!-- Display Messages -->
                        <?php if (isset($_SESSION['form_success'])): ?>
                            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-800 leading-relaxed mb-6">
                                <?php echo $_SESSION['form_success']; unset($_SESSION['form_success']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['form_errors']['security'])): ?>
                            <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-xs text-red-800 leading-relaxed mb-6">
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

                    <form id="secure-contact-form" action="<?php echo url('contact/submit'); ?>" method="POST" class="p-8 space-y-6">
                        <!-- CSRF Token -->
                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div>
                                <label for="name" class="block text-xs font-mono font-semibold text-slate-600 uppercase mb-2">Full Name *</label>
                                <input type="text" id="name" name="name" 
                                       value="<?php echo isset($old['name']) ? $old['name'] : ''; ?>" 
                                       placeholder="e.g. John Banda" required
                                       class="form-input-corporate w-full px-4 py-3 text-sm">
                                <span class="form-error-msg text-xs text-red-500 mt-1.5 block"><?php echo isset($errors['name']) ? $errors['name'] : ''; ?></span>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone" class="block text-xs font-mono font-semibold text-slate-600 uppercase mb-2">Phone Number *</label>
                                <input type="text" id="phone" name="phone" 
                                       value="<?php echo isset($old['phone']) ? $old['phone'] : ''; ?>" 
                                       placeholder="e.g. +265 997 991 077" required
                                       class="form-input-corporate w-full px-4 py-3 text-sm">
                                <span class="form-error-msg text-xs text-red-500 mt-1.5 block"><?php echo isset($errors['phone']) ? $errors['phone'] : ''; ?></span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-xs font-mono font-semibold text-slate-600 uppercase mb-2">Email Address *</label>
                                <input type="email" id="email" name="email" 
                                       value="<?php echo isset($old['email']) ? $old['email'] : ''; ?>" 
                                       placeholder="e.g. john@example.com" required
                                       class="form-input-corporate w-full px-4 py-3 text-sm">
                                <span class="form-error-msg text-xs text-red-500 mt-1.5 block"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
                            </div>

                            <!-- Service category selection -->
                            <div>
                                <label for="service" class="block text-xs font-mono font-semibold text-slate-600 uppercase mb-2">Service Required *</label>
                                <select id="service" name="service" required
                                        class="form-input-corporate w-full px-4 py-3 text-sm bg-[#f8fafc]">
                                    <option value="" disabled <?php echo !isset($old['service']) ? 'selected' : ''; ?>>Select Category...</option>
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
                                <span class="form-error-msg text-xs text-red-500 mt-1.5 block"><?php echo isset($errors['service']) ? $errors['service'] : ''; ?></span>
                            </div>
                        </div>

                        <!-- Message details -->
                        <div>
                            <label for="message" class="block text-xs font-mono font-semibold text-slate-600 uppercase mb-2">Tell us about your project *</label>
                            <textarea id="message" name="message" rows="4" required
                                      placeholder="Provide details about your project scale, boundaries and goals..."
                                      class="form-input-corporate w-full px-4 py-3 text-sm"><?php echo isset($old['message']) ? $old['message'] : ''; ?></textarea>
                            <span class="form-error-msg text-xs text-red-500 mt-1.5 block"><?php echo isset($errors['message']) ? $errors['message'] : ''; ?></span>
                        </div>

                        <!-- Submit request -->
                        <div class="pt-2">
                            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-4 bg-forest-900 hover:bg-forest-800 text-white font-bold rounded-lg text-sm tracking-wider uppercase transition-all duration-200 cursor-pointer">
                                Submit Request &nbsp; &rarr;
                            </button>
                        </div>

                        <p class="text-xs text-slate-400 text-center flex items-center justify-center gap-1.5 pt-3 border-t border-slate-100">
                            <i data-lucide="lock" class="w-4 h-4 text-slate-400"></i> We respect your privacy.
                        </p>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
