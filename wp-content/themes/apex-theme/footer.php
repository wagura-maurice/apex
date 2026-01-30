</div>
    </main>

    <?php
    $apex_request_demo_href = home_url('/contact');
    
    // Helper function to check if link is active
    function apex_footer_is_active($url) {
        $current_url = home_url($_SERVER['REQUEST_URI']);
        $current_path = parse_url($current_url, PHP_URL_PATH);
        $target_path = parse_url($url, PHP_URL_PATH);
        
        // Exact match
        if ($current_path === $target_path) {
            return true;
        }
        
        // Home page special case
        if ($target_path === '/' && $current_path === '/') {
            return true;
        }
        
        // Check if current path starts with target path (for subpages)
        if ($target_path !== '/' && strpos($current_path, $target_path) === 0) {
            return true;
        }
        
        return false;
    }
    ?>

    <footer class="border-t border-slate-200 bg-gradient-to-b from-slate-50 to-slate-100 relative overflow-hidden">
        <!-- CTA Cards Section - Two Card System -->
        <div class="bg-white py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Card 1 - Request Demo (Orange) -->
                    <div class="rounded-2xl bg-gradient-to-br from-orange-400 to-orange-500 p-8 md:p-10 text-white relative overflow-hidden hover:shadow-lg transition-all duration-300">
                        <h3 class="text-2xl md:text-3xl font-bold mb-4 leading-tight text-white">Looking for a banking solution or fintech platform?</h3>
                        <p class="text-white/90 mb-6 leading-relaxed">Apex Softwares is here to support you. Get in touch to discuss a tailored banking or fintech strategy for your business.</p>
                        <a href="<?php echo esc_url($apex_request_demo_href); ?>" class="inline-flex items-center justify-center rounded-full bg-white text-apex-dark px-6 py-3 text-sm font-bold hover:bg-gray-100 transition-all duration-200 shadow-md">
                            Get in Touch
                        </a>
                    </div>
                    
                    <!-- Card 2 - Contact Us (Lighter Blue-Gray) -->
                    <div class="rounded-2xl bg-gradient-to-br from-slate-400 to-slate-500 p-8 md:p-10 text-white relative overflow-hidden hover:shadow-lg transition-all duration-300">
                        <h3 class="text-2xl md:text-3xl font-bold mb-4 leading-tight text-white">Need banking support or IT assistance?</h3>
                        <p class="text-white mb-6 leading-relaxed">For existing customers, visit our support login page and access our wealth of knowledge and expertise.</p>
                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="inline-flex items-center justify-center rounded-full bg-white text-apex-dark px-6 py-3 text-sm font-bold hover:bg-gray-100 transition-all duration-200 shadow-md">
                            Get Support
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Links -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 relative">
            <div class="pointer-events-none absolute -left-24 top-12 h-40 w-40 rounded-full bg-gradient-to-br from-orange-200/40 via-sky-200/30 to-violet-200/40 blur-3xl opacity-60"></div>
            <div class="pointer-events-none absolute -right-24 bottom-16 h-52 w-52 rounded-full bg-gradient-to-br from-violet-200/40 via-sky-200/30 to-orange-200/30 blur-3xl opacity-60"></div>

            <div class="relative grid gap-12 lg:grid-cols-12">
                <div class="lg:col-span-4">
                    <!-- Brand -->
                    <div class="flex items-center gap-4 group">
                        <div class="relative overflow-hidden rounded-2xl shadow-md border border-slate-200">
                            <img src="https://web.archive.org/web/20220401202046im_/https://apex-softwares.com/wp-content/uploads/2017/08/newlogo3.png" alt="Apex Softwares" class="h-12 w-auto transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-r from-apex-orange/30 via-apex-blue/30 to-apex-purple/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500 mix-blend-multiply"></div>
                        </div>
                        <div>
                            <p class="text-lg font-black text-slate-800 group-hover:text-orange-500 transition-colors duration-200">Apex Softwares</p>
                            <p class="text-sm text-slate-400 -mt-0.5">Microfinance &amp; Banking Solutions</p>
                        </div>
                    </div>
                    
                    <p class="mt-6 text-base text-slate-500 leading-relaxed">
                        Our core business delivers comprehensive solutions for financial operations automation, covering retail banking, portfolio management, and deposit accounts.
                    </p>
                    
                    <!-- Newsletter & Social Media Combined -->
                    <div class="mt-6 rounded-2xl border border-slate-200 bg-white/70 backdrop-blur-xl p-6 shadow-sm">
                        <p class="text-sm font-bold text-slate-800 mb-2">Get updates & Follow us</p>
                        <p class="text-xs text-slate-500 mb-4">Industry insights, product updates, and stay connected on social media.</p>
                        
                        <!-- Newsletter Form -->
                        <form class="mb-4" action="#" method="post">
                            <label class="sr-only" for="apex-newsletter-email">Email</label>
                            <div class="flex flex-col gap-2 sm:flex-row">
                                <input id="apex-newsletter-email" name="email" type="email" placeholder="you@company.com" class="flex-1 rounded-lg border border-slate-300 bg-white text-slate-700 placeholder-slate-400 px-3 py-2 text-sm focus:border-orange-400 focus:ring-2 focus:ring-orange-200 transition-all duration-200" />
                                <button type="submit" class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-semibold text-white bg-orange-500 hover:bg-orange-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-400/50 transition-all duration-200">
                                    Subscribe
                                </button>
                            </div>
                        </form>
                        
                        <!-- Social Media Icons -->
                        <div class="grid grid-cols-6 gap-2">
                            <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center py-2 rounded-lg bg-slate-100 hover:bg-orange-500 text-slate-500 hover:text-white transition-colors duration-200 no-underline hover:no-underline">
                                <i class="fab fa-facebook-f text-xs"></i>
                            </a>
                            <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center py-2 rounded-lg bg-slate-100 hover:bg-orange-500 text-slate-500 hover:text-white transition-colors duration-200 no-underline hover:no-underline">
                                <i class="fab fa-x-twitter text-xs"></i>
                            </a>
                            <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center py-2 rounded-lg bg-slate-100 hover:bg-orange-500 text-slate-500 hover:text-white transition-colors duration-200 no-underline hover:no-underline">
                                <i class="fab fa-instagram text-xs"></i>
                            </a>
                            <a href="https://wa.me/" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center py-2 rounded-lg bg-slate-100 hover:bg-orange-500 text-slate-500 hover:text-white transition-colors duration-200 no-underline hover:no-underline">
                                <i class="fab fa-whatsapp text-xs"></i>
                            </a>
                            <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center py-2 rounded-lg bg-slate-100 hover:bg-orange-500 text-slate-500 hover:text-white transition-colors duration-200 no-underline hover:no-underline">
                                <i class="fab fa-linkedin-in text-xs"></i>
                            </a>
                            <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center py-2 rounded-lg bg-slate-100 hover:bg-orange-500 text-slate-500 hover:text-white transition-colors duration-200 no-underline hover:no-underline">
                                <i class="fab fa-youtube text-xs"></i>
                            </a>
                        </div>
                        
                        <p class="mt-3 text-xs text-slate-400">By subscribing you agree to our <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" class="text-slate-500 hover:text-orange-500 hover:underline underline-offset-4 transition-colors duration-200">Privacy Policy</a>.</p>
                    </div>
                </div>

                <div class="lg:col-span-8 overflow-visible">
                    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4 overflow-visible">
                        <!-- About Us -->
                        <div>
                            <p class="text-sm font-bold text-slate-800 mb-4">About Us</p>
                            <ul class="space-y-2">
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/about-us')); ?>">About Apex</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/about-us/our-approach')); ?>">Our Approach</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/about-us/leadership-team')); ?>">Leadership Team</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/about-us/news')); ?>">News & Updates</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/contact')); ?>">Contact Us</a></li>
                            </ul>
                            
                            <!-- Insights (Copy) - Below About Us -->
                            <p class="text-sm font-bold text-slate-800 mb-4 mt-8">Insights</p>
                            <ul class="space-y-2">
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/insights/blog')); ?>">Blog</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/insights/success-stories')); ?>">Success Stories</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/insights/webinars')); ?>">Webinars & Events</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/insights/whitepapers-reports')); ?>">Whitepapers</a></li>
                            </ul>
                        </div>
                        
                        <!-- Solutions -->
                        <div>
                            <p class="text-sm font-bold text-slate-800 mb-4">Solutions</p>
                            <ul class="space-y-2">
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/solutions/overview')); ?>">Overview</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/solutions/core-banking-microfinance')); ?>">Core Banking & Microfinance</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/solutions/mobile-wallet-app')); ?>">Mobile Wallet App</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/solutions/agency-branch-banking')); ?>">Agency & Branch Banking</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/solutions/internet-mobile-banking')); ?>">Internet & Mobile Banking</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/solutions/loan-origination-workflows')); ?>">Loan Origination & Workflows</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/solutions/digital-field-agent')); ?>">Digital Field Agent</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/solutions/enterprise-integration')); ?>">Enterprise Integration</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/solutions/payment-switch-ledger')); ?>">Payment Switch & General Ledger</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/solutions/reporting-analytics')); ?>">Reporting & Analytics</a></li>
                            </ul>
                        </div>
                        
                        <!-- Industry -->
                        <div>
                            <p class="text-sm font-bold text-slate-800 mb-4">Industry</p>
                            <ul class="space-y-2">
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/industry/overview')); ?>">Overview</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/industry/mfis')); ?>">Microfinance (MFIs)</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/industry/credit-unions')); ?>">SACCOs & Credit Unions</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/industry/banks-microfinance')); ?>">Commercial Banks</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/industry/digital-government')); ?>">Digital Government</a></li>
                            </ul>
                            
                            <!-- Quick Links - Below Industry -->
                            <p class="text-sm font-bold text-slate-800 mb-4 mt-8">Quick Links</p>
                            <ul class="space-y-2">
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/careers')); ?>">Careers</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/help-support')); ?>">Help & Support</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/knowledge-base')); ?>">Knowledge Base</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/faq')); ?>">FAQ</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy Policy</a></li>
                                <li><a class="text-slate-500 hover:text-orange-500 transition-colors duration-200 text-sm hover:underline underline-offset-4" href="<?php echo esc_url(home_url('/terms-conditions')); ?>">Terms & Conditions</a></li>
                            </ul>
                        </div>
                        
                        <!-- Get Our App & Certifications -->
                        <div class="overflow-visible">
                            <p class="text-sm font-bold text-slate-800 mb-4 text-center">Get Our App</p>
                            <div class="flex flex-col gap-3 items-center">
                                <a href="https://play.google.com" target="_blank" rel="noopener noreferrer" class="relative group inline-block hover:opacity-90 transition-opacity duration-200">
                                    <img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" alt="Get it on Google Play" class="h-10 w-auto">
                                    <span class="absolute left-1/2 -translate-x-1/2 -top-8 px-2 py-1 bg-slate-800 text-white text-xs rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap pointer-events-none z-10">Get it on Google Play</span>
                                </a>
                                <a href="https://apps.apple.com" target="_blank" rel="noopener noreferrer" class="relative group inline-block hover:opacity-90 transition-opacity duration-200">
                                    <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="Download on App Store" class="h-10 w-auto">
                                    <span class="absolute left-1/2 -translate-x-1/2 -top-8 px-2 py-1 bg-slate-800 text-white text-xs rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap pointer-events-none z-10">Download on App Store</span>
                                </a>
                            </div>
                            
                            <p class="text-sm font-bold text-slate-800 mb-3 mt-6 text-center">Certifications</p>
                            <div class="flex justify-center">
                                <a href="#" class="relative group inline-block hover:opacity-90 transition-opacity duration-200 no-underline hover:no-underline">
                                    <img src="https://www.continualengine.com/wp-content/uploads/2025/01/information-security-management-system-iso-27001_1-transformed.png" alt="ISO Certified" class="h-12 w-auto">
                                    <span class="absolute left-1/2 -translate-x-1/2 top-full mt-2 px-2 py-1 text-xs rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap pointer-events-none z-50" style="background-color: #1e293b !important; color: white !important; padding: 0.25rem 0.5rem; border-radius: 0.375rem;">ISO 27001 Certified</span>
                                </a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="mt-12 flex flex-col gap-4 border-t border-slate-200 pt-8 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between">
                <p class="font-medium text-slate-700">Copyright &copy; <?php echo esc_html(date('Y')); ?> <a href="<?php echo esc_url(home_url('/')); ?>" class="text-slate-700 hover:text-orange-500 hover:underline underline-offset-4 transition-colors duration-200"><?php bloginfo('name'); ?></a>. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'container' => 'div',
                        'container_class' => 'flex items-center gap-6',
                        'items_wrap' => '%3$s',
                        'depth' => 1,
                        'fallback_cb' => false
                    ));
                    ?>
                </div>
                <p class="text-xs text-slate-400 flex items-center gap-1">Built for performance, accessibility, and scale with <i class="fab fa-wordpress text-blue-500"></i> by <a href="https://waguramaurice.com" target="_blank" rel="noopener noreferrer" class="text-slate-400 hover:text-orange-500 hover:underline underline-offset-4 transition-colors duration-200">Wagura Maurice</a></p>
            </div>
        </div>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>