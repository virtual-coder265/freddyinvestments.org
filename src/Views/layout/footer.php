    </main>

    <?php
    $siteName = cms_setting('site_name', 'Freddy Investments');
    $footerDescription = cms_setting('footer_description', 'Building excellence and landscaping design through high-quality construction and landscaping services.');
    $companyAddress = cms_setting('company_address', 'Box 3514, Monkey Bay, Mangochi');
    $companyPhone = cms_setting('company_phone', '+265 (0) 997 991 077');
    $companyPhoneSecondary = cms_setting('company_phone_secondary', '+265 (0) 988 481 246');
    $companyEmail = cms_setting('company_email', 'mphasifreddyinvestments@gmail.com');
    $whatsappNumber = preg_replace('/\D+/', '', cms_setting('whatsapp_number', '265997991077'));
    $facebookUrl = cms_setting('social_facebook', '#') ?: '#';
    $instagramUrl = cms_setting('social_instagram', '#') ?: '#';
    $footerServices = $services ?? [];
    ?>

    <!-- Footer Section -->
    <footer class="bg-forest-950 border-t border-forest-900/60 pt-16 pb-8 text-slate-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                
                <!-- Col 1: About Company -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <img class="h-10 w-auto" src="<?php echo asset_url('images/logo.png'); ?>" alt="Freddy Investments Logo">
                        <span class="text-lg font-bold font-display tracking-tight text-white uppercase"><?php echo e($siteName); ?></span>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-400">
                        <?php echo e($footerDescription); ?>
                    </p>
                    <div class="flex gap-4">
                        <a href="<?php echo e($facebookUrl); ?>" class="hover:text-gold-500 text-slate-500 transition-colors duration-200" aria-label="Facebook">
                            <i data-lucide="facebook" class="w-5 h-5"></i>
                        </a>
                        <a href="<?php echo e($instagramUrl); ?>" class="hover:text-gold-500 text-slate-500 transition-colors duration-200" aria-label="Instagram">
                            <i data-lucide="instagram" class="w-5 h-5"></i>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Navigation Links -->
                <div>
                    <h3 class="text-sm font-semibold text-slate-100 uppercase tracking-widest mb-6 font-display border-l-2 border-gold-500 pl-3">Quick Links</h3>
                    <ul class="space-y-4 text-sm">
                        <li>
                            <a href="<?php echo url(); ?>" class="hover:text-gold-500 transition-colors duration-150 flex items-center">
                                <i data-lucide="chevron-right" class="w-4 h-4 mr-2 text-slate-700"></i> Home
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo url('about'); ?>" class="hover:text-gold-500 transition-colors duration-150 flex items-center">
                                <i data-lucide="chevron-right" class="w-4 h-4 mr-2 text-slate-700"></i> About Us
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo url('services'); ?>" class="hover:text-gold-500 transition-colors duration-150 flex items-center">
                                <i data-lucide="chevron-right" class="w-4 h-4 mr-2 text-slate-700"></i> Services
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo url('portfolio'); ?>" class="hover:text-gold-500 transition-colors duration-150 flex items-center">
                                <i data-lucide="chevron-right" class="w-4 h-4 mr-2 text-slate-700"></i> Projects
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo url('#approach'); ?>" class="hover:text-gold-500 transition-colors duration-150 flex items-center">
                                <i data-lucide="chevron-right" class="w-4 h-4 mr-2 text-slate-700"></i> Our Approach
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo url('contact'); ?>" class="hover:text-gold-500 transition-colors duration-150 flex items-center">
                                <i data-lucide="chevron-right" class="w-4 h-4 mr-2 text-slate-700"></i> Contact Us
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Services Grid -->
                <div>
                    <h3 class="text-sm font-semibold text-slate-100 uppercase tracking-widest mb-6 font-display border-l-2 border-gold-500 pl-3">Services</h3>
                    <ul class="space-y-4 text-sm">
                        <?php if (!empty($footerServices)): ?>
                            <?php foreach (array_slice($footerServices, 0, 5) as $service): ?>
                                <li>
                                    <a href="<?php echo url('services'); ?>" class="hover:text-gold-500 transition-colors duration-150 flex items-center">
                                        <i data-lucide="<?php echo e($service['icon'] ?: 'chevron-right'); ?>" class="w-4 h-4 mr-2 text-slate-700"></i> <?php echo e($service['name']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><a href="<?php echo url('services'); ?>" class="hover:text-gold-500 transition-colors duration-150 flex items-center"><i data-lucide="building" class="w-4 h-4 mr-2 text-slate-700"></i> Building Construction</a></li>
                            <li><a href="<?php echo url('services'); ?>" class="hover:text-gold-500 transition-colors duration-150 flex items-center"><i data-lucide="leaf" class="w-4 h-4 mr-2 text-slate-700"></i> Landscaping Services</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Col 4: Contacts -->
                <div class="space-y-4 text-sm">
                    <h3 class="text-sm font-semibold text-slate-100 uppercase tracking-widest mb-6 font-display border-l-2 border-gold-500 pl-3">Contact Information</h3>
                    
                    <div class="flex items-start gap-3">
                        <i data-lucide="map-pin" class="w-5 h-5 text-gold-500 shrink-0 mt-0.5"></i>
                        <span><?php echo nl2br(e($companyAddress)); ?></span>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <i data-lucide="phone" class="w-5 h-5 text-gold-500 shrink-0"></i>
                        <span class="space-y-1 block">
                            <a href="<?php echo e(phone_href($companyPhone)); ?>" class="hover:text-gold-500 transition-colors duration-150"><?php echo e($companyPhone); ?></a><br>
                            <?php if ($companyPhoneSecondary !== ''): ?>
                                <a href="<?php echo e(phone_href($companyPhoneSecondary)); ?>" class="hover:text-gold-500 transition-colors duration-150"><?php echo e($companyPhoneSecondary); ?></a>
                            <?php endif; ?>
                        </span>
                    </div>

                    <div class="flex items-center gap-3">
                        <i data-lucide="mail" class="w-5 h-5 text-gold-500 shrink-0"></i>
                        <a href="mailto:<?php echo e($companyEmail); ?>" class="hover:text-gold-500 break-all transition-colors duration-150"><?php echo e($companyEmail); ?></a>
                    </div>
                </div>

            </div>
            
            <!-- Bottom Border Row -->
            <div class="border-t border-forest-900/60 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; <?php echo date('Y'); ?> <?php echo e($siteName); ?>. All Rights Reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-gold-500 transition-colors duration-150">Privacy Policy</a>
                    <a href="#" class="hover:text-gold-500 transition-colors duration-150">Terms of Service</a>
                    <a href="#top" class="hover:text-gold-500 transition-colors duration-150 flex items-center gap-1">
                        Back to Top <i data-lucide="arrow-up" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Action Button with Ripple Pulse aligned to prototype.png -->
    <a href="https://wa.me/<?php echo e($whatsappNumber); ?>" target="_blank" rel="noopener noreferrer" class="whatsapp-float" aria-label="Chat on WhatsApp">
        <div class="whatsapp-pulse"></div>
        <!-- WhatsApp SVG Icon -->
        <svg class="w-7 h-7 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.5-5.739-1.446L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.963C16.388 2.016 13.916.993 11.3.993c-5.437 0-9.863 4.373-9.867 9.803-.001 1.73.457 3.419 1.32 4.937L1.838 21.84l6.23-1.62c-1.5-.92-1.63-1.04-1.42-1.066zM17.487 14.39c-.3-.15-1.774-.875-2.05-.975-.276-.1-.476-.15-.676.15-.2.3-.775.975-.95 1.175-.175.2-.35.225-.65.075-.3-.15-1.267-.467-2.414-1.49-.893-.797-1.496-1.782-1.672-2.08-.175-.3-.018-.463.13-.61.135-.133.3-.35.45-.525.15-.175.2-.3.3-.5s.05-.375-.025-.525c-.075-.15-.676-1.63-.925-2.23-.24-.58-.48-.5-.66-.51-.17-.01-.37-.01-.57-.01-.2 0-.525.075-.8.375-.275.3-1.05 1.025-1.05 2.5s1.075 2.9 1.225 3.1c.15.2 2.11 3.22 5.11 4.52.714.31 1.27.496 1.703.633.715.227 1.365.195 1.88.117.574-.088 1.774-.725 2.025-1.425.25-.7.25-1.3.175-1.425-.076-.12-.276-.2-.576-.35z"/>
        </svg>
    </a>

    <!-- Initialize Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
    
    <!-- Main JS Application Logic -->
    <script src="<?php echo asset_url('js/main.js'); ?>"></script>
</body>
</html>
